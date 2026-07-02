# MedVault

MedVault is a vanilla PHP MVC pharmacy management app with pharmacy and admin roles.

## Structure

- `app/Core/` - router, controller, model, database, session, security helpers.
- `app/Controllers/` - auth, admin, pharmacy, analytics, AJAX endpoints.
- `app/Models/` - data access for users, pharmacies, inventory, orders, sales.
- `views/` - admin, pharmacy, auth, layout templates.
- `routes.php` - HTTP route map.
- `public/` - front controller and static assets.
- `tests/` - PHPUnit unit and integration tests.
- `database/migrations/` - schema migration notes.
- `pharmacy.sql` - current database dump.

## Local Commands

```bash
composer install
find app routes.php public views tests -name '*.php' -print0 | xargs -0 -n1 php -l
vendor/bin/phpunit --configuration phpunit.xml
```

Docker test command used during stabilization:

```bash
docker run --rm -v "$PWD:/var/www/html" -w /var/www/html medvault-app:latest php vendor/bin/phpunit --configuration phpunit.xml --fail-on-all-issues
```

## Current Stabilization Coverage

- Pharmacy verification schema and flow.
- Tenant-scoped pharmacy data access.
- Server-side order/sale totals and stock updates.
- Transaction-wrapped inventory writes.
- CSRF protection for POST routes.
- Upload validation for verification documents.
- Analytics API tests and export tests.

## Manual Smoke Checklist

- Login as pharmacy and admin.
- Register pharmacy account.
- Request pharmacy verification with PDF/JPG/PNG document.
- Approve/reject pharmacy as admin.
- Create/edit/delete category and medicine.
- Create/update/delete order and sale.
- Open sales/order analytics.
- Export admin order CSV.
