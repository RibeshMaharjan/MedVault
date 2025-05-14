<?php
include 'config.php';

// SQL to add verification columns to tbl_pharmacy table
$sql = "ALTER TABLE tbl_pharmacy 
        ADD COLUMN isverified TINYINT(1) DEFAULT 0,
        ADD COLUMN reg_document VARCHAR(255) NULL,
        ADD COLUMN license_number VARCHAR(50) NULL,
        ADD COLUMN verification_request_date TIMESTAMP NULL,
        ADD COLUMN verification_date TIMESTAMP NULL,
        ADD COLUMN verification_notes TEXT NULL";

if ($conn->query($sql) === TRUE) {
    echo "Verification columns added successfully to tbl_pharmacy table";
} else {
    echo "Error adding verification columns: " . $conn->error;
}

$conn->close();
?> 