<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'role';
    protected string $primaryKey = 'user_id';

    public function findByEmail(string $email): ?array
    {
        return $this->findOneBy('email', $email);
    }

    public function create(string $name, string $email, string $passwordHash, string $role = 'user'): int
    {
        return $this->insert([
            'name' => $name,
            'email' => $email,
            'password' => $passwordHash,
            'role' => $role,
        ]);
    }
}
