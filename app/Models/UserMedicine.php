<?php

namespace App\Models;

use App\Core\Model;

class UserMedicine extends Model
{
    protected string $table = 'user_medicine_tbl';
    protected string $primaryKey = 'm_id';

    public function findByPharmacy(int $pharmacyId, string $conditions = '', array $params = []): array
    {
        $where = "pharmacy_id = :pharmacy_id";
        $params['pharmacy_id'] = $pharmacyId;
        if ($conditions) {
            $where .= " AND {$conditions}";
        }
        return $this->findAll($where, $params);
    }

    public function paginateByPharmacy(int $pharmacyId, int $page, int $perPage, string $conditions = '', array $params = []): array
    {
        $where = "pharmacy_id = :pharmacy_id";
        $params['pharmacy_id'] = $pharmacyId;
        if ($conditions) {
            $where .= " AND {$conditions}";
        }
        return $this->paginate($page, $perPage, $where, $params);
    }

    public function countByPharmacy(int $pharmacyId, string $conditions = '', array $params = []): int
    {
        $where = "pharmacy_id = :pharmacy_id";
        $params['pharmacy_id'] = $pharmacyId;
        if ($conditions) {
            $where .= " AND {$conditions}";
        }
        return $this->count($where, $params);
    }

    public function create(array $data): int
    {
        return $this->insert($data);
    }

