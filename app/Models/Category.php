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

    public function hasMedicines(int $categoryId): int
    {
        $sql = "SELECT COUNT(*) as count FROM user_medicine_tbl WHERE c_id = :id";
        return (int) $this->query($sql, ['id' => $categoryId])->fetch()['count'];
    }
}
