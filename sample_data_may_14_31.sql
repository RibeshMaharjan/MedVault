-- SQL Script to generate additional sample data for sales and orders for May 14-31, 2025
-- This script will:
-- 1. Generate additional sample records for sales data for May 14-31, 2025
-- 2. Generate corresponding order data for the same period
-- 3. Preserve existing data (does NOT delete any existing records)

-- Step 1: Generate sample records for sales data for May 14-31, 2025
-- Variables to track the next ID to use - start from a high number to avoid conflicts
SET @next_sales_id = 100; -- Assuming existing IDs are below 100
SET @pharmacy_id = 4;

-- Insert sales data for May 14-31, 2025
INSERT INTO user_sales_tbl (s_id, m_id, pharmacy_id, price, quantity, total_amount, status, sales_date)
VALUES
-- May 15, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-05-15'),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-05-15'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-05-15'),

-- May 16, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-05-16'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-05-16'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 2, 2*170, 'completed', '2025-05-16'),

-- May 17, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-05-17'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-05-17'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-05-17'),

-- May 18, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-05-18'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-05-18'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-05-18'),

-- May 19, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', '2025-05-19'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-05-19'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-05-19'),

-- May 20, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-05-20'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 5, 5*100, 'completed', '2025-05-20'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-05-20'),

-- May 21, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-05-21'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-05-21'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-05-21'),

-- May 22, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-05-22'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-05-22'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-05-22'),

-- May 23, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-05-23'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', '2025-05-23'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-05-23'),

-- May 24, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-05-24'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 3, 3*100, 'completed', '2025-05-24'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-05-24'),

-- May 25, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-05-25'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-05-25'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-05-25'),

-- May 26, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-05-26'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-05-26'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 4, 4*170, 'completed', '2025-05-26'),

-- May 27, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', '2025-05-27'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-05-27'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', '2025-05-27'),

-- May 28, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-05-28'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-05-28'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-05-28'),

-- May 29, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-05-29'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-05-29'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-05-29'),

-- May 30, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-05-30'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-05-30'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-05-30'),

-- May 31, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-05-31'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-05-31'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-05-31');

-- Step 2: Generate corresponding order data
-- Variables to track the next ID to use - start from a high number to avoid conflicts
SET @next_order_id = 50; -- Assuming existing IDs are below 50

-- Insert order data for May 15-31, 2025
INSERT INTO user_order_tbl (o_id, m_id, pharmacy_id, price, quantity, total_amount, status, order_date)
VALUES
-- Orders placed on May 16, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-05-16'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-05-16'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-05-16'),

-- Orders placed on May 19, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-05-19'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-05-19'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-05-19'),

-- Orders placed on May 22, 2025
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', '2025-05-22'),
(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', '2025-05-22'),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', '2025-05-22'),

-- Orders placed on May 25, 2025
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', '2025-05-25'),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', '2025-05-25'),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', '2025-05-25'),

-- Orders placed on May 28, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-05-28'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-05-28'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-05-28'),

-- Orders placed on May 31, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-05-31'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-05-31'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-05-31');