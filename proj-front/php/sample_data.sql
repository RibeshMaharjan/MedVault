-- First truncate existing data
TRUNCATE TABLE user_sales_tbl;
TRUNCATE TABLE user_order_tbl;
TRUNCATE TABLE user_medicine_tbl;
TRUNCATE TABLE user_category_tbl;

-- Insert medicine categories
INSERT INTO user_category_tbl (pharmacy_id, category_name) VALUES
(4, 'Tablets'),
(4, 'Capsules'),
(4, 'Syrups'),
(4, 'Injections'),
(4, 'Ointments'),
(4, 'Drops');

-- Insert medicines (30 items with realistic names and prices)
INSERT INTO user_medicine_tbl (pharmacy_id, medicine_name, medicine_desc, c_id, in_stock, buy_price, sell_price, added_date, exp_date) VALUES
-- Tablets
(4, 'Paracetamol 500mg', 'Pain reliever and fever reducer', 1, 500, 50, 60, NOW(), '2025-12-31'),
(4, 'Amoxicillin 250mg', 'Antibiotic for bacterial infections', 1, 200, 180, 220, NOW(), '2025-10-15'),
(4, 'Metformin 500mg', 'Diabetes medication', 1, 300, 120, 150, NOW(), '2025-11-30'),
(4, 'Amlodipine 5mg', 'Blood pressure medication', 1, 200, 240, 280, NOW(), '2025-09-30'),
(4, 'Cetirizine 10mg', 'Antihistamine for allergies', 1, 400, 80, 100, NOW(), '2025-12-15'),

-- Capsules
(4, 'Omeprazole 20mg', 'Acid reflux medication', 2, 250, 160, 190, NOW(), '2025-11-15'),
(4, 'Doxycycline 100mg', 'Antibiotic', 2, 150, 280, 320, NOW(), '2025-10-30'),
(4, 'Gabapentin 300mg', 'Nerve pain medication', 2, 180, 450, 500, NOW(), '2025-12-20'),
(4, 'Fluoxetine 20mg', 'Antidepressant', 2, 120, 380, 420, NOW(), '2025-11-25'),
(4, 'Vitamin D3 1000IU', 'Vitamin supplement', 2, 300, 140, 170, NOW(), '2025-10-20'),

-- Syrups
(4, 'Cough Syrup 100ml', 'For dry cough relief', 3, 100, 180, 220, NOW(), '2025-11-30'),
(4, 'Children''s Paracetamol', 'Fever reducer for children', 3, 150, 160, 190, NOW(), '2025-12-15'),
(4, 'Antacid Suspension', 'For acid reflux relief', 3, 120, 140, 170, NOW(), '2025-10-25'),
(4, 'Iron Supplement Syrup', 'Iron deficiency treatment', 3, 80, 280, 320, NOW(), '2025-11-20'),
(4, 'Multivitamin Syrup', 'General vitamin supplement', 3, 100, 220, 260, NOW(), '2025-12-10'),

-- Injections
(4, 'Insulin Regular', 'Diabetes treatment', 4, 50, 480, 540, NOW(), '2025-09-30'),
(4, 'B12 Injection', 'Vitamin B12 supplement', 4, 80, 380, 420, NOW(), '2025-10-15'),
(4, 'Tetanus Toxoid', 'Tetanus prevention', 4, 100, 280, 320, NOW(), '2025-11-30'),
(4, 'Diclofenac Injection', 'Pain relief injection', 4, 120, 180, 220, NOW(), '2025-12-15'),
(4, 'Dexamethasone', 'Anti-inflammatory', 4, 90, 320, 360, NOW(), '2025-10-20'),

-- Ointments
(4, 'Antibiotic Cream', 'For skin infections', 5, 150, 140, 170, NOW(), '2025-12-15'),
(4, 'Anti-fungal Ointment', 'For fungal infections', 5, 120, 180, 220, NOW(), '2025-11-30'),
(4, 'Pain Relief Gel', 'Topical pain reliever', 5, 100, 240, 280, NOW(), '2025-10-15'),
(4, 'Burn Cream', 'For minor burns', 5, 80, 160, 190, NOW(), '2025-12-20'),
(4, 'Moisturizing Cream', 'For dry skin', 5, 200, 120, 150, NOW(), '2025-11-15'),

-- Drops
(4, 'Eye Drops', 'For dry eyes', 6, 150, 180, 220, NOW(), '2025-12-31'),
(4, 'Ear Drops', 'For ear infections', 6, 100, 160, 190, NOW(), '2025-11-30'),
(4, 'Nasal Drops', 'For nasal congestion', 6, 120, 140, 170, NOW(), '2025-10-15'),
(4, 'Allergy Eye Drops', 'For eye allergies', 6, 90, 220, 260, NOW(), '2025-12-20'),
(4, 'Antibiotic Eye Drops', 'For eye infections', 6, 80, 280, 320, NOW(), '2025-11-15');

-- Insert sample sales data for last 4 months (120 days)
INSERT INTO user_sales_tbl (m_id, pharmacy_id, price, quantity, total_amount, status, sales_date)
SELECT 
    m_id,
    pharmacy_id,
    sell_price,
    FLOOR(1 + RAND() * 5),
    sell_price * FLOOR(1 + RAND() * 5),
    'completed',
    DATE_SUB(CURDATE(), INTERVAL n DAY)
FROM 
    user_medicine_tbl
    JOIN (
        SELECT a.N + b.N * 10 + c.N * 100 as n
        FROM (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a
        JOIN (SELECT 0 AS N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) b
        JOIN (SELECT 0 AS N UNION SELECT 1) c
    ) numbers
WHERE 
    pharmacy_id = 4 
    AND n <= 120;

-- Insert sample orders
INSERT INTO user_order_tbl (m_id, pharmacy_id, price, quantity, total_amount, status, order_date)
SELECT 
    m_id,
    pharmacy_id,
    sell_price * 0.8,
    FLOOR(10 + RAND() * 20),
    sell_price * 0.8 * FLOOR(10 + RAND() * 20),
    'pending',
    DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 120) DAY)
FROM user_medicine_tbl 
WHERE pharmacy_id = 4
LIMIT 100;

-- Verify data
SELECT 'Categories' as type, COUNT(*) as count FROM user_category_tbl WHERE pharmacy_id = 4
UNION ALL
SELECT 'Medicines', COUNT(*) FROM user_medicine_tbl WHERE pharmacy_id = 4
UNION ALL
SELECT 'Sales Records', COUNT(*) FROM user_sales_tbl WHERE pharmacy_id = 4
UNION ALL
SELECT 'Order Records', COUNT(*) FROM user_order_tbl WHERE pharmacy_id = 4;

-- Show daily sales summary
SELECT 
    DATE(sales_date) as sale_date,
    COUNT(*) as transactions,
    SUM(total_amount) as daily_total,
    MIN(total_amount) as min_sale,
    MAX(total_amount) as max_sale,
    AVG(total_amount) as avg_sale
FROM user_sales_tbl
WHERE pharmacy_id = 4
GROUP BY DATE(sales_date)
ORDER BY sale_date; 