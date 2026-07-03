# UI Redesign Plan & Progress — MedVault PHP app → lovable design

Source plan: `~/.claude/plans/remember-we-ask-lovable-memoized-simon.md` (approved). This file tracks execution progress phase by phase.

## Context

Replicate the lovable.dev-generated design (`medvault/`, TanStack Start + React + Tailwind v4 + shadcn/ui) pixel-perfect into the existing PHP MVC app (`views/`, currently Bootstrap 5 + jQuery).

**Locked decisions:**
1. Drop Bootstrap. Hand-written custom CSS design system (CSS variables + component classes). No build step.
2. Match lovable structure fully: create/edit forms → dialogs, `/register` own page, one unified app-shell for admin+pharmacy, collapsible sidebar, header with search/bell/settings.

## Guiding principles

- Pixel source of truth: `medvault/src/styles.css`, `medvault/src/components/ui/*.tsx`, `medvault/src/components/shared/*.tsx`, `medvault/src/components/layouts/AppShell.tsx`, `medvault/src/routes/*.tsx`.
- Colors copied verbatim as OKLCH. Hex for Chart.js: primary `#00848b`, success `#269e5f`, warning `#e1a035`, destructive `#d73337`, info `#338fc7`, border `#dae3e8`, muted-fg `#546673`. Radius base 10px (sm6/md8/lg10/xl14/2xl18). System sans font (no Poppins).
- Tailwind unit = 4px. `shadow-sm`=`0 1px 2px 0 rgb(0 0 0/.05)`; `shadow`=`0 1px 3px 0 rgb(0 0 0/.1),0 1px 2px -1px rgb(0 0 0/.1)`.
- Server-rendered PHP stays: POST+redirect+flash. Dialogs = pre-rendered hidden `<dialog>` opened by vanilla JS.
- Icons: inline lucide SVGs via `lucide($name,$class)` helper. Font Awesome removed.
- jQuery kept through Phase 7, dropped Phase 8. Bootstrap removed Phase 2 (temp `legacy-bridge` CSS bridges unconverted pages, deleted Phase 8).
- `GET .../create` routes → redirect to index `?open=create`; create views deleted.

## Progress tracker

- [x] **Phase 1** — Design-system foundation
  - [x] 1a. `public/assets/css/tokens.css`
  - [x] 1b. `public/assets/css/components.css`
  - [x] 1c. `public/assets/js/ui.js`
  - [x] 1d. `app/Helpers/icons.php` (lucide helper, wired into composer.json autoload files)
  - [x] Verify: CSS brace-balance sanity check passed; full visual diff deferred to Phase 2 when app runs in docker
- [x] **Phase 2** — Unified app shell + PHP component helpers
  - [x] `views/layouts/app.php`
  - [x] `views/partials/sidebar.php` + `views/partials/header.php`
  - [x] `pageHeader()/statCard()/statusBadge()` helpers (in `functions.php`)
  - [x] Rewrite `alertMessage()` + add `generateTableFooter()` pagination helper
  - [x] Switch layout name at all 20 controller call sites (`'admin'`/`'pharmacy'` → `'app'`)
  - [x] Folded `app.js` sidebar toggle into `ui.js` (old file deletion deferred to Phase 8)
  - [x] `legacy-bridge` CSS section + temporary `bootstrap.bundle.min.js` (JS-only, for unconverted modals)
  - [x] Verify: booted app in throwaway docker stack (project `ui-redesign`, ports 8010/8090), logged in as both pharmacy and admin test users — shell renders correctly, nav/active-state/toast/avatar all correct, zero Bootstrap CSS/FontAwesome/GoogleFonts requests, unconverted pages (medicines/orders/profile) still 200 via legacy bridge
- [x] **Phase 3** — Standalone pages: landing, /login, /register, errors
  - [x] `GET /register` route + `AuthController::showRegister()`; register() error redirects now target `/register` with `'error'` flash type; `Session::flash()`/`Controller::redirect()` extended with a `$type` param
  - [x] `views/auth/login.php` rewrite (AuthShell two-column, gradient testimonial panel)
  - [x] `views/auth/register.php` new
  - [x] `views/landing.php` rewrite (nav, radial-gradient hero, 3 feature cards, gradient CTA band, footer)
  - [x] `views/errors/{403,404,500}.php` rewrite (centered lovable-style error pages)
  - [x] Verify: all routes 200/404 as expected; register validation error redirects to `/register` with error toast; full register→login round trip shows success toast
- [x] **Phase 4** — Pharmacy core: dashboard, medicines, categories
  - [x] `views/pharmacy/dashboard.php` (4 StatCards + Chart.js 7-day revenue bar chart styled via new `chart-theme.js` + recent activity list); extended `DashboardController`/`UserMedicine::getRecentActivities` for pendingOrders/revenue30d/amount data
  - [x] `views/pharmacy/medicines/index.php` (toolbar, DataTable, create/edit dialogs, stock<20 warning, expiry<90d destructive)
  - [x] `views/pharmacy/categories/index.php` (DataTable w/ medicine counts, create/rename dialogs, delete guarded when count>0)
  - [x] Deleted `medicines/create.php`; `create()` actions now redirect to `?open=create`; added `circle-dollar-sign` icon
  - [x] Verify: booted in ui-redesign docker stack — dashboard/medicines/categories all 200 with real seeded data, no PHP warnings; full create-medicine flow tested end-to-end (invalid category correctly redirects to `?open=create` with error toast, valid submission succeeds, new row appears with correct edit data-fields JSON and delete confirm)
- [x] **Phase 5** — Transactions: orders + sales
  - [x] `views/pharmacy/{orders,sales}/index.php` rewritten (toolbar, DataTable, pagination footer, edit/delete dialogs)
  - [x] Create dialog w/ SearchableCombobox + `transactions.js` (price/qty/date panel, live total, stock/date validation, submit disabled until valid)
  - [x] **Scope note**: backend `store()` for orders/sales only ever accepted one medicine per POST (price/qty single fields, no array) — implemented combobox-driven single-item add matching the real backend contract rather than inventing a fictitious multi-line batch-insert cart the backend doesn't support
  - [x] Rewrote `AjaxController::searchMedicine()` to return JSON (was an HTML fragment for old jQuery `.html()` injection) — consumed by `ui.js` combobox `data-src` fetch
  - [x] Deleted `orders/create.php`, `sales/create.php`; `create()` actions redirect to `?open=create`; all error-path redirects now use `'error'` flash type
  - [x] Verify: search-medicine JSON endpoint returns correct shape against real seeded medicines; full order-create POST round trip succeeds with correct toast, row appears with correct status badge/currency formatting/pagination
- [x] **Phase 6** — Analytics + profile
  - [x] `chart-theme.js` built in Phase 4, reused here for line/doughnut configs
  - [x] `views/pharmacy/analytics/sales.php` rewrite — dropped the old 622-line moving-average/anomaly-detection/stock-recommendation dashboard (not part of lovable's design) in favor of lovable's exact 3-card layout: 14-day revenue LineChart + top-selling ranked list + inventory-levels BarChart. Added `Sale::getTopSelling()`, `UserMedicine::getStockLevels()`, and 2 new AJAX endpoints (`/api/pharmacy/top-selling`, `/api/pharmacy/stock-levels`, `/api/pharmacy/revenue-trend`)
  - [x] `views/pharmacy/analytics/orders.php` rewrite — status-distribution doughnut + recent-orders list, reusing existing `/api/pharmacy/order-data`
  - [x] `views/pharmacy/profile.php` rewrite (2-col business info form + verification card w/ StatusBadge + FileUpload dropzone); added file-upload drag/drop + chip JS to `ui.js` (missed in Phase 1)
  - [x] Verify: both analytics pages 200 with correct JSON from new/existing endpoints; profile page 200, update round-trip succeeds with correct toast
- [x] **Phase 7** — Admin
  - [x] `views/admin/dashboard.php` (4 StatCards + recent-pharmacies/verification-queue list cards); extended `DashboardController` w/ verified/pending counts + 2 recent-list queries
  - [x] `views/admin/pharmacies/index.php` + create dialog (deleted `create.php`, `create()` → redirect `?open=create`)
  - [x] `views/admin/pharmacies/verify.php` — Tabs (Pending/Verified) wrapped in shared `[data-tabs]` container (fixed ui.js Tabs contract requiring panels + triggers share a common ancestor), review cards, shared Approve/Reject dialogs using `data-form-action` per-card
  - [x] `views/admin/admins/index.php` + create dialog (deleted `create.php`, redirect pattern)
  - [x] `views/admin/settings.php` (Hero + Contact cards)
  - [x] All error-path redirects across Admin controllers now use `'error'` flash type
  - [x] Verify: full admin walkthrough — all 5 pages 200 with zero PHP warnings, dashboard stat cards show real counts, verify-page tabs render correct pending/verified counts
- [x] **Phase 8** — Cleanup, de-jQuery, final pixel audit
  - [x] Dropped jQuery CDN + Bootstrap JS bundle + `$.ajaxPrefilter` shim from `views/layouts/app.php` (no view uses jQuery anymore — confirmed via `grep -rl '\$(' views/` returning nothing); kept the `window.csrfToken` assignment (used by `ui.js`/combobox fetch calls)
  - [x] Deleted dead layouts (`views/layouts/{admin,pharmacy}.php`), dead sidebar partials (`views/partials/{admin,pharmacy}-sidebar.php`), legacy CSS (16 files + `inventory/`, `login/` dirs), legacy JS (`dropmenu.js`, `pop.js`, `subtotal.js`, `toast.js`, `app.js`) — confirmed zero references before each deletion
  - [x] Removed the `LEGACY BRIDGE` CSS section from `components.css` (confirmed no converted view relies on raw Bootstrap classes)
  - [x] No broken `/assets/images/` or `proj-front/` references found (already avoided in Phase 3 rewrites); added `public/favicon.ico` (copied from `medvault/public/favicon.ico`) and linked it from all standalone pages + the app layout
  - [x] Updated `README.md` with a "UI design system" section; replaced stale `README-Toast-Refactoring.md` content with a pointer to the current implementation
  - [x] Pixel/functional audit: full lint sweep (zero errors) + live smoke test of all 17 routes (public/pharmacy/admin) after container restart — all 200/404 as expected
  - [x] **`phpunit` could not run**: the docker image's PHP has no `zip` extension and no `unzip`/`7z`, so `composer install --dev` (needed for `phpunit/phpunit`) fails downloading deps. This is a pre-existing environment gap, not something introduced by the redesign — out of scope to fix (would mean editing the Dockerfile, which wasn't part of this task). Confirmed no test files reference any of the deleted `create.php` views/routes, so no test breakage is expected. Manual smoke testing (this phase + every prior phase) substituted for automated test runs.

## Critical files

- `medvault/src/styles.css` — token source of truth
- `medvault/src/components/layouts/AppShell.tsx` — shell/PageHeader spec
- `medvault/src/components/shared/{StatCard,StatusBadge,DataTable,TransactionsPage,SearchableCombobox,FileUpload}.tsx`
- `views/layouts/{pharmacy,admin}.php` → replaced by `views/layouts/app.php`
- `app/Helpers/functions.php` — alertMessage/pagination rewrites + new helpers
- `routes.php` — `/register`, create-route redirects
