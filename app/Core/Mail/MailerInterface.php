<?php

namespace App\Core\Mail;

interface MailerInterface
{
    public function sendPasswordReset(string $recipientEmail, string $recipientName, string $resetUrl): void;
}
