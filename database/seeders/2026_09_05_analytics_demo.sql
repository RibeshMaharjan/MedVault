-- WARNING: Destructive, idempotent MedVault demo dataset. Back up the target database first.
-- Replaces all existing MedVault records with demo data for 2026-07-04 through 2026-09-05.
-- All accounts use password: Passw0rd!
-- Import into Docker:
--   docker compose exec -T db mysql -uroot -pmedvault pharmacy < database/seeders/2026_09_05_analytics_demo.sql
-- Import into a remote MySQL 8 host (the -p prompt keeps the password out of shell history):
--   mysql -h HOST -P 3306 -u USER -p DATABASE < database/seeders/2026_09_05_analytics_demo.sql

SET time_zone = '+00:00';
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE `cart`;
TRUNCATE TABLE `inventory`;
TRUNCATE TABLE `order_address`;
TRUNCATE TABLE `order_completed`;
TRUNCATE TABLE `order_pending`;
TRUNCATE TABLE `tbl_medicine`;
TRUNCATE TABLE `user_orders`;
TRUNCATE TABLE `user_sales_tbl`;
TRUNCATE TABLE `user_order_tbl`;
TRUNCATE TABLE `user_medicine_tbl`;
TRUNCATE TABLE `user_category_tbl`;
TRUNCATE TABLE `tbl_pharmacy`;
TRUNCATE TABLE `tbl_admin`;
TRUNCATE TABLE `role`;
TRUNCATE TABLE `settings`;

SET FOREIGN_KEY_CHECKS = 1;
START TRANSACTION;

INSERT INTO `role` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(1,   'Sunita Sharma',          'admin@medvault.com',              '$2y$10$VeGZpUnRlCAcmunN1FwLw.td6SnA1r8.9xs9Ykm.BhFG698BroPyG', 'admin'),
(101, 'Himalaya Pharmacy',      'himalaya.pharmacy@example.com',   '$2y$10$VeGZpUnRlCAcmunN1FwLw.td6SnA1r8.9xs9Ykm.BhFG698BroPyG', 'user'),
(102, 'Valley Care Pharmacy',   'valleycare.pharmacy@example.com', '$2y$10$VeGZpUnRlCAcmunN1FwLw.td6SnA1r8.9xs9Ykm.BhFG698BroPyG', 'user'),
(103, 'Everest Health Pharmacy','everest.health@example.com',      '$2y$10$VeGZpUnRlCAcmunN1FwLw.td6SnA1r8.9xs9Ykm.BhFG698BroPyG', 'user');

INSERT INTO `tbl_admin` (`admin_id`, `name`, `email`, `gender`, `phone`, `dob`, `address`) VALUES
(1, 'Sunita Sharma', 'admin@medvault.com', 'female', '9841122001', '1990-03-15', 'Baneshwor, Kathmandu');

INSERT INTO `tbl_pharmacy` (`pharmacy_id`, `pan`, `pharmacy_name`, `email`, `phone`, `address`, `isverified`, `license_number`, `reg_document`, `verification_request_date`, `verification_date`, `verification_notes`) VALUES
(101, 300123456, 'Himalaya Pharmacy',       'himalaya.pharmacy@example.com',   '9841122334', 'Durbar Marg, Kathmandu', 1, 'MED-2023-0451', NULL, '2026-05-01 09:00:00', '2026-05-03 14:20:00', 'Documents verified, license current.'),
(102, 300456789, 'Valley Care Pharmacy',    'valleycare.pharmacy@example.com', '9851234567', 'Pulchowk, Lalitpur',     1, 'MED-2022-0198', NULL, '2026-04-10 11:00:00', '2026-04-12 10:05:00', 'Renewed license confirmed.'),
(103, 300789012, 'Everest Health Pharmacy', 'everest.health@example.com',      '9861122334', 'Boudha, Kathmandu',      0, 'MED-2024-0327', NULL, '2026-09-01 16:45:00', NULL,                  NULL);

INSERT INTO `settings` (`id`, `title`, `small_description`, `sub_title`, `sub_description`, `phone`, `email`) VALUES
(1, 'WELLNESS STARTS HERE', 'MedVault connects pharmacies with a simple, secure platform to manage inventory, orders, and sales.', 'Care you can trust', 'Track stock, fulfil orders, and record sales from one dashboard.', '9840455685', 'support@medvault.com');

INSERT INTO `user_category_tbl` (`c_id`, `pharmacy_id`, `category_name`) VALUES
(1, 101, 'Pain Relief'),
(2, 101, 'Antibiotics'),
(3, 101, 'Vitamins & Supplements'),
(4, 102, 'Cold & Flu'),
(5, 102, 'Antacids & Digestive'),
(6, 102, 'Antibiotics'),
(7, 103, 'Pain Relief'),
(8, 103, 'Vitamins & Supplements'),
(9, 103, 'Respiratory');

-- Prices are whole rupees because the current schema stores money as INT.
INSERT INTO `user_medicine_tbl` (`m_id`, `pharmacy_id`, `medicine_name`, `medicine_desc`, `c_id`, `in_stock`, `buy_price`, `sell_price`, `added_date`, `exp_date`) VALUES
(1,  101, 'Paracetamol 500mg Tablets',  'Pain reliever and fever reducer.',             1, 140,  3,  5, '2026-07-01', '2027-11-30'),
(2,  101, 'Amoxicillin 250mg Capsules', 'Broad-spectrum antibiotic.',                   2,  72,  8, 13, '2026-07-01', '2027-08-31'),
(3,  101, 'Vitamin C 500mg Tablets',    'Immune support supplement.',                   3,   8,  4,  7, '2026-07-01', '2028-01-31'),
(4,  101, 'Diclofenac 50mg Tablets',    'Anti-inflammatory pain medicine.',             1,  25,  6, 10, '2026-07-01', '2026-08-31'),
(5,  102, 'Cetirizine 10mg Tablets',    'Antihistamine for allergy symptoms.',           4, 190,  3,  5, '2026-07-01', '2027-06-30'),
(6,  102, 'Omeprazole 20mg Capsules',   'Reduces stomach acid production.',              5,   0,  7, 10, '2026-07-01', '2027-09-30'),
(7,  102, 'Azithromycin 500mg Tablets', 'Antibiotic for bacterial infections.',          6,  50, 15, 22, '2026-07-01', '2027-04-30'),
(8,  102, 'ORS Sachets',                'Oral rehydration salts for fluid replacement.', 4,   9,  8, 12, '2026-07-01', '2026-09-20'),
(9,  103, 'Ibuprofen 400mg Tablets',    'Pain and inflammation reliever.',               7, 160,  3,  6, '2026-07-01', '2027-12-31'),
(10, 103, 'Multivitamin Tablets',       'Daily vitamin and mineral supplement.',         8, 110,  5,  9, '2026-07-01', '2028-03-31'),
(11, 103, 'Salbutamol 2mg Tablets',     'Bronchodilator for breathing symptoms.',        9,   6,  4,  8, '2026-07-01', '2027-02-28'),
(12, 103, 'Zinc 20mg Tablets',          'Mineral supplement for immune support.',        8,  45,  3,  6, '2026-07-01', '2026-09-30');

-- One sale per available medicine/day. Quantities trend upward, soften on
-- weekends, and include deliberate spikes/dips for each analytics period.
INSERT INTO `user_sales_tbl` (`pharmacy_id`, `m_id`, `price`, `quantity`, `total_amount`, `status`, `sales_date`)
WITH RECURSIVE dates AS (
    SELECT DATE('2026-07-04') AS sale_date, 0 AS day_number
    UNION ALL
    SELECT DATE_ADD(sale_date, INTERVAL 1 DAY), day_number + 1
    FROM dates
    WHERE sale_date < '2026-09-05'
), shaped AS (
    SELECT
        m.pharmacy_id,
        m.m_id,
        m.sell_price,
        d.sale_date,
        d.day_number,
        GREATEST(1, ROUND(
            (1 + MOD(d.day_number + m.m_id, 5) + FLOOR(d.day_number / 21))
            * IF(WEEKDAY(d.sale_date) >= 5, 0.7, 1)
            * CASE
                WHEN m.pharmacy_id = 101 AND d.sale_date = '2026-07-15' THEN 3
                WHEN m.pharmacy_id = 102 AND d.sale_date BETWEEN '2026-08-10' AND '2026-08-12' THEN 3
                WHEN m.pharmacy_id = 103 AND d.sale_date = '2026-09-01' THEN 4
                ELSE 1
              END
        )) AS quantity
    FROM dates d
    JOIN user_medicine_tbl m ON d.sale_date <= m.exp_date
    WHERE NOT (m.pharmacy_id = 101 AND d.sale_date BETWEEN '2026-08-20' AND '2026-08-21')
      AND NOT (m.pharmacy_id = 102 AND d.sale_date = '2026-09-03')
)
SELECT
    pharmacy_id,
    m_id,
    sell_price,
    quantity,
    sell_price * quantity,
    CASE
        WHEN sale_date >= '2026-09-03' AND MOD(day_number + m_id, 4) = 0 THEN 'pending'
        WHEN MOD(day_number * 7 + m_id, 37) = 0 THEN 'cancelled'
        ELSE 'completed'
    END,
    sale_date
FROM shaped;

