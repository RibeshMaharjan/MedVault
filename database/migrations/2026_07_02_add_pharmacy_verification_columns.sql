ALTER TABLE tbl_pharmacy
  ADD COLUMN isverified TINYINT(1) NOT NULL DEFAULT 0,
  ADD COLUMN license_number VARCHAR(100) NULL,
  ADD COLUMN reg_document VARCHAR(255) NULL,
  ADD COLUMN verification_request_date DATETIME NULL,
  ADD COLUMN verification_date DATETIME NULL,
  ADD COLUMN verification_notes TEXT NULL;
