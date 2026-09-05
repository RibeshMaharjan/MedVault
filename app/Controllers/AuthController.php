<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Mail\GmailMailer;
use App\Core\Mail\MailerInterface;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\PasswordResetToken;

class AuthController extends Controller
{
    private User $userModel;
    private Pharmacy $pharmacyModel;
    private PasswordResetToken $passwordResetModel;
    private MailerInterface $mailer;

    public function __construct(?MailerInterface $mailer = null)
    {
        parent::__construct();
        $this->userModel = new User();
        $this->pharmacyModel = new Pharmacy();
        $this->passwordResetModel = new PasswordResetToken();
        $this->mailer = $mailer ?? new GmailMailer();
    }

    public function showLogin(): void
    {
        if ($this->session->isAuth()) {
            $role = $this->session->role();
            if ($role === 'admin') {
                $this->redirect('/admin/dashboard', 'Already Logged In');
            } else {
                $pharmacyId = $this->session->pharmacyId() ?? 0;
                $destination = $this->pharmacyModel->isVerified($pharmacyId)
                    ? '/pharmacy/dashboard'
                    : '/pharmacy/profile';
                $this->redirect($destination, 'Already Logged In');
            }
        }

        $this->view('auth/login');
    }

    public function login(): void
    {
        $email = $this->validate($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->redirect('/login', 'Fill all the Fields');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $this->redirect('/login', 'Invalid Email or Password');
        }

        if (!password_verify($password, $user['password'])) {
            $this->redirect('/login', 'Invalid Email or Password');
        }

        $this->session->setAuth([
            'name' => $user['name'],
            'user_id' => $user['user_id'],
            'email' => $user['email'],
        ], $user['role']);

        if ($user['role'] === 'admin') {
            $this->redirect('/admin/dashboard', 'Logged In Successfully');
        } else {
            $destination = $this->pharmacyModel->isVerified((int) $user['user_id'])
                ? '/pharmacy/dashboard'
                : '/pharmacy/profile';
            $message = $destination === '/pharmacy/profile'
                ? 'Logged in. Submit your pharmacy verification to unlock all features.'
                : 'Logged In Successfully';
            $this->redirect($destination, $message);
        }
    }

    public function register(): void
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $this->redirect('/login', 'Fill all the Fields');
        }

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $this->redirect('/login', 'Only letters and white space allowed');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/login', 'Invalid email format');
        }

        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        if (!preg_match($pattern, $password)) {
            $this->redirect('/login', 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters');
        }

        if ($password !== $repassword) {
            $this->redirect('/login', 'Password Does Not Match');
        }

        // Check if email exists
        $existing = $this->userModel->findByEmail($email);
        if ($existing) {
            $this->redirect('/login', 'Email Already Exists');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $this->userModel->beginTransaction();
            $userId = $this->userModel->create($name, $email, $passwordHash, 'user');
            $this->pharmacyModel->createMinimal($userId, $name, $email);
            $this->userModel->commit();
        } catch (\Throwable $e) {
            $this->userModel->rollBack();
            error_log('Registration failed: ' . $e->getMessage());
            $this->redirect('/login', 'Registration failed. Please try again.');
        }

        $this->redirect('/login', 'Registration Successful!');
    }

    public function showForgotPassword(): void
    {
        $this->view('auth/forgot-password');
    }

    public function sendResetLink(): void
    {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $response = 'If an account exists for that email, a password reset link has been sent.';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect('/forgot-password', $response);
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            $this->redirect('/forgot-password', $response);
        }

        $tooSoon = true;
        try {
            $this->passwordResetModel->deleteExpired();
            $cooldownStart = date('Y-m-d H:i:s', time() - 60);
            $tooSoon = $this->passwordResetModel->hasRecentForUser((int) $user['user_id'], $cooldownStart);
        } catch (\Throwable $e) {
            error_log('Password reset lookup failed: ' . $e->getMessage());
        }

        if ($tooSoon) {
            $this->redirect('/forgot-password', $response);
        }

        try {
            $this->passwordResetModel->invalidateForUser((int) $user['user_id']);
            $token = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $token);
            $expiresAt = date('Y-m-d H:i:s', time() + 3600);
            $this->passwordResetModel->createForUser((int) $user['user_id'], $tokenHash, $expiresAt);

            $baseUrl = rtrim((string) ($_ENV['APP_URL'] ?? ''), '/');
            if ($baseUrl === '') {
                throw new \RuntimeException('APP_URL is not configured.');
            }

            $resetUrl = $baseUrl . '/reset-password?token=' . rawurlencode($token);
            $this->mailer->sendPasswordReset($user['email'], $user['name'], $resetUrl);
        } catch (\Throwable $e) {
            if (isset($user['user_id'])) {
                try {
                    $this->passwordResetModel->invalidateForUser((int) $user['user_id']);
                } catch (\Throwable) {
                    // Keep the public response generic even if cleanup fails.
                }
            }
            error_log('Password reset email failed: ' . $e->getMessage());
        }

        $this->redirect('/forgot-password', $response);
    }

    public function showResetPassword(): void
    {
        $token = $_GET['token'] ?? '';
        $valid = $this->validTokenFormat($token)
            && $this->passwordResetModel->findValid(hash('sha256', $token)) !== null;

        $this->view('auth/reset-password', [
            'token' => $valid ? $token : '',
            'valid' => $valid,
        ]);
    }

    public function resetPassword(): void
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmation = $_POST['password_confirmation'] ?? '';
        $redirectUrl = '/reset-password?token=' . rawurlencode($token);

        if (!$this->validTokenFormat($token)) {
            $this->redirect('/forgot-password', 'This password reset link is invalid or has expired.');
        }

        $reset = $this->passwordResetModel->findValid(hash('sha256', $token));
        if (!$reset) {
            $this->redirect('/forgot-password', 'This password reset link is invalid or has expired.');
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $this->redirect($redirectUrl, 'Password must contain uppercase, lowercase, a number, and at least 8 characters.');
        }

        if ($password !== $confirmation) {
            $this->redirect($redirectUrl, 'Passwords do not match.');
        }

        try {
            $this->userModel->beginTransaction();
            if (!$this->passwordResetModel->consume(hash('sha256', $token))) {
                throw new \RuntimeException('Reset token is no longer valid.');
            }
            $this->userModel->updatePassword(
                (int) $reset['user_id'],
                password_hash($password, PASSWORD_DEFAULT)
            );
            $this->passwordResetModel->invalidateForUser((int) $reset['user_id']);
            $this->userModel->commit();
        } catch (\Throwable $e) {
            $this->userModel->rollBack();
            error_log('Password reset failed: ' . $e->getMessage());
            $this->redirect('/forgot-password', 'This password reset link is invalid or has expired.');
        }

        $this->redirect('/login', 'Password reset successful. You can now sign in.');
    }

    private function validTokenFormat(string $token): bool
    {
        return preg_match('/^[a-f0-9]{64}$/', $token) === 1;
    }

    public function logout(): void
    {
        $this->session->destroy();
        $this->redirect('/login', 'Logged Out Successfully');
    }
}
