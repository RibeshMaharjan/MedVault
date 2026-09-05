<?php

namespace App\Core\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

class GmailMailer implements MailerInterface
{
    public function sendPasswordReset(string $recipientEmail, string $recipientName, string $resetUrl): void
    {
        $username = trim((string) ($_ENV['MAIL_USERNAME'] ?? ''));
        $password = (string) ($_ENV['MAIL_PASSWORD'] ?? '');
        $from = trim((string) ($_ENV['MAIL_FROM_ADDRESS'] ?? $username));

        if ($username === '' || $password === '' || $from === '') {
            throw new RuntimeException('Mail credentials are not configured.');
        }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) ($_ENV['MAIL_PORT'] ?? 587);
        $mail->Timeout = 10;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;

        $mail->setFrom($from, $_ENV['MAIL_FROM_NAME'] ?? 'MedVault');
        $mail->addAddress($recipientEmail, $recipientName);
        $mail->isHTML(true);
        $mail->Subject = 'Reset your MedVault password';

        $safeName = htmlspecialchars($recipientName, ENT_QUOTES, 'UTF-8');
        $safeUrl = htmlspecialchars($resetUrl, ENT_QUOTES, 'UTF-8');
        $mail->Body = <<<HTML
            <p>Hello {$safeName},</p>
            <p>We received a request to reset your MedVault password.</p>
            <p><a href="{$safeUrl}">Reset your password</a></p>
            <p>This link expires in 60 minutes and can be used once. If you did not request it, you can ignore this email.</p>
            HTML;
        $mail->AltBody = "Reset your MedVault password using this link (valid for 60 minutes): {$resetUrl}";
        $mail->send();
    }
}
