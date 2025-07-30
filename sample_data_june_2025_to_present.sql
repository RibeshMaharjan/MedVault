-- SQL Script to generate sample data for sales and orders from June 1, 2025 to July 31, 2025
-- This script will:
-- 1. Generate additional sample records for sales data from June 1, 2025 to July 31, 2025
-- 2. Generate corresponding order data for the same period
-- 3. Preserve existing data (does NOT delete any existing records)

-- Step 1: Generate sample records for sales data from June 1, 2025 to July 31, 2025
-- Variables to track the next ID to use - start from a high number to avoid conflicts
SET @next_sales_id = 250; -- Assuming existing IDs are below 250
SET @pharmacy_id = 4;

-- Insert sales data for June 1, 2025 to July 31, 2025
INSERT INTO user_sales_tbl (s_id, m_id, pharmacy_id, price, quantity, total_amount, status, sales_date)
VALUES
-- June 1, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-06-01'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-06-01'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-06-01'),

-- June 2, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-06-02'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-06-02'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-06-02'),

-- June 3, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-06-03'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-06-03'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-06-03'),

-- June 4, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-06-04'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-06-04'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-06-04'),

-- June 5, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-06-05'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 5, 5*100, 'completed', '2025-06-05'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-06-05'),

-- June 6, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-06-06'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-06-06'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-06-06'),

-- June 7, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-06-07'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-06-07'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-06-07'),

-- June 8, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', '2025-06-08'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', '2025-06-08'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-06-08'),

-- June 9, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-06-09'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-06-09'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 2, 2*170, 'completed', '2025-06-09'),

-- June 10, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-06-10'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-06-10'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-06-10'),

-- June 11, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-06-11'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-06-11'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-06-11'),

-- June 12, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-06-12'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-06-12'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', '2025-06-12'),

-- June 13, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-06-13'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 3, 3*100, 'completed', '2025-06-13'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-06-13'),

-- June 14, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-06-14'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-06-14'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-06-14'),

-- June 15, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-06-15'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-06-15'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-06-15'),

-- June 16, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-06-16'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-06-16'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-06-16'),

-- June 17, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-06-17'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-06-17'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-06-17'),

-- June 18, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-06-18'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-06-18'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-06-18'),

-- June 19, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-06-19'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-06-19'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-06-19'),

-- June 20, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-06-20'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 5, 5*100, 'completed', '2025-06-20'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-06-20'),

-- June 21, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-06-21'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-06-21'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-06-21'),

-- June 22, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-06-22'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-06-22'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-06-22'),

-- June 23, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', '2025-06-23'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', '2025-06-23'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-06-23'),

-- June 24, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-06-24'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-06-24'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 2, 2*170, 'completed', '2025-06-24'),

-- June 25, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-06-25'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-06-25'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-06-25'),

-- June 26, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-06-26'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-06-26'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-06-26'),

-- June 27, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-06-27'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-06-27'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', '2025-06-27'),

-- June 28, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-06-28'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 3, 3*100, 'completed', '2025-06-28'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-06-28'),

-- June 29, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-06-29'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-06-29'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-06-29'),

-- June 30, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-06-30'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-06-30'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-06-30'),

-- July 1, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-07-01'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-07-01'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-07-01'),

-- July 2, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-07-02'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-07-02'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-02'),

-- July 3, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-07-03'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-03'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-07-03'),

-- July 4, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-07-04'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-07-04'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-07-04'),

-- July 5, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-07-05'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 5, 5*100, 'completed', '2025-07-05'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-07-05'),

-- July 6, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-07-06'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-07-06'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-06'),

-- July 7, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', '2025-07-07'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', '2025-07-07'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-07-07'),

-- July 8, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-07-08'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-07-08'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 2, 2*170, 'completed', '2025-07-08'),

-- July 9, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-07-09'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-07-09'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-07-09'),

-- July 10, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-07-10'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-10'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-07-10'),

-- July 11, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-07-11'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-07-11'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', '2025-07-11'),

-- July 12, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-07-12'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 3, 3*100, 'completed', '2025-07-12'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-07-12'),

-- July 13, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-07-13'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-07-13'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-07-13'),

-- July 14, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-07-14'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-07-14'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-07-14'),

-- July 15, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-07-15'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-07-15'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-07-15'),

-- July 16, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-07-16'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-07-16'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-16'),

-- July 17, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-07-17'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-17'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-07-17'),

-- July 18, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-07-18'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-07-18'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-07-18'),

-- July 19, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-07-19'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 5, 5*100, 'completed', '2025-07-19'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-07-19'),

-- July 20, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-07-20'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-07-20'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-07-20'),

-- July 21, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-07-21'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-07-21'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-21'),

-- July 22, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', '2025-07-22'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', '2025-07-22'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-07-22'),

-- July 23, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-07-23'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-07-23'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 2, 2*170, 'completed', '2025-07-23'),

-- July 24, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-07-24'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-07-24'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-07-24'),

-- July 25, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', '2025-07-25'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-25'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-07-25'),

-- July 26, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', '2025-07-26'),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', '2025-07-26'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', '2025-07-26'),

-- July 27, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', '2025-07-27'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 3, 3*100, 'completed', '2025-07-27'),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', '2025-07-27'),

-- July 28, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 7, 7*60, 'completed', '2025-07-28'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', '2025-07-28'),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', '2025-07-28'),

-- July 29, 2025
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', '2025-07-29'),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', '2025-07-29'),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', '2025-07-29'),

-- July 30, 2025
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', '2025-07-30'),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', '2025-07-30'),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', '2025-07-30'),

-- July 31, 2025
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', '2025-07-31'),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', '2025-07-31'),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', '2025-07-31');

-- Step 2: Generate corresponding order data
-- Variables to track the next ID to use - start from a high number to avoid conflicts
SET @next_order_id = 200; -- Assuming existing IDs are below 200

-- Insert order data for June 2025
INSERT INTO user_order_tbl (o_id, m_id, pharmacy_id, price, quantity, total_amount, status, order_date)
VALUES
-- Orders placed on June 2, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-06-02'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-06-02'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-06-02'),

-- Orders placed on June 5, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-06-05'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-06-05'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-06-05'),

-- Orders placed on June 8, 2025
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', '2025-06-08'),
(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', '2025-06-08'),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', '2025-06-08'),

-- Orders placed on June 11, 2025
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', '2025-06-11'),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', '2025-06-11'),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', '2025-06-11'),

-- Orders placed on June 14, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-06-14'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-06-14'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-06-14'),

-- Orders placed on June 17, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-06-17'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-06-17'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-06-17'),

-- Orders placed on June 20, 2025
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', '2025-06-20'),
(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', '2025-06-20'),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', '2025-06-20'),

-- Orders placed on June 23, 2025
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', '2025-06-23'),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', '2025-06-23'),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', '2025-06-23'),

-- Orders placed on June 26, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-06-26'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-06-26'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-06-26'),

-- Orders placed on June 29, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-06-29'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-06-29'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-06-29'),

-- Orders placed on July 2, 2025
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', '2025-07-02'),
(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', '2025-07-02'),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', '2025-07-02'),

-- Orders placed on July 5, 2025
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', '2025-07-05'),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', '2025-07-05'),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', '2025-07-05'),

-- Orders placed on July 8, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-07-08'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-07-08'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-07-08'),

-- Orders placed on July 11, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-07-11'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-07-11'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-07-11'),

-- Orders placed on July 14, 2025
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', '2025-07-14'),
(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', '2025-07-14'),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', '2025-07-14'),

-- Orders placed on July 17, 2025
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', '2025-07-17'),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', '2025-07-17'),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', '2025-07-17'),

-- Orders placed on July 20, 2025
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', '2025-07-20'),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', '2025-07-20'),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', '2025-07-20'),

-- Orders placed on July 23, 2025
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', '2025-07-23'),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', '2025-07-23'),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', '2025-07-23'),

-- Orders placed on July 26, 2025
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', '2025-07-26'),
(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', '2025-07-26'),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', '2025-07-26'),

-- Orders placed on July 29, 2025
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', '2025-07-29'),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', '2025-07-29'),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', '2025-07-29');
