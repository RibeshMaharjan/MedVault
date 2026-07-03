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

## UI design system

The UI was redesigned to match the `medvault/` lovable.dev mockup pixel-for-pixel. No
Bootstrap, jQuery, or Font Awesome — a hand-written CSS design system instead:

- `public/assets/css/tokens.css` - color/radius/shadow/font design tokens (OKLCH, copied
  verbatim from the mockup's `medvault/src/styles.css`).
- `public/assets/css/components.css` - component classes (buttons, cards, tables, badges,
  dialogs, sidebar/shell, combobox, file upload, etc).
- `public/assets/js/ui.js` - vanilla-JS behaviors: native `<dialog>` open/close, dropdowns,
  tabs, sidebar collapse, toasts, searchable combobox, table sort, confirm dialogs.
- `public/assets/js/chart-theme.js` - Chart.js config factory styled to match the mockup's
  recharts look (dashed grid, teal/green/amber/blue/red series).
- `app/Helpers/icons.php` - inline lucide SVG icon helper (`lucide($name, $class)`).
- `views/layouts/app.php` - single shell layout for both pharmacy and admin roles
  (nav/product copy branches on session role).

See `UI_REDESIGN_PLAN.md` for the full phase-by-phase history of this redesign.

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

If host PHP lacks PDO SQLite/MySQL drivers, run the Docker command above.

## Current Stabilization Coverage

- Pharmacy verification schema and flow.
- Tenant-scoped pharmacy data access.
- Server-side order/sale totals and stock updates.
- Transaction-wrapped inventory writes.
- Transaction-wrapped registration and profile sync writes.
- CSRF protection for POST routes.
- Upload validation for verification documents.
- Analytics API tests and export tests.
- Admin pharmacy delete guard for pharmacies with business records.

## Manual Smoke Checklist

- Login as pharmacy and admin.
- Register pharmacy account.
- Request pharmacy verification with PDF/JPG/PNG document.
- Approve/reject pharmacy as admin.
- Create/edit/delete category and medicine.
- Create/update/delete order and sale.
- Open sales/order analytics.
- Export admin order CSV.