    public function search(int $pharmacyId, string $term, int $limit = 5): array
    {
        $term = str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $term);
        $sql = "SELECT * FROM {$this->table} WHERE pharmacy_id = :pharmacy_id AND medicine_name LIKE :term ESCAPE '!' LIMIT {$limit}";
        return $this->query($sql, [
            'pharmacy_id' => $pharmacyId,
            'term' => "%{$term}%",
        ])->fetchAll();
    }

    public function findByIdAndPharmacy(int $medicineId, int $pharmacyId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE m_id = :id AND pharmacy_id = :pharmacy_id LIMIT 1";
        $row = $this->query($sql, ['id' => $medicineId, 'pharmacy_id' => $pharmacyId])->fetch();
        return $row ?: null;
    }

    public function findByNameAndPharmacy(string $name, int $pharmacyId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE medicine_name = :name AND pharmacy_id = :pharmacy_id LIMIT 1";
        $row = $this->query($sql, ['name' => $name, 'pharmacy_id' => $pharmacyId])->fetch();
        return $row ?: null;
    }

    public function updateByPharmacy(int $medicineId, int $pharmacyId, array $data): bool
    {
        $set = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));
        $data['id'] = $medicineId;
        $data['pharmacy_id'] = $pharmacyId;

        $sql = "UPDATE {$this->table} SET {$set} WHERE m_id = :id AND pharmacy_id = :pharmacy_id";
        return $this->query($sql, $data)->rowCount() > 0;
    }

    public function deleteByPharmacy(int $medicineId, int $pharmacyId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE m_id = :id AND pharmacy_id = :pharmacy_id LIMIT 1";
        return $this->query($sql, ['id' => $medicineId, 'pharmacy_id' => $pharmacyId])->rowCount() > 0;
    }

    public function updateStock(int $id, int $quantityChange): bool
    {
        $sql = "UPDATE {$this->table} SET in_stock = in_stock + :change WHERE m_id = :id";
        return $this->query($sql, ['change' => $quantityChange, 'id' => $id])->rowCount() > 0;
    }

    public function updateStockByPharmacy(int $medicineId, int $pharmacyId, int $quantityChange): bool
    {
        $sql = "UPDATE {$this->table}
                SET in_stock = in_stock + :change
                WHERE m_id = :id AND pharmacy_id = :pharmacy_id";
        return $this->query($sql, [
            'change' => $quantityChange,
            'id' => $medicineId,
            'pharmacy_id' => $pharmacyId,
        ])->rowCount() > 0;
    }

    public function getCategoryDistribution(int $pharmacyId): array
    {
        $sql = "SELECT c.category_name, COUNT(m.m_id) as med_count, COALESCE(SUM(m.in_stock), 0) as total_stock
                FROM user_category_tbl c
                LEFT JOIN {$this->table} m ON c.c_id = m.c_id
                WHERE c.pharmacy_id = :pharmacy_id
                GROUP BY c.c_id, c.category_name";
        return $this->query($sql, ['pharmacy_id' => $pharmacyId])->fetchAll();
    }

    public function getLowStock(int $pharmacyId, int $threshold = 10): array
    {
        $sql = "SELECT medicine_name, in_stock FROM {$this->table}
                WHERE pharmacy_id = :pharmacy_id AND in_stock <= :threshold
                ORDER BY in_stock ASC";
        return $this->query($sql, ['pharmacy_id' => $pharmacyId, 'threshold' => $threshold])->fetchAll();
    }

    public function getInventoryLevels(int $pharmacyId, int $threshold = 10): array
    {
        $summarySql = "SELECT
                    COALESCE(SUM(in_stock), 0) as total_stock,
                    COUNT(CASE WHEN in_stock <= :threshold AND in_stock > 0 THEN 1 END) as low_stock_count,
                    COUNT(CASE WHEN in_stock = 0 THEN 1 END) as out_of_stock_count
                FROM {$this->table}
                WHERE pharmacy_id = :pharmacy_id";
        $summary = $this->query($summarySql, [
            'pharmacy_id' => $pharmacyId,
            'threshold' => $threshold,
        ])->fetch();

        return [
            'totalStock' => (int) ($summary['total_stock'] ?? 0),
            'lowStockCount' => (int) ($summary['low_stock_count'] ?? 0),
            'outOfStockCount' => (int) ($summary['out_of_stock_count'] ?? 0),
            'lowStockItems' => $this->getLowStock($pharmacyId, $threshold),
        ];
    }

    public function getRecentActivities(int $pharmacyId, int $limit = 10): array
    {
        $sql = "(SELECT sales_date as date, 'Sale' as type, m.medicine_name, s.quantity, s.status
                 FROM user_sales_tbl s JOIN {$this->table} m ON s.m_id = m.m_id
                 WHERE s.pharmacy_id = :pid1)
                UNION ALL
                (SELECT order_date as date, 'Order' as type, m.medicine_name, o.quantity, o.status
                 FROM user_order_tbl o JOIN {$this->table} m ON o.m_id = m.m_id
                 WHERE o.pharmacy_id = :pid2)
                ORDER BY date DESC LIMIT {$limit}";
        return $this->query($sql, ['pid1' => $pharmacyId, 'pid2' => $pharmacyId])->fetchAll();
    }

    public function hasRelatedRecords(int $medicineId): array
    {
        $salesSql = "SELECT COUNT(*) as count FROM user_sales_tbl WHERE m_id = :id";
        $orderSql = "SELECT COUNT(*) as count FROM user_order_tbl WHERE m_id = :id";
        $salesCount = (int) $this->query($salesSql, ['id' => $medicineId])->fetch()['count'];
        $orderCount = (int) $this->query($orderSql, ['id' => $medicineId])->fetch()['count'];
        return ['sales' => $salesCount, 'orders' => $orderCount];
    }

    public function hasRelatedRecordsByPharmacy(int $medicineId, int $pharmacyId): array
    {
        $params = ['id' => $medicineId, 'pharmacy_id' => $pharmacyId];
        $salesSql = "SELECT COUNT(*) as count FROM user_sales_tbl WHERE m_id = :id AND pharmacy_id = :pharmacy_id";
        $orderSql = "SELECT COUNT(*) as count FROM user_order_tbl WHERE m_id = :id AND pharmacy_id = :pharmacy_id";
        $salesCount = (int) $this->query($salesSql, $params)->fetch()['count'];
        $orderCount = (int) $this->query($orderSql, $params)->fetch()['count'];
        return ['sales' => $salesCount, 'orders' => $orderCount];
    }
}
