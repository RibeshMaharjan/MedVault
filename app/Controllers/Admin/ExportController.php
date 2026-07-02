<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;

class ExportController extends Controller
{
    public function orders(): void
    {
        $db = Database::getInstance()->getConnection();

        $sql = "SELECT o.o_id, o.pharmacy_id, p.pharmacy_name, o.m_id, m.medicine_name,
                       o.price, o.quantity, o.total_amount, o.status, o.order_date
                FROM user_order_tbl o
                LEFT JOIN tbl_pharmacy p ON o.pharmacy_id = p.pharmacy_id
                LEFT JOIN user_medicine_tbl m ON o.m_id = m.m_id";
        $params = [];

        $status = $_GET['status'] ?? '';
        $dateFrom = $_GET['date_from'] ?? '';
        $dateTo = $_GET['date_to'] ?? '';

        $conditions = [];
        if ($status) {
            $conditions[] = "o.status = :status";
            $params['status'] = $status;
        }
        if ($dateFrom && $dateTo) {
            $conditions[] = "o.order_date BETWEEN :from AND :to";
            $params['from'] = $dateFrom;
            $params['to'] = $dateTo;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders_export.csv"');

        $headers = ['o_id', 'pharmacy_id', 'pharmacy_name', 'm_id', 'medicine_name', 'price', 'quantity', 'total_amount', 'status', 'order_date'];
        $output = fopen('php://output', 'w');
        fputcsv($output, $headers);
        while ($row = $stmt->fetch()) {
            fputcsv($output, $row);
        }
        fclose($output);
        if (($_ENV['APP_ENV'] ?? '') === 'testing') {
            throw new \RuntimeException('CSV export complete');
        }
        exit;
    }
}
