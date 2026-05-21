<?php

namespace App\Models;

use App\Core\Model;

class Sale extends Model
{
    protected string $table = 'user_sales_tbl';
    protected string $primaryKey = 's_id';

    public function paginateByPharmacy(int $pharmacyId, int $page, int $perPage, string $conditions = '', array $params = []): array
    {
        $where = "pharmacy_id = :pharmacy_id";
        $params['pharmacy_id'] = $pharmacyId;
        if ($conditions) {
            $where .= " AND {$conditions}";
        }
        return $this->paginate($page, $perPage, $where, $params);
    }

    public function findByIdAndPharmacy(int $saleId, int $pharmacyId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE s_id = :sid AND pharmacy_id = :pid LIMIT 1";
        $row = $this->query($sql, ['sid' => $saleId, 'pid' => $pharmacyId])->fetch();
        return $row ?: null;
    }

    public function deleteByPharmacy(int $saleId, int $pharmacyId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE s_id = :sid AND pharmacy_id = :pid";
        return $this->query($sql, ['sid' => $saleId, 'pid' => $pharmacyId])->rowCount() > 0;
    }

    public function updateByPharmacy(int $saleId, int $pharmacyId, array $data): bool
    {
        $set = implode(', ', array_map(fn($k) => "{$k} = :{$k}", array_keys($data)));
        $data['_sid'] = $saleId;
        $data['_pid'] = $pharmacyId;
        $sql = "UPDATE {$this->table} SET {$set} WHERE s_id = :_sid AND pharmacy_id = :_pid";
        return $this->query($sql, $data)->rowCount() >= 0;
    }

    public function getSalesData(int $pharmacyId, string $startDate, string $endDate): array
    {
        $sql = "WITH RECURSIVE date_range AS (
                    SELECT :start as date
                    UNION ALL
                    SELECT DATE_ADD(date, INTERVAL 1 DAY) FROM date_range WHERE DATE_ADD(date, INTERVAL 1 DAY) <= :end
                ),
                daily_sales AS (
                    SELECT DATE(sales_date) as sale_date, SUM(total_amount) as daily_total
                    FROM {$this->table}
                    WHERE pharmacy_id = :pid AND sales_date BETWEEN :start2 AND :end2
                    GROUP BY DATE(sales_date)
                )
                SELECT date_range.date as sale_date, COALESCE(daily_sales.daily_total, 0) as daily_total
                FROM date_range
                LEFT JOIN daily_sales ON date_range.date = daily_sales.sale_date
                ORDER BY date_range.date ASC";
        return $this->query($sql, [
            'start' => $startDate, 'end' => $endDate,
            'pid' => $pharmacyId, 'start2' => $startDate, 'end2' => $endDate,
        ])->fetchAll();
    }
}
