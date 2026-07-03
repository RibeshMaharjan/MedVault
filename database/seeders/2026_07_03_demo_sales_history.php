<?php

/**
 * Demo data seeder for the weighted-moving-average / anomaly-detection demo
 * on Sun 2026-07-05. Populates ~4 months of daily sale + order history
 * (2026-03-05 .. 2026-07-05) for the three seeded pharmacies, with a few
 * deliberate spikes/dips so anomaly detection has something to flag in
 * every timeframe (last week / last month / last 3 months).
 *
 * Does NOT touch role/tbl_admin/tbl_pharmacy/settings/categories — replaces
 * rows in user_order_tbl and user_sales_tbl, and reconciles
 * user_medicine_tbl.in_stock so displayed stock matches the seeded history.
 *
 * Run:
 *   docker compose exec app php database/seeders/2026_07_03_demo_sales_history.php
 */

$envPath = dirname(__DIR__, 2) . '/.env';
$env = file_exists($envPath) ? parse_ini_file($envPath) : [];

$dsn = "mysql:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_NAME']};charset=utf8mb4";
$pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASS'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
]);

$pdo->exec('TRUNCATE TABLE user_order_tbl');
$pdo->exec('TRUNCATE TABLE user_sales_tbl');

// pharmacy_id => [medicines: m_id => sell_price, base sale txns/day, base order txns/day]
$pharmacies = [
    101 => ['medicines' => [1 => 5.00, 2 => 12.50, 3 => 7.00],   'saleTxn' => [3, 6], 'orderTxn' => [1, 2]],
    102 => ['medicines' => [4 => 4.50, 5 => 10.00, 6 => 22.00],  'saleTxn' => [2, 4], 'orderTxn' => [1, 2]],
    103 => ['medicines' => [7 => 5.50, 8 => 8.50],               'saleTxn' => [1, 3], 'orderTxn' => [0, 1]],
];

$start = new DateTime('2026-03-05');
$end = new DateTime('2026-07-05');
$totalDays = (int) $start->diff($end)->days;

// Deliberate anomaly windows: date => pharmacy_id => multiplier applied to that day's transaction count
$anomalies = [
    // Nepali New Year rush - single-day spike, falls in the "last 3 months" window
    '2026-04-14' => [101 => 3.0, 103 => 2.5],
    // Supply shortage - sales crash for a few days (last 3 months window)
    '2026-05-20' => [101 => 0.05],
    '2026-05-21' => [101 => 0.1],
    // Seasonal flu outbreak - cold & flu heavy pharmacy 102, multi-day spike (last month window)
    '2026-06-10' => [102 => 2.8],
    '2026-06-11' => [102 => 3.2],
    '2026-06-12' => [102 => 2.6],
    // Recent spike + dip inside "last week" window (2026-06-29 .. 2026-07-05)
    '2026-07-01' => [103 => 2.7],
    '2026-07-03' => [102 => 0.1],
];

$saleRows = [];
$orderRows = [];
$stockConsumed = []; // m_id => total quantity sold/ordered, to reconcile in_stock afterwards

for ($d = 0; $d <= $totalDays; $d++) {
    $date = (clone $start)->modify("+{$d} day");
    $dateStr = $date->format('Y-m-d');
    $isWeekend = in_array($date->format('N'), [6, 7], true);
    // gentle upward trend over the 4 months (1.0 -> ~1.2)
    $trend = 1.0 + (0.2 * $d / $totalDays);
    $weekendFactor = $isWeekend ? 0.7 : 1.0;
    // quantity-per-transaction scaling excludes the anomaly factor, which is
    // applied once, to transaction count, so spikes aren't squared
    $quantityFactor = $trend * $weekendFactor;

    foreach ($pharmacies as $pharmacyId => $cfg) {
        $anomalyFactor = $anomalies[$dateStr][$pharmacyId] ?? 1.0;
        $medicineIds = array_keys($cfg['medicines']);

        // --- sales ---
        [$minTxn, $maxTxn] = $cfg['saleTxn'];
        $txnCount = max(0, (int) round(mt_rand($minTxn * 10, $maxTxn * 10) / 10 * $anomalyFactor));

        for ($t = 0; $t < $txnCount; $t++) {
            $mId = $medicineIds[array_rand($medicineIds)];
            $price = $cfg['medicines'][$mId];
            $quantity = max(1, (int) round(mt_rand(2, 12) * $quantityFactor));
            $total = round($price * $quantity, 2);

            $saleRows[] = [$pharmacyId, $mId, $price, $quantity, $total, 'completed', $dateStr];
            $stockConsumed[$mId] = ($stockConsumed[$mId] ?? 0) + $quantity;
        }

        // --- orders (restocking) ---
        [$minOrd, $maxOrd] = $cfg['orderTxn'];
        $orderTxnCount = mt_rand($minOrd, $maxOrd);

        for ($t = 0; $t < $orderTxnCount; $t++) {
            $mId = $medicineIds[array_rand($medicineIds)];
            $price = $cfg['medicines'][$mId];
            $quantity = mt_rand(20, 80);
            $total = round($price * $quantity, 2);

            // recent orders skew toward pending/processing; older ones resolved
            $daysAgo = $totalDays - $d;
            if ($daysAgo <= 3) {
                $status = 'pending';
            } elseif (mt_rand(1, 100) <= 8) {
                $status = 'cancelled';
            } else {
                $status = 'completed';
            }

            $orderRows[] = [$pharmacyId, $mId, $price, $quantity, $total, $status, $dateStr];
            if ($status !== 'cancelled') {
                $stockConsumed[$mId] = ($stockConsumed[$mId] ?? 0) + $quantity;
            }
        }
    }
}

function batchInsert(PDO $pdo, string $sql, array $rows, int $columnCount, int $chunkSize = 200): void
{
    $placeholderGroup = '(' . implode(',', array_fill(0, $columnCount, '?')) . ')';
    foreach (array_chunk($rows, $chunkSize) as $chunk) {
        $placeholders = implode(',', array_fill(0, count($chunk), $placeholderGroup));
        $stmt = $pdo->prepare("{$sql} VALUES {$placeholders}");
        $stmt->execute(array_merge(...$chunk));
    }
}

$pdo->beginTransaction();

batchInsert(
    $pdo,
    'INSERT INTO user_sales_tbl (pharmacy_id, m_id, price, quantity, total_amount, status, sales_date)',
    $saleRows,
    7
);

batchInsert(
    $pdo,
    'INSERT INTO user_order_tbl (pharmacy_id, m_id, price, quantity, total_amount, status, order_date)',
    $orderRows,
    7
);

// Reconcile in_stock: give each medicine a comfortable buffer above everything
// the seeded history consumed, so current stock is consistent with the demo data.
$stockStmt = $pdo->prepare('UPDATE user_medicine_tbl SET in_stock = :in_stock WHERE m_id = :m_id');
foreach ($pharmacies as $cfg) {
    foreach (array_keys($cfg['medicines']) as $mId) {
        $consumed = $stockConsumed[$mId] ?? 0;
        $remaining = (int) round($consumed * 0.25) + 50; // ~25% of consumed volume left, plus a floor buffer
        $stockStmt->execute(['in_stock' => $remaining, 'm_id' => $mId]);
    }
}

$pdo->commit();

echo 'Seeded ' . count($saleRows) . ' sales and ' . count($orderRows) . ' orders across ' . ($totalDays + 1) . " days (2026-03-05 .. 2026-07-05).\n";
