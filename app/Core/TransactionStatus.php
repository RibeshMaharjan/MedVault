<?php

namespace App\Core;

class TransactionStatus
{
    public const STATUSES = ['pending', 'completed', 'cancelled'];

    public static function isValid(string $status): bool
    {
        return in_array($status, self::STATUSES, true);
    }
}
