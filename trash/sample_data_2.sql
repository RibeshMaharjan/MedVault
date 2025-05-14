-- SQL Script to generate sample data for sales and orders
-- This script will:
-- 1. Delete existing sales and order data for pharmacy_id = 4
-- 2. Generate 100 sample records for sales data
-- 3. Generate corresponding order data

-- Step 1: Delete existing sales and order data for pharmacy_id = 4
DELETE FROM user_sales_tbl WHERE pharmacy_id = 4;
DELETE FROM user_order_tbl WHERE pharmacy_id = 4;

-- Reset auto-increment values if needed (uncomment if your tables use auto_increment)
-- ALTER TABLE user_sales_tbl AUTO_INCREMENT = 1;
-- ALTER TABLE user_order_tbl AUTO_INCREMENT = 1;

-- Step 2: Generate 100 sample records for sales data
-- We'll create sales data for the last 100 days with some variation in quantities and medicines

-- Variables to track the next ID to use
SET @next_sales_id = 1;
SET @pharmacy_id = 4;

-- Get the current date for reference
SET @current_date = CURDATE();

-- Insert sales data for the last 100 days
INSERT INTO user_sales_tbl (s_id, m_id, pharmacy_id, price, quantity, total_amount, status, sales_date)
VALUES
-- Day 1-10 (Most recent 10 days)
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 3, 3*60, 'completed', DATE_SUB(@current_date, INTERVAL 0 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', DATE_SUB(@current_date, INTERVAL 0 DAY)),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 5, 5*100, 'completed', DATE_SUB(@current_date, INTERVAL 1 DAY)),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', DATE_SUB(@current_date, INTERVAL 1 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', DATE_SUB(@current_date, INTERVAL 2 DAY)),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', DATE_SUB(@current_date, INTERVAL 2 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', DATE_SUB(@current_date, INTERVAL 3 DAY)),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', DATE_SUB(@current_date, INTERVAL 3 DAY)),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 3, 3*190, 'completed', DATE_SUB(@current_date, INTERVAL 4 DAY)),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 6, 6*170, 'completed', DATE_SUB(@current_date, INTERVAL 4 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 1, 1*220, 'completed', DATE_SUB(@current_date, INTERVAL 5 DAY)),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', DATE_SUB(@current_date, INTERVAL 5 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', DATE_SUB(@current_date, INTERVAL 6 DAY)),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 3, 3*100, 'completed', DATE_SUB(@current_date, INTERVAL 6 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 2, 2*150, 'completed', DATE_SUB(@current_date, INTERVAL 7 DAY)),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', DATE_SUB(@current_date, INTERVAL 7 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', DATE_SUB(@current_date, INTERVAL 8 DAY)),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 2, 2*190, 'completed', DATE_SUB(@current_date, INTERVAL 8 DAY)),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', DATE_SUB(@current_date, INTERVAL 9 DAY)),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 2, 2*320, 'completed', DATE_SUB(@current_date, INTERVAL 9 DAY)),

-- Day 11-20
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', DATE_SUB(@current_date, INTERVAL 10 DAY)),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', DATE_SUB(@current_date, INTERVAL 10 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', DATE_SUB(@current_date, INTERVAL 11 DAY)),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', DATE_SUB(@current_date, INTERVAL 11 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', DATE_SUB(@current_date, INTERVAL 12 DAY)),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 4, 4*100, 'completed', DATE_SUB(@current_date, INTERVAL 12 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 2, 2*150, 'completed', DATE_SUB(@current_date, INTERVAL 13 DAY)),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', DATE_SUB(@current_date, INTERVAL 13 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 3, 3*60, 'completed', DATE_SUB(@current_date, INTERVAL 14 DAY)),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 2, 2*280, 'completed', DATE_SUB(@current_date, INTERVAL 14 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 1, 1*220, 'completed', DATE_SUB(@current_date, INTERVAL 15 DAY)),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', DATE_SUB(@current_date, INTERVAL 15 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', DATE_SUB(@current_date, INTERVAL 16 DAY)),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', DATE_SUB(@current_date, INTERVAL 16 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', DATE_SUB(@current_date, INTERVAL 17 DAY)),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', DATE_SUB(@current_date, INTERVAL 17 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', DATE_SUB(@current_date, INTERVAL 18 DAY)),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 2, 2*100, 'completed', DATE_SUB(@current_date, INTERVAL 18 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', DATE_SUB(@current_date, INTERVAL 19 DAY)),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', DATE_SUB(@current_date, INTERVAL 19 DAY)),

