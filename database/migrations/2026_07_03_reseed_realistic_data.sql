-- Wipes all seed/junk rows and reloads the schema with a small, internally
-- consistent, realistic demo dataset. Does NOT touch `pharmacy.sql` (the
-- Docker init dump) or table structure — only table contents.
--
-- Run manually (this does not auto-run like pharmacy.sql on first container
-- boot, since the DB volume already exists after first init):
--   docker compose exec -T db mysql -uroot -pmedvault pharmacy < database/migrations/2026_07_03_reseed_realistic_data.sql
--
-- All seeded accounts share the password: Passw0rd!

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

-- --------------------------------------------------------
-- role (auth) — password hash below is bcrypt('Passw0rd!')
-- --------------------------------------------------------

INSERT INTO `role` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(1,   'Sunita Sharma',         'admin@medvault.com',             '$2y$10$VeGZpUnRlCAcmunN1FwLw.td6SnA1r8.9xs9Ykm.BhFG698BroPyG', 'admin'),
(101, 'Himalaya Pharmacy',     'himalaya.pharmacy@example.com',  '$2y$10$VeGZpUnRlCAcmunN1FwLw.td6SnA1r8.9xs9Ykm.BhFG698BroPyG', 'user'),
(102, 'Valley Care Pharmacy',  'valleycare.pharmacy@example.com','$2y$10$VeGZpUnRlCAcmunN1FwLw.td6SnA1r8.9xs9Ykm.BhFG698BroPyG', 'user'),
(103, 'Everest Health Pharmacy','everest.health@example.com',    '$2y$10$VeGZpUnRlCAcmunN1FwLw.td6SnA1r8.9xs9Ykm.BhFG698BroPyG', 'user');

-- --------------------------------------------------------
-- tbl_admin
-- --------------------------------------------------------

INSERT INTO `tbl_admin` (`admin_id`, `name`, `email`, `gender`, `phone`, `dob`, `address`) VALUES
(1, 'Sunita Sharma', 'admin@medvault.com', 'female', '9841122001', '1990-03-15', 'Baneshwor, Kathmandu');

-- --------------------------------------------------------
-- tbl_pharmacy
-- --------------------------------------------------------

INSERT INTO `tbl_pharmacy` (`pharmacy_id`, `pan`, `pharmacy_name`, `email`, `phone`, `address`, `isverified`, `license_number`, `reg_document`, `verification_request_date`, `verification_date`, `verification_notes`) VALUES
(101, 300123456, 'Himalaya Pharmacy',      'himalaya.pharmacy@example.com',  '9841122334', 'Durbar Marg, Kathmandu', 1, 'MED-2023-0451', NULL, '2026-05-01 09:00:00', '2026-05-03 14:20:00', 'Documents verified, license current.'),
(102, 300456789, 'Valley Care Pharmacy',   'valleycare.pharmacy@example.com','9851234567', 'Pulchowk, Lalitpur',    1, 'MED-2022-0198', NULL, '2026-04-10 11:00:00', '2026-04-12 10:05:00', 'Renewed license confirmed.'),
(103, 300789012, 'Everest Health Pharmacy','everest.health@example.com',     '9861122334', 'Boudha, Kathmandu',      0, 'MED-2024-0327', NULL, '2026-06-28 16:45:00', NULL,                 NULL);

-- --------------------------------------------------------
-- settings
-- --------------------------------------------------------

INSERT INTO `settings` (`id`, `title`, `small_description`, `sub_title`, `sub_description`, `phone`, `email`) VALUES
(1, 'WELLNESS STARTS HERE', 'MedVault connects pharmacies with a simple, secure platform to manage inventory, orders, and sales.', 'Care you can trust', 'Track stock, fulfil orders, and record sales from one dashboard.', '9840455685', 'support@medvault.com');

-- --------------------------------------------------------
-- user_category_tbl
-- --------------------------------------------------------

INSERT INTO `user_category_tbl` (`c_id`, `pharmacy_id`, `category_name`) VALUES
(1, 101, 'Pain Relief'),
(2, 101, 'Antibiotics'),
(3, 101, 'Vitamins & Supplements'),
(4, 102, 'Cold & Flu'),
(5, 102, 'Antacids & Digestive'),
(6, 102, 'Antibiotics'),
(7, 103, 'Pain Relief'),
(8, 103, 'Vitamins & Supplements');

-- --------------------------------------------------------
-- user_medicine_tbl
-- --------------------------------------------------------

INSERT INTO `user_medicine_tbl` (`m_id`, `pharmacy_id`, `medicine_name`, `medicine_desc`, `c_id`, `in_stock`, `buy_price`, `sell_price`, `added_date`, `exp_date`) VALUES
(1, 101, 'Paracetamol 500mg Tablets',     'Pain reliever and fever reducer.',              1, 250, 3.50,  5.00,  '2026-05-01', '2027-11-30'),
(2, 101, 'Amoxicillin 250mg Capsules',    'Broad-spectrum antibiotic.',                    2, 120, 8.00,  12.50, '2026-05-01', '2027-08-31'),
(3, 101, 'Vitamin C 500mg Tablets',       'Immune support supplement.',                    3, 300, 4.20,  7.00,  '2026-05-01', '2028-01-31'),
(4, 102, 'Cetirizine 10mg Tablets',       'Antihistamine for allergy and cold symptoms.',  4,  180, 2.80,  4.50,  '2026-04-10', '2027-06-30'),
(5, 102, 'Omeprazole 20mg Capsules',      'Reduces stomach acid production.',              5,  90,  6.50,  10.00, '2026-04-10', '2027-09-30'),
(6, 102, 'Azithromycin 500mg Tablets',    'Antibiotic for bacterial infections.',          6,  60,  15.00, 22.00, '2026-04-10', '2027-04-30'),
(7, 103, 'Ibuprofen 400mg Tablets',       'Pain and inflammation reliever.',               7,  200, 3.00,  5.50,  '2026-06-28', '2027-12-31'),
(8, 103, 'Multivitamin Tablets',          'Daily multivitamin and mineral supplement.',    8,  150, 5.00,  8.50,  '2026-06-28', '2028-03-31');

-- --------------------------------------------------------
-- user_order_tbl
-- --------------------------------------------------------

INSERT INTO `user_order_tbl` (`o_id`, `m_id`, `pharmacy_id`, `price`, `quantity`, `total_amount`, `status`, `order_date`) VALUES
(1, 1, 101, 5.00, 50, 250.00, 'completed', '2026-05-10'),
(2, 2, 101, 12.50, 20, 250.00, 'completed', '2026-06-01'),
(3, 4, 102, 4.50, 40, 180.00, 'pending',   '2026-06-20'),
(4, 7, 103, 5.50, 30, 165.00, 'cancelled', '2026-06-15');

-- --------------------------------------------------------
-- user_sales_tbl
-- --------------------------------------------------------

INSERT INTO `user_sales_tbl` (`s_id`, `m_id`, `pharmacy_id`, `price`, `quantity`, `total_amount`, `status`, `sales_date`) VALUES
(1, 1, 101, 5.00, 15, 75.00, 'completed', '2026-06-25'),
(2, 3, 101, 7.00, 10, 70.00, 'completed', '2026-06-28'),
(3, 5, 102, 10.00, 5, 50.00, 'completed', '2026-06-30'),
(4, 8, 103, 8.50, 8, 68.00, 'completed', '2026-07-01');
