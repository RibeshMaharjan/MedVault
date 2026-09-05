<?php

namespace App\Core;

class VerificationDocument
{
    public static function storageDirectory(): string
    {
        return dirname(__DIR__, 2) . '/storage/verification-documents';
    }

    public static function store(array $upload, int $pharmacyId, string $extension): ?string
    {
        $directory = self::storageDirectory();
        if (!is_dir($directory) && !mkdir($directory, 0750, true) && !is_dir($directory)) {
            return null;
        }

        $filename = $pharmacyId . '_' . bin2hex(random_bytes(16)) . '.' . $extension;
        $target = $directory . '/' . $filename;
        if (!move_uploaded_file($upload['tmp_name'], $target)) {
            return null;
        }

        return 'verification-documents/' . $filename;
    }

    public static function resolve(?string $storedPath): ?string
    {
        if (!$storedPath) {
            return null;
        }

        $filename = basename($storedPath);
        if ($filename === '' || !preg_match('/^[A-Za-z0-9._-]+$/', $filename)) {
            return null;
        }

        $candidates = [
            self::storageDirectory() . '/' . $filename,
            dirname(__DIR__, 2) . '/public/uploads/documents/' . $filename,
        ];
        foreach ($candidates as $candidate) {
            if (is_file($candidate) && is_readable($candidate)) {
                return $candidate;
            }
        }

        return null;
    }
}
