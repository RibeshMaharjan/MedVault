<?php

namespace Tests\Integration;

use App\Controllers\AuthController;
use App\Core\Database;
use App\Core\Mail\MailerInterface;
use App\Models\PasswordResetToken;
use PDO;
use PHPUnit\Framework\TestCase;

class PasswordResetFlowTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pdo = Database::getInstance()->getConnection();
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS role (
                user_id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                role TEXT DEFAULT "user"
            )'
        );
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS password_reset_tokens (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                token_hash TEXT UNIQUE NOT NULL,
                expires_at DATETIME NOT NULL,
                used_at DATETIME,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )'
        );
        $this->pdo->exec('DELETE FROM password_reset_tokens');
        $_ENV['APP_URL'] = 'http://medvault.test';
        $_POST = [];
    }

    public function testResetRequestCreatesHashedTokenAndSendsLink(): void
    {
        $userId = $this->createDatabaseUser('owner@example.com');
        $mailer = new RecordingMailer();
        $_POST = ['email' => 'owner@example.com'];

        $this->expectRedirect(
            fn() => (new AuthController($mailer))->sendResetLink(),
            '/forgot-password'
        );

        $this->assertCount(1, $mailer->messages);
        parse_str((string) parse_url($mailer->messages[0]['url'], PHP_URL_QUERY), $query);
        $this->assertMatchesRegularExpression('/^[a-f0-9]{64}$/', $query['token']);

        $stored = $this->pdo->query(
            "SELECT * FROM password_reset_tokens WHERE user_id = {$userId}"
        )->fetch();
        $this->assertSame(hash('sha256', $query['token']), $stored['token_hash']);
        $this->assertNotSame($query['token'], $stored['token_hash']);
    }

    public function testUnknownEmailUsesGenericResponseWithoutSendingMail(): void
    {
        $mailer = new RecordingMailer();
        $_POST = ['email' => 'missing@example.com'];

        $message = $this->expectRedirect(
            fn() => (new AuthController($mailer))->sendResetLink(),
            '/forgot-password'
        );

        $this->assertStringContainsString('If an account exists', $message);
        $this->assertCount(0, $mailer->messages);
        $this->assertSame(0, (int) $this->pdo->query('SELECT COUNT(*) FROM password_reset_tokens')->fetchColumn());
    }

    public function testRecentRequestDoesNotSendAnotherEmail(): void
    {
        $userId = $this->createDatabaseUser('cooldown@example.com');
        (new PasswordResetToken())->createForUser(
            $userId,
            hash('sha256', bin2hex(random_bytes(32))),
            date('Y-m-d H:i:s', time() + 3600)
        );
        $mailer = new RecordingMailer();
        $_POST = ['email' => 'cooldown@example.com'];

        $this->expectRedirect(
            fn() => (new AuthController($mailer))->sendResetLink(),
            '/forgot-password'
        );

        $this->assertCount(0, $mailer->messages);
        $this->assertSame(1, (int) $this->pdo->query('SELECT COUNT(*) FROM password_reset_tokens')->fetchColumn());
    }

    public function testMailFailureDoesNotExposeErrorAndInvalidatesToken(): void
    {
        $this->createDatabaseUser('mail-error@example.com');
        $_POST = ['email' => 'mail-error@example.com'];

        $message = $this->expectRedirect(
            fn() => (new AuthController(new FailingMailer()))->sendResetLink(),
            '/forgot-password'
        );

        $this->assertStringContainsString('If an account exists', $message);
        $this->assertStringNotContainsString('SMTP', $message);
        $this->assertSame(
            0,
            (int) $this->pdo->query('SELECT COUNT(*) FROM password_reset_tokens WHERE used_at IS NULL')->fetchColumn()
        );
    }

    public function testValidTokenResetsPasswordAndCannotBeReused(): void
    {
        $userId = $this->createDatabaseUser('admin@example.com', 'admin');
        $token = bin2hex(random_bytes(32));
        (new PasswordResetToken())->createForUser(
            $userId,
            hash('sha256', $token),
            date('Y-m-d H:i:s', time() + 3600)
        );

        $_POST = [
            'token' => $token,
            'password' => 'NewPassword1',
            'password_confirmation' => 'NewPassword1',
        ];

        $this->expectRedirect(
            fn() => (new AuthController(new RecordingMailer()))->resetPassword(),
            '/login'
        );

        $hash = $this->pdo->query("SELECT password FROM role WHERE user_id = {$userId}")->fetchColumn();
        $this->assertTrue(password_verify('NewPassword1', $hash));
        $this->assertNull((new PasswordResetToken())->findValid(hash('sha256', $token)));
    }

    public function testExpiredTokenIsRejected(): void
    {
        $userId = $this->createDatabaseUser('expired@example.com');
        $token = bin2hex(random_bytes(32));
        (new PasswordResetToken())->createForUser(
            $userId,
            hash('sha256', $token),
            date('Y-m-d H:i:s', time() - 60)
        );
        $_POST = [
            'token' => $token,
            'password' => 'NewPassword1',
            'password_confirmation' => 'NewPassword1',
        ];

        $this->expectRedirect(
            fn() => (new AuthController(new RecordingMailer()))->resetPassword(),
            '/forgot-password'
        );
    }

    public function testWeakAndMismatchedPasswordsAreRejected(): void
    {
        $userId = $this->createDatabaseUser('validation@example.com');
        $token = bin2hex(random_bytes(32));
        (new PasswordResetToken())->createForUser(
            $userId,
            hash('sha256', $token),
            date('Y-m-d H:i:s', time() + 3600)
        );

        $_POST = ['token' => $token, 'password' => 'weak', 'password_confirmation' => 'weak'];
        $this->expectRedirect(
            fn() => (new AuthController(new RecordingMailer()))->resetPassword(),
            '/reset-password'
        );

        $_POST = ['token' => $token, 'password' => 'NewPassword1', 'password_confirmation' => 'Different1'];
        $this->expectRedirect(
            fn() => (new AuthController(new RecordingMailer()))->resetPassword(),
            '/reset-password'
        );

        $this->assertNotNull((new PasswordResetToken())->findValid(hash('sha256', $token)));
    }

    private function expectRedirect(callable $action, string $path): string
    {
        try {
            $action();
            $this->fail('Expected a redirect.');
        } catch (\RuntimeException $e) {
            $this->assertStringContainsString("Redirect to {$path}", $e->getMessage());
            return $e->getMessage();
        }
    }

    private function createDatabaseUser(string $email, string $role = 'user'): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO role (name, email, password, role) VALUES (:name, :email, :password, :role)'
        );
        $stmt->execute([
            'name' => 'Reset User',
            'email' => $email,
            'password' => password_hash('OldPassword1', PASSWORD_DEFAULT),
            'role' => $role,
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}

class RecordingMailer implements MailerInterface
{
    public array $messages = [];

    public function sendPasswordReset(string $recipientEmail, string $recipientName, string $resetUrl): void
    {
        $this->messages[] = [
            'email' => $recipientEmail,
            'name' => $recipientName,
            'url' => $resetUrl,
        ];
    }
}

class FailingMailer implements MailerInterface
{
    public function sendPasswordReset(string $recipientEmail, string $recipientName, string $resetUrl): void
    {
        throw new \RuntimeException('SMTP connection failed');
    }
}
