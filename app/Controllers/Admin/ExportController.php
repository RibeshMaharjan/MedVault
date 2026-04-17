<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;

class ExportController extends Controller
{
    public function orders(): void
    {
        $db = Database::getInstance()->getConnection();

        $sql = "SELECT * FROM user_orders";
        $params = [];

        $status = $_GET['status'] ?? '';
        $dateFrom = $_GET['date_from'] ?? '';
        $dateTo = $_GET['date_to'] ?? '';

        $conditions = [];
        if ($status) {
            $conditions[] = "status = :status";
            $params['status'] = $status;
        }
        if ($dateFrom && $dateTo) {
            $conditions[] = "order_date BETWEEN :from AND :to";
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

        $output = fopen('php://output', 'w');
        $first = true;
        while ($row = $stmt->fetch()) {
            if ($first) {
                fputcsv($output, array_keys($row));
                $first = false;
            }
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}
