-- SQL Script to generate sample data for sales and orders for May 3-14, 2025
-- This script will:
-- 1. Delete existing sales and order data for pharmacy_id = 4
-- 2. Generate sample records for sales data for May 3-14, 2025
-- 3. Generate corresponding order data for the same period

-- Step 1: Delete existing sales and order data for pharmacy_id = 4
DELETE FROM user_sales_tbl WHERE pharmacy_id = 4;
DELETE FROM user_order_tbl WHERE pharmacy_id = 4;

-- Reset auto-increment values if needed (uncomment if your tables use auto_increment)
-- ALTER TABLE user_sales_tbl AUTO_INCREMENT = 1;
-- ALTER TABLE user_order_tbl AUTO_INCREMENT = 1;

-- Step 2: Generate sample records for sales data for May 3-14, 2025
-- Variables to track the next ID to use
SET @next_sales_id = 1;
SET @pharmacy_id = 4;

-- Insert sales data for May 3-14, 2025
INSERT INTO user_sales_tbl (s_id, m_id, pharmacy_id, price, quantity, total_amount, status, sales_date)
VALUES
-- May 3, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 3, 3*60, 'completed', '2025-05-03'),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-05-03'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 5, 5*100, 'completed', '2025-05-03'),

-- May 4, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-05-04'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', '2025-05-04'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-05-04'),

-- May 5, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-05-05'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-05-05'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-05-05'),

-- May 6, 2025
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-05-06'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 6, 6*170, 'completed', '2025-05-06'),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-05-06'),

-- May 7, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', '2025-05-07'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 3, 3*100, 'completed', '2025-05-07'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-05-07'),

-- May 8, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 2, 2*150, 'completed', '2025-05-08'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-05-08'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-05-08'),

-- May 9, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-05-09'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-05-09'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-05-09'),

-- May 10, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-05-10'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-05-10'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-05-10'),

-- May 11, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-05-11'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-05-11'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-05-11'),

-- May 12, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-05-12'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', '2025-05-12'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-05-12'),

-- May 13, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', '2025-05-13'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-05-13'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', '2025-05-13'),

-- May 14, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-05-14'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-05-14'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-05-14');

-- Step 3: Generate corresponding order data
-- Variables to track the next ID to use
SET @next_order_id = 1;

-- Insert order data for May 2025
INSERT INTO user_order_tbl (o_id, m_id, pharmacy_id, price, quantity, total_amount, status, order_date)
VALUES
-- Orders placed on May 3, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-05-03'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-05-03'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-05-03'),

-- Orders placed on May 5, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-05-05'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-05-05'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-05-05'),

-- Orders placed on May 8, 2025
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', '2025-05-08'),
(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', '2025-05-08'),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', '2025-05-08'),

-- Orders placed on May 10, 2025
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', '2025-05-10'),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', '2025-05-10'),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', '2025-05-10'),

-- Orders placed on May 12, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-05-12'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-05-12'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-05-12'),

-- Orders placed on May 14, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-05-14'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-05-14'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-05-14');