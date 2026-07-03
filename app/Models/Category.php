<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    protected string $table = 'user_category_tbl';
    protected string $primaryKey = 'c_id';

    public function findByPharmacy(int $pharmacyId): array
    {
        return $this->findAllBy('pharmacy_id', $pharmacyId);
    }

    public function create(int $pharmacyId, string $name): int
    {
        return $this->insert([
            'pharmacy_id' => $pharmacyId,
            'category_name' => $name,
        ]);
    }

    public function findByNameAndPharmacy(string $name, int $pharmacyId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE category_name = :name AND pharmacy_id = :pharmacy_id LIMIT 1";
        $row = $this->query($sql, ['name' => $name, 'pharmacy_id' => $pharmacyId])->fetch();
        return $row ?: null;
    }

    public function findByIdAndPharmacy(int $categoryId, int $pharmacyId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE c_id = :id AND pharmacy_id = :pharmacy_id LIMIT 1";
        $row = $this->query($sql, ['id' => $categoryId, 'pharmacy_id' => $pharmacyId])->fetch();
        return $row ?: null;
    }

    public function updateByPharmacy(int $categoryId, int $pharmacyId, array $data): bool
    {
        $set = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));
        $data['id'] = $categoryId;
        $data['pharmacy_id'] = $pharmacyId;

        $sql = "UPDATE {$this->table} SET {$set} WHERE c_id = :id AND pharmacy_id = :pharmacy_id";
        return $this->query($sql, $data)->rowCount() > 0;
    }

    public function deleteByPharmacy(int $categoryId, int $pharmacyId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE c_id = :id AND pharmacy_id = :pharmacy_id LIMIT 1";
        return $this->query($sql, ['id' => $categoryId, 'pharmacy_id' => $pharmacyId])->rowCount() > 0;
    }

    public function hasMedicines(int $categoryId): int
    {
        $sql = "SELECT COUNT(*) as count FROM user_medicine_tbl WHERE c_id = :id";
        return (int) $this->query($sql, ['id' => $categoryId])->fetch()['count'];
    }

    public function hasMedicinesByPharmacy(int $categoryId, int $pharmacyId): int
    {
        $sql = "SELECT COUNT(*) as count FROM user_medicine_tbl WHERE c_id = :id AND pharmacy_id = :pharmacy_id";
        return (int) $this->query($sql, ['id' => $categoryId, 'pharmacy_id' => $pharmacyId])->fetch()['count'];
    }
}
