# MedVault Project Overview

MedVault is a vanilla PHP MVC pharmacy management system. It supports pharmacy users and admins through shared `routes.php`, controllers under `app/Controllers`, models under `app/Models`, and templates under `views`.

## Runtime Stack

- PHP 8.x
- MySQL/MariaDB in normal runtime
- SQLite in PHPUnit tests through `DB_DRIVER=sqlite`
- Bootstrap, jQuery, Chart.js
- PHPUnit 10

## Current Architecture

```text
app/
  Controllers/
    Admin/
    Pharmacy/
    AuthController.php
  Core/
    App.php
    Controller.php
    Database.php
    Model.php
    Router.php
    Security/Csrf.php
    Session.php
  Middleware/
  Models/
views/
  admin/
  auth/
  layouts/
  pharmacy/
  partials/
public/
  index.php
  assets/
routes.php
tests/
database/migrations/
```

## Core Flows

- Auth: `/login`, `/register`, `/logout`.
- Pharmacy: dashboard, categories, medicines, orders, sales, profile, verification request.
- Admin: dashboard, admins, pharmacies, verification approve/reject, settings, order export.
- APIs: medicine search/row, sales analytics, order analytics, inventory levels.

## Data Model

Current main tables:

- `role`
- `tbl_admin`
- `tbl_pharmacy`
- `user_category_tbl`
- `user_medicine_tbl`
- `user_order_tbl`
- `user_sales_tbl`
- `settings`

Legacy tables may remain in `pharmacy.sql`, but current app paths use `user_order_tbl` and `user_sales_tbl`.

## Stabilized Behavior

- PHPUnit runs through Docker and SQLite test support.
- Pharmacy verification columns exist in `pharmacy.sql` and migration file.
- Pharmacy-owned data access is scoped by `pharmacy_id`.
- Orders reserve stock once and restore stock on delete/update.
- Sales validate stock before completion.
- Order/sale totals are calculated from server-side medicine prices.
- Stock-changing writes use transactions.
- POST routes require CSRF token.
- Verification document upload checks MIME type and size.
- Analytics routes return tested JSON shapes.
- Admin order export uses current schema and deterministic CSV headers.

## Validation Commands

```bash
find app routes.php public views tests -name '*.php' -print0 | xargs -0 -n1 php -l
docker run --rm -v "$PWD:/var/www/html" -w /var/www/html medvault-app:latest php vendor/bin/phpunit --configuration phpunit.xml --fail-on-all-issues
```

## Manual Regression Checklist

- Login/logout as pharmacy and admin.
- Register new pharmacy.
- Submit verification request with valid document.
- Reject unsafe upload type.
- Approve/reject pharmacy as admin.
- Create/edit/delete category and medicine.
- Create/update/delete order and sale; verify stock.
- Open sales and order analytics.
- Export admin orders CSV with and without filters.
