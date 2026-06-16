# MedVault — Pharmacy Management System

**MedVault** is a web-based pharmacy management system built as a college project. It provides role-based access for pharmacy owners and system administrators to manage inventory, orders, sales, and analytics.

---

## Tech Stack

| Layer     | Technology                                |
| --------- | ----------------------------------------- |
| Frontend  | HTML5, CSS3, Bootstrap 5, JavaScript, jQuery, Chart.js |
| Backend   | PHP 8.x (vanilla, no framework)           |
| Database  | MySQL / MariaDB via phpMyAdmin            |
| Server    | Apache (XAMPP / WAMP)                     |

---

## Architecture

### Directory Structure

```
MedVault/
├── index.php                  # Landing page
├── config/
│   ├── conn.php               # DB connection
│   └── function.php           # Common helpers: validate, redirect, CRUD, pagination
├── proj-front/                # Pharmacy user interface
│   ├── login.php              # Login & registration
│   ├── validation.php         # Auth logic
│   ├── dashboard.php          # Pharmacy dashboard
│   ├── view-inventory.php     # Medicine inventory
│   ├── medicine-create.php    # Add medicine
│   ├── medicine-display.php   # List / edit / delete medicines
│   ├── order-create.php       # Create orders
│   ├── order-display.php      # Order history
│   ├── sales-create.php       # Record sales
│   ├── sales-display.php      # Sales history
│   ├── analysis-sales.php     # Sales analytics (Chart.js, WMA forecast, anomaly detection)
│   ├── analysis-order.php     # Order analytics
│   ├── category.php           # Category management
│   ├── edit-profile.php       # Pharmacy profile
│   ├── ajax.php               # Autocomplete search for medicines
│   ├── assets/                # CSS, JS, images
│   ├── php/                   # Backend handlers (order-add, sales-add, etc.)
│   └── includes/              # Reusable header/footer
├── proj-back/                 # Admin panel
│   ├── admin.php              # Admin dashboard
│   ├── admin-display.php      # Manage admins
│   ├── pharmacy-display.php   # Manage pharmacies (CRUD + verification)
│   ├── pharmacy-create.php    # Add pharmacy
│   ├── authentication.php     # Admin auth guard
│   ├── code.php               # All admin-side form handlers
│   ├── export.php             # Data export
│   ├── setting.php            # System settings
│   └── verify-pharmacies.php  # Verification workflow
├── pharmacy.sql               # Full database dump
├── uploaded_img/              # Uploaded medicine images
└── docs/
    └── project-overview.md    # This file
```

---

## Database Schema

The database `pharmacy` contains **13 tables**:

| Table                | Purpose                                    |
| -------------------- | ------------------------------------------ |
| `role`               | Users (admin / pharmacy) with hashed passwords |
| `tbl_admin`          | Admin profile details                      |
| `tbl_pharmacy`       | Pharmacy profile, PAN, contact, verification status |
| `tbl_medicine`       | Global medicine catalog (admin-managed)    |
| `user_medicine_tbl`  | Per-pharmacy inventory (stock, prices)     |
| `user_category_tbl`  | Per-pharmacy medicine categories           |
| `user_order_tbl`     | Orders placed by pharmacy                  |
| `user_sales_tbl`     | Sales recorded by pharmacy                 |
| `user_orders`        | Legacy order table (from e-commerce feature) |
| `cart`               | Legacy cart (from e-commerce feature)      |
| `order_address`      | Legacy order addresses                     |
| `order_completed`    | Legacy completed orders                    |
| `order_pending`      | Legacy pending orders                      |
| `inventory`          | Legacy inventory (from e-commerce feature) |
| `settings`           | System-wide settings                       |

### Key Relationships

- `role.user_id` → `tbl_pharmacy.pharmacy_id` / `tbl_admin.admin_id` (FK cascade)
- `user_medicine_tbl.pharmacy_id` → `role.user_id`
- `user_order_tbl.m_id` → `user_medicine_tbl.m_id`
- `user_sales_tbl.m_id` → `user_medicine_tbl.m_id`

---

## Features

### Authentication & Roles
- **Admin** — Full access to manage pharmacies, admins, settings, global medicine catalog
- **Pharmacy** — Manages own inventory, orders, sales, categories; can request verification

### Pharmacy Verification
- Pharmacies submit PAN, license number, and registration document
- Admins review and mark as verified / not verified / pending

### Inventory Management
- Add medicines with name, description, category, buy/sell price, stock quantity, expiration date
- Edit and delete inventory items

### Order Management
- Search medicines via autocomplete, set quantity and future date
- Validates stock availability before placing order
- Auto-decrements stock on order placement
- Order statuses: pending / completed / cancelled

### Sales Management
- Record sales similarly to orders
- View sales history

### Analytics (Sales)
- **Sales trend chart** using Chart.js with period filter (week / month / 3 months)
- **Weighted Moving Average (WMA)** forecasting with dampened trend and day-of-week seasonality
- **Anomaly detection** using Z-score (|Z| > 2 standard deviations)
- **Stock recommendations**: safety stock, reorder point, max stock levels
- **Inventory health**: low stock / out-of-stock counts

### Analytics (Orders)
- Daily order count trend
- Order status distribution (doughnut chart)
- Top ordered medicines, recent order timeline

### Admin Panel
- CRUD for pharmacies and admins
- Pharmacy verification workflow
- Global medicine catalog
- System settings
- Data export

---

## Security

- Passwords hashed with `password_hash()` / `password_verify()`
- Some input sanitization via `mysqli_real_escape_string()`
- **Known gaps**: SQL injection in several queries (direct string interpolation), session checks inconsistent, CSRF not implemented, no prepared statements

---

## Known Bugs & Issues

See the code review for a full list. Key issues include:

1. Undefined variables in `code.php` (pharmacy create/update) and `validation.php` (registration)
2. Sales flow does not decrement inventory stock
3. `ajax.php` has variable name mismatches and incorrect `getById()` usage
4. `get_sales_data.php` has potential `min()` on empty array and incorrect date format for day-of-week calculation
5. Division by zero in order analytics when no data exists
6. SQL injection throughout the codebase
