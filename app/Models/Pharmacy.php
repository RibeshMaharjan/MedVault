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
}
