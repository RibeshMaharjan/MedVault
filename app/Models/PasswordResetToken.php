<?php

namespace App\Models;

use App\Core\Model;

class PasswordResetToken extends Model
{
    protected string $table = 'password_reset_tokens';
    protected string $primaryKey = 'id';

    public function createForUser(int $userId, string $tokenHash, string $expiresAt): int
    {
        return $this->insert([
            'user_id' => $userId,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt,
        ]);
    }

    public function findValid(string $tokenHash): ?array
    {
        $row = $this->query(
            'SELECT * FROM password_reset_tokens
             WHERE token_hash = :token_hash AND used_at IS NULL AND expires_at > :now
             LIMIT 1',
            ['token_hash' => $tokenHash, 'now' => date('Y-m-d H:i:s')]
        )->fetch();

        return $row ?: null;
    }

    public function hasRecentForUser(int $userId, string $since): bool
    {
        return (bool) $this->query(
            'SELECT 1 FROM password_reset_tokens
             WHERE user_id = :user_id AND created_at >= :since
             LIMIT 1',
            ['user_id' => $userId, 'since' => $since]
        )->fetchColumn();
    }

    public function invalidateForUser(int $userId): void
    {
        $this->query(
            'UPDATE password_reset_tokens SET used_at = :now
             WHERE user_id = :user_id AND used_at IS NULL',
            ['now' => date('Y-m-d H:i:s'), 'user_id' => $userId]
        );
    }

    public function consume(string $tokenHash): bool
    {
        return $this->query(
            'UPDATE password_reset_tokens SET used_at = :now
             WHERE token_hash = :token_hash AND used_at IS NULL AND expires_at > :now_check',
            [
                'now' => date('Y-m-d H:i:s'),
                'token_hash' => $tokenHash,
                'now_check' => date('Y-m-d H:i:s'),
            ]
        )->rowCount() === 1;
    }

    public function deleteExpired(): void
    {
        $this->query(
            'DELETE FROM password_reset_tokens WHERE expires_at <= :now OR used_at IS NOT NULL',
            ['now' => date('Y-m-d H:i:s')]
        );
    }
}