-- Day 21-30
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 3, 3*60, 'completed', DATE_SUB(@current_date, INTERVAL 20 DAY)),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', DATE_SUB(@current_date, INTERVAL 20 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', DATE_SUB(@current_date, INTERVAL 21 DAY)),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', DATE_SUB(@current_date, INTERVAL 21 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', DATE_SUB(@current_date, INTERVAL 22 DAY)),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', DATE_SUB(@current_date, INTERVAL 22 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', DATE_SUB(@current_date, INTERVAL 23 DAY)),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', DATE_SUB(@current_date, INTERVAL 23 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', DATE_SUB(@current_date, INTERVAL 24 DAY)),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 3, 3*100, 'completed', DATE_SUB(@current_date, INTERVAL 24 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 2, 2*150, 'completed', DATE_SUB(@current_date, INTERVAL 25 DAY)),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 2, 2*170, 'completed', DATE_SUB(@current_date, INTERVAL 25 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', DATE_SUB(@current_date, INTERVAL 26 DAY)),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', DATE_SUB(@current_date, INTERVAL 26 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', DATE_SUB(@current_date, INTERVAL 27 DAY)),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', DATE_SUB(@current_date, INTERVAL 27 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', DATE_SUB(@current_date, INTERVAL 28 DAY)),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', DATE_SUB(@current_date, INTERVAL 28 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', DATE_SUB(@current_date, INTERVAL 29 DAY)),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', DATE_SUB(@current_date, INTERVAL 29 DAY)),

-- Day 31-40
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', DATE_SUB(@current_date, INTERVAL 30 DAY)),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 2, 2*100, 'completed', DATE_SUB(@current_date, INTERVAL 30 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', DATE_SUB(@current_date, INTERVAL 31 DAY)),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', DATE_SUB(@current_date, INTERVAL 31 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 3, 3*60, 'completed', DATE_SUB(@current_date, INTERVAL 32 DAY)),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', DATE_SUB(@current_date, INTERVAL 32 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 4, 4*150, 'completed', DATE_SUB(@current_date, INTERVAL 33 DAY)),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 1, 1*500, 'completed', DATE_SUB(@current_date, INTERVAL 33 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 6, 6*60, 'completed', DATE_SUB(@current_date, INTERVAL 34 DAY)),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', DATE_SUB(@current_date, INTERVAL 34 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', DATE_SUB(@current_date, INTERVAL 35 DAY)),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 3, 3*170, 'completed', DATE_SUB(@current_date, INTERVAL 35 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', DATE_SUB(@current_date, INTERVAL 36 DAY)),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 2, 2*190, 'completed', DATE_SUB(@current_date, INTERVAL 36 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 3, 3*150, 'completed', DATE_SUB(@current_date, INTERVAL 37 DAY)),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', DATE_SUB(@current_date, INTERVAL 37 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', DATE_SUB(@current_date, INTERVAL 38 DAY)),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 2, 2*100, 'completed', DATE_SUB(@current_date, INTERVAL 38 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 1, 1*220, 'completed', DATE_SUB(@current_date, INTERVAL 39 DAY)),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', DATE_SUB(@current_date, INTERVAL 39 DAY)),

-- Day 41-50 (with some anomalies for testing anomaly detection)
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 15, 15*60, 'completed', DATE_SUB(@current_date, INTERVAL 40 DAY)), -- Anomaly: high quantity
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', DATE_SUB(@current_date, INTERVAL 40 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 2, 2*150, 'completed', DATE_SUB(@current_date, INTERVAL 41 DAY)),
(@next_sales_id := @next_sales_id + 1, 11, @pharmacy_id, 220, 1, 1*220, 'completed', DATE_SUB(@current_date, INTERVAL 41 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', DATE_SUB(@current_date, INTERVAL 42 DAY)),
(@next_sales_id := @next_sales_id + 1, 8, @pharmacy_id, 500, 3, 3*500, 'completed', DATE_SUB(@current_date, INTERVAL 42 DAY)), -- Anomaly: high value item
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 2, 2*220, 'completed', DATE_SUB(@current_date, INTERVAL 43 DAY)),
(@next_sales_id := @next_sales_id + 1, 7, @pharmacy_id, 320, 1, 1*320, 'completed', DATE_SUB(@current_date, INTERVAL 43 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 3, 3*60, 'completed', DATE_SUB(@current_date, INTERVAL 44 DAY)),
(@next_sales_id := @next_sales_id + 1, 5, @pharmacy_id, 100, 2, 2*100, 'completed', DATE_SUB(@current_date, INTERVAL 44 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 1, 1*150, 'completed', DATE_SUB(@current_date, INTERVAL 45 DAY)),
(@next_sales_id := @next_sales_id + 1, 10, @pharmacy_id, 170, 2, 2*170, 'completed', DATE_SUB(@current_date, INTERVAL 45 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 4, 4*60, 'completed', DATE_SUB(@current_date, INTERVAL 46 DAY)),
(@next_sales_id := @next_sales_id + 1, 6, @pharmacy_id, 190, 1, 1*190, 'completed', DATE_SUB(@current_date, INTERVAL 46 DAY)),
(@next_sales_id := @next_sales_id + 1, 2, @pharmacy_id, 220, 3, 3*220, 'completed', DATE_SUB(@current_date, INTERVAL 47 DAY)),
(@next_sales_id := @next_sales_id + 1, 9, @pharmacy_id, 420, 1, 1*420, 'completed', DATE_SUB(@current_date, INTERVAL 47 DAY)),
(@next_sales_id := @next_sales_id + 1, 1, @pharmacy_id, 60, 5, 5*60, 'completed', DATE_SUB(@current_date, INTERVAL 48 DAY)),
(@next_sales_id := @next_sales_id + 1, 4, @pharmacy_id, 280, 1, 1*280, 'completed', DATE_SUB(@current_date, INTERVAL 48 DAY)),
(@next_sales_id := @next_sales_id + 1, 3, @pharmacy_id, 150, 2, 2*150, 'completed', DATE_SUB(@current_date, INTERVAL 49 DAY)),
(@next_sales_id := @next_sales_id + 1, 12, @pharmacy_id, 190, 1, 1*190, 'completed', DATE_SUB(@current_date, INTERVAL 49 DAY));

-- Step 3: Generate corresponding order data
-- We'll create order data that is consistent with the sales data
-- Orders typically precede sales and are for larger quantities

-- Variables to track the next ID to use
SET @next_order_id = 1;

-- Insert order data
INSERT INTO user_order_tbl (o_id, m_id, pharmacy_id, price, quantity, total_amount, status, order_date)
VALUES
-- Orders for common medicines (placed every 2 weeks)
(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', DATE_SUB(@current_date, INTERVAL 60 DAY)),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', DATE_SUB(@current_date, INTERVAL 60 DAY)),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', DATE_SUB(@current_date, INTERVAL 60 DAY)),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', DATE_SUB(@current_date, INTERVAL 60 DAY)),

(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', DATE_SUB(@current_date, INTERVAL 45 DAY)),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', DATE_SUB(@current_date, INTERVAL 45 DAY)),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', DATE_SUB(@current_date, INTERVAL 45 DAY)),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', DATE_SUB(@current_date, INTERVAL 45 DAY)),

(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', DATE_SUB(@current_date, INTERVAL 30 DAY)),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', DATE_SUB(@current_date, INTERVAL 30 DAY)),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', DATE_SUB(@current_date, INTERVAL 30 DAY)),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', DATE_SUB(@current_date, INTERVAL 30 DAY)),

(@next_order_id := @next_order_id + 1, 1, @pharmacy_id, 50, 50, 50*50, 'pending', DATE_SUB(@current_date, INTERVAL 15 DAY)),
(@next_order_id := @next_order_id + 1, 2, @pharmacy_id, 180, 30, 30*180, 'pending', DATE_SUB(@current_date, INTERVAL 15 DAY)),
(@next_order_id := @next_order_id + 1, 3, @pharmacy_id, 120, 40, 40*120, 'pending', DATE_SUB(@current_date, INTERVAL 15 DAY)),
(@next_order_id := @next_order_id + 1, 5, @pharmacy_id, 80, 50, 50*80, 'pending', DATE_SUB(@current_date, INTERVAL 15 DAY)),

-- Orders for less common medicines (placed monthly)
(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', DATE_SUB(@current_date, INTERVAL 55 DAY)),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', DATE_SUB(@current_date, INTERVAL 55 DAY)),
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', DATE_SUB(@current_date, INTERVAL 55 DAY)),
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', DATE_SUB(@current_date, INTERVAL 55 DAY)),

(@next_order_id := @next_order_id + 1, 4, @pharmacy_id, 240, 20, 20*240, 'pending', DATE_SUB(@current_date, INTERVAL 25 DAY)),
(@next_order_id := @next_order_id + 1, 6, @pharmacy_id, 160, 25, 25*160, 'pending', DATE_SUB(@current_date, INTERVAL 25 DAY)),
(@next_order_id := @next_order_id + 1, 7, @pharmacy_id, 280, 15, 15*280, 'pending', DATE_SUB(@current_date, INTERVAL 25 DAY)),
(@next_order_id := @next_order_id + 1, 10, @pharmacy_id, 140, 30, 30*140, 'pending', DATE_SUB(@current_date, INTERVAL 25 DAY)),

-- Orders for specialty medicines (placed less frequently)
(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', DATE_SUB(@current_date, INTERVAL 50 DAY)),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', DATE_SUB(@current_date, INTERVAL 50 DAY)),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', DATE_SUB(@current_date, INTERVAL 50 DAY)),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', DATE_SUB(@current_date, INTERVAL 50 DAY)),

(@next_order_id := @next_order_id + 1, 8, @pharmacy_id, 450, 10, 10*450, 'pending', DATE_SUB(@current_date, INTERVAL 20 DAY)),
(@next_order_id := @next_order_id + 1, 9, @pharmacy_id, 380, 10, 10*380, 'pending', DATE_SUB(@current_date, INTERVAL 20 DAY)),
(@next_order_id := @next_order_id + 1, 11, @pharmacy_id, 180, 15, 15*180, 'pending', DATE_SUB(@current_date, INTERVAL 20 DAY)),
(@next_order_id := @next_order_id + 1, 12, @pharmacy_id, 160, 15, 15*160, 'pending', DATE_SUB(@current_date, INTERVAL 20 DAY));