-- Orders reserve stock unless cancelled. Recent orders remain pending so the
-- dashboard shows an active queue; older orders mix completed/cancelled states.
INSERT INTO `user_order_tbl` (`m_id`, `pharmacy_id`, `price`, `quantity`, `total_amount`, `status`, `order_date`)
WITH RECURSIVE dates AS (
    SELECT DATE('2026-07-04') AS order_date, 0 AS day_number
    UNION ALL
    SELECT DATE_ADD(order_date, INTERVAL 1 DAY), day_number + 1
    FROM dates
    WHERE order_date < '2026-09-05'
), candidates AS (
    SELECT
        d.order_date,
        d.day_number,
        p.pharmacy_id,
        1 + ((p.pharmacy_id - 101) * 4) + MOD(FLOOR(d.day_number / 3), 4) AS m_id
    FROM dates d
    CROSS JOIN (SELECT 101 AS pharmacy_id UNION ALL SELECT 102 UNION ALL SELECT 103) p
    WHERE MOD(d.day_number, 3) = 0
)
SELECT
    m.m_id,
    c.pharmacy_id,
    m.sell_price,
    10 + MOD(c.day_number + c.pharmacy_id, 21),
    m.sell_price * (10 + MOD(c.day_number + c.pharmacy_id, 21)),
    CASE
        WHEN c.order_date >= '2026-09-02' THEN 'pending'
        WHEN MOD(c.day_number, 15) = 0 THEN 'cancelled'
        ELSE 'completed'
    END,
    c.order_date
FROM candidates c
JOIN user_medicine_tbl m
  ON m.m_id = c.m_id
 AND m.pharmacy_id = c.pharmacy_id
 AND c.order_date <= m.exp_date;

-- Embedded import check: any false condition aborts the seed transaction.
CREATE TEMPORARY TABLE seed_assertions (
    check_name VARCHAR(80) NOT NULL,
    ok TINYINT NOT NULL CHECK (ok = 1)
);

INSERT INTO seed_assertions (`check_name`, `ok`)
SELECT 'sales date range', MIN(sales_date) = '2026-07-04' AND MAX(sales_date) = '2026-09-05' FROM user_sales_tbl
UNION ALL
SELECT 'orders date range', MIN(order_date) = '2026-07-04' AND MAX(order_date) = '2026-09-05' FROM user_order_tbl
UNION ALL
SELECT 'sales totals', COUNT(*) = 0 FROM user_sales_tbl WHERE total_amount <> price * quantity OR price <= 0 OR quantity <= 0
UNION ALL
SELECT 'order totals', COUNT(*) = 0 FROM user_order_tbl WHERE total_amount <> price * quantity OR price <= 0 OR quantity <= 0
UNION ALL
SELECT 'non-negative stock', COUNT(*) = 0 FROM user_medicine_tbl WHERE in_stock < 0 OR buy_price <= 0 OR sell_price <= 0
UNION ALL
SELECT 'sales ownership', COUNT(*) = 0 FROM user_sales_tbl s LEFT JOIN user_medicine_tbl m ON m.m_id = s.m_id AND m.pharmacy_id = s.pharmacy_id WHERE m.m_id IS NULL
UNION ALL
SELECT 'order ownership', COUNT(*) = 0 FROM user_order_tbl o LEFT JOIN user_medicine_tbl m ON m.m_id = o.m_id AND m.pharmacy_id = o.pharmacy_id WHERE m.m_id IS NULL
UNION ALL
SELECT 'category ownership', COUNT(*) = 0 FROM user_medicine_tbl m LEFT JOIN user_category_tbl c ON c.c_id = m.c_id AND c.pharmacy_id = m.pharmacy_id WHERE c.c_id IS NULL
UNION ALL
SELECT 'sales statuses', COUNT(DISTINCT status) = 3 FROM user_sales_tbl
UNION ALL
SELECT 'order statuses', COUNT(DISTINCT status) = 3 FROM user_order_tbl
UNION ALL
SELECT 'no post-expiry sales', COUNT(*) = 0 FROM user_sales_tbl s JOIN user_medicine_tbl m ON m.m_id = s.m_id WHERE s.sales_date > m.exp_date
UNION ALL
SELECT 'no post-expiry orders', COUNT(*) = 0 FROM user_order_tbl o JOIN user_medicine_tbl m ON m.m_id = o.m_id WHERE o.order_date > m.exp_date
UNION ALL
SELECT 'low stock example', COUNT(*) > 0 FROM user_medicine_tbl WHERE in_stock BETWEEN 1 AND 10
UNION ALL
SELECT 'out of stock example', COUNT(*) > 0 FROM user_medicine_tbl WHERE in_stock = 0
UNION ALL
SELECT 'expired example', COUNT(*) > 0 FROM user_medicine_tbl WHERE exp_date < '2026-09-05'
UNION ALL
SELECT 'expiring soon example', COUNT(*) > 0 FROM user_medicine_tbl WHERE exp_date BETWEEN '2026-09-05' AND '2026-10-05';

DROP TEMPORARY TABLE seed_assertions;
COMMIT;

SELECT 'accounts' AS dataset, COUNT(*) AS rows_seeded FROM role
UNION ALL SELECT 'pharmacies', COUNT(*) FROM tbl_pharmacy
UNION ALL SELECT 'categories', COUNT(*) FROM user_category_tbl
UNION ALL SELECT 'medicines', COUNT(*) FROM user_medicine_tbl
UNION ALL SELECT 'orders', COUNT(*) FROM user_order_tbl
UNION ALL SELECT 'sales', COUNT(*) FROM user_sales_tbl;
