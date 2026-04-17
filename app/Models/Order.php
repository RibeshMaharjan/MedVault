<?php

namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    protected string $table = 'user_order_tbl';
    protected string $primaryKey = 'o_id';

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

    public function findByIdAndPharmacy(int $orderId, int $pharmacyId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE o_id = :oid AND pharmacy_id = :pid LIMIT 1";
        $row = $this->query($sql, ['oid' => $orderId, 'pid' => $pharmacyId])->fetch();
        return $row ?: null;
    }

    public function deleteByPharmacy(int $orderId, int $pharmacyId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE o_id = :oid AND pharmacy_id = :pid";
        return $this->query($sql, ['oid' => $orderId, 'pid' => $pharmacyId])->rowCount() > 0;
    }

    public function updateByPharmacy(int $orderId, int $pharmacyId, array $data): bool
    {
        $set = implode(', ', array_map(fn($k) => "{$k} = :{$k}", array_keys($data)));
        $data['_oid'] = $orderId;
        $data['_pid'] = $pharmacyId;
        $sql = "UPDATE {$this->table} SET {$set} WHERE o_id = :_oid AND pharmacy_id = :_pid";
        return $this->query($sql, $data)->rowCount() >= 0;
    }

    public function getDailyOrders(int $pharmacyId, string $startDate, string $endDate): array
    {
        $sql = "SELECT DATE(order_date) as date, COUNT(*) as count
                FROM {$this->table}
                WHERE pharmacy_id = :pid AND order_date BETWEEN :start AND :end
                GROUP BY DATE(order_date) ORDER BY date";
        return $this->query($sql, ['pid' => $pharmacyId, 'start' => $startDate, 'end' => $endDate])->fetchAll();
    }

    public function getStatusDistribution(int $pharmacyId, string $startDate, string $endDate): array
    {
        $sql = "SELECT status, COUNT(*) as count FROM {$this->table}
                WHERE pharmacy_id = :pid AND order_date BETWEEN :start AND :end GROUP BY status";
        $result = $this->query($sql, ['pid' => $pharmacyId, 'start' => $startDate, 'end' => $endDate])->fetchAll();
        $dist = ['completed' => 0, 'pending' => 0, 'cancelled' => 0];
        foreach ($result as $row) {
            $dist[strtolower($row['status'])] = (int) $row['count'];
        }
        return $dist;
    }

    public function getStats(int $pharmacyId, string $startDate, string $endDate): array
    {
        $sql = "SELECT COUNT(*) as total,
                ROUND(AVG(total_amount)) as avg_order_value,
                COUNT(CASE WHEN status = 'completed' THEN 1 END) * 100.0 / GREATEST(COUNT(*), 1) as completion_rate,
                COUNT(CASE WHEN DATE(order_date) = CURDATE() THEN 1 END) as today_orders,
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_orders
                FROM {$this->table}
                WHERE pharmacy_id = :pid AND order_date BETWEEN :start AND :end";
        return $this->query($sql, ['pid' => $pharmacyId, 'start' => $startDate, 'end' => $endDate])->fetch();
    }

    public function getTopOrdered(int $pharmacyId, string $startDate, string $endDate, int $limit = 5): array
    {
        $sql = "SELECT m.medicine_name, COUNT(o.o_id) as order_count, SUM(o.quantity) as total_quantity
                FROM {$this->table} o JOIN user_medicine_tbl m ON o.m_id = m.m_id
                WHERE o.pharmacy_id = :pid AND o.order_date BETWEEN :start AND :end
                GROUP BY m.m_id, m.medicine_name ORDER BY order_count DESC LIMIT {$limit}";
        return $this->query($sql, ['pid' => $pharmacyId, 'start' => $startDate, 'end' => $endDate])->fetchAll();
    }

    public function getRecentOrders(int $pharmacyId, int $limit = 10): array
    {
        $sql = "SELECT o.order_date, m.medicine_name, o.quantity, o.status, o.total_amount
                FROM {$this->table} o JOIN user_medicine_tbl m ON o.m_id = m.m_id
                WHERE o.pharmacy_id = :pid ORDER BY o.order_date DESC LIMIT {$limit}";
        return $this->query($sql, ['pid' => $pharmacyId])->fetchAll();
    }
}
