<?php

namespace App\Core;

use PDO;
use PDOStatement;

abstract class Model
{
    protected string $table;
    protected string $primaryKey = 'id';
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function findAll(string $conditions = '', array $params = []): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($conditions) {
            $sql .= " WHERE {$conditions}";
        }
        return $this->query($sql, $params)->fetchAll();
    }

    public function findById(mixed $id, ?string $idCol = null): ?array
    {
        $col = $idCol ?? $this->primaryKey;
        $sql = "SELECT * FROM {$this->table} WHERE {$col} = :id LIMIT 1";
        $row = $this->query($sql, ['id' => $id])->fetch();
        return $row ?: null;
    }

    public function findAllBy(string $col, mixed $value): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$col} = :val";
        return $this->query($sql, ['val' => $value])->fetchAll();
    }

    public function findOneBy(string $col, mixed $value): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$col} = :val LIMIT 1";
        $row = $this->query($sql, ['val' => $value])->fetch();
        return $row ?: null;
    }

    public function count(string $conditions = '', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if ($conditions) {
            $sql .= " WHERE {$conditions}";
        }
        return (int) $this->query($sql, $params)->fetch()['total'];
    }

    public function insert(array $data): int
    {
        $cols = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$cols}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        return (int) $this->db->lastInsertId();
    }

    public function update(mixed $id, array $data, ?string $idCol = null): bool
    {
        $col = $idCol ?? $this->primaryKey;
        $set = implode(', ', array_map(fn($k) => "{$k} = :{$k}", array_keys($data)));
        $data['_id'] = $id;
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$col} = :_id";
        return $this->query($sql, $data)->rowCount() >= 0;
    }

    public function delete(mixed $id, ?string $idCol = null): bool
    {
        $col = $idCol ?? $this->primaryKey;
        $sql = "DELETE FROM {$this->table} WHERE {$col} = :id LIMIT 1";
        return $this->query($sql, ['id' => $id])->rowCount() > 0;
    }

    public function paginate(int $page, int $perPage, string $conditions = '', array $params = []): array
    {
        $offset = ($page - 1) * $perPage;
        $totalRecords = $this->count($conditions, $params);
        $totalPages = (int) ceil($totalRecords / $perPage);

        $sql = "SELECT * FROM {$this->table}";
        if ($conditions) {
            $sql .= " WHERE {$conditions}";
        }
        $sql .= " LIMIT {$perPage} OFFSET {$offset}";

        $data = $this->query($sql, $params)->fetchAll();

        return [
            'data' => $data,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalRecords' => $totalRecords,
            'hasNextPage' => $page < $totalPages,
            'hasPrevPage' => $page > 1,
        ];
    }
}
