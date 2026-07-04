<?php

namespace App\Models;

use App\Core\Model;

class Pharmacy extends Model
{
    protected string $table = 'tbl_pharmacy';
    protected string $primaryKey = 'pharmacy_id';

    public function createMinimal(int $pharmacyId, string $name, string $email): bool
    {
        $sql = "INSERT INTO {$this->table} (pharmacy_id, pharmacy_name, email) VALUES (:pharmacy_id, :pharmacy_name, :email)";
        $this->query($sql, [
            'pharmacy_id' => $pharmacyId,
            'pharmacy_name' => $name,
            'email' => $email,
        ]);
        return true;
    }

    public function hasBusinessRecords(int $pharmacyId): bool
    {
        $tables = [
            'user_category_tbl',
            'user_medicine_tbl',
            'user_order_tbl',
            'user_sales_tbl',
        ];

        foreach ($tables as $table) {
            $sql = "SELECT COUNT(*) as count FROM {$table} WHERE pharmacy_id = :pharmacy_id";
            if ((int) $this->query($sql, ['pharmacy_id' => $pharmacyId])->fetch()['count'] > 0) {
                return true;
            }
        }

        return false;
    }

    public function recent(int $limit = 4): array
    {
        $limit = max(1, $limit);
        $sql = "SELECT p.*, r.name, r.email as user_email
                FROM {$this->table} p JOIN role r ON p.pharmacy_id = r.user_id
                ORDER BY p.pharmacy_id DESC LIMIT {$limit}";
        return $this->query($sql)->fetchAll();
    }

    public function pendingVerifications(int $limit = 5): array
    {
        $limit = max(1, $limit);
        $sql = "SELECT p.*, r.name, r.email as user_email
                FROM {$this->table} p JOIN role r ON p.pharmacy_id = r.user_id
                WHERE p.verification_request_date IS NOT NULL AND p.isverified = 0
                ORDER BY p.verification_request_date DESC LIMIT {$limit}";
        return $this->query($sql)->fetchAll();
    }
}
