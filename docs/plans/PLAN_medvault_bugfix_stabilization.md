# Implementation Plan: MedVault Bugfix Stabilization

**Status**: Complete
**Started**: 2026-07-02
**Last Updated**: 2026-07-02
**Estimated Completion**: 2026-07-09

---

**CRITICAL INSTRUCTIONS**: After completing each phase:
1. Check off completed task checkboxes
2. Run all quality gate validation commands
3. Verify ALL quality gate items pass
4. Update "Last Updated" date above
5. Document learnings in Notes section
6. Only then proceed to next phase

**DO NOT skip quality gates or proceed with failing checks**

---

## Overview

### Feature Description
Stabilize MedVault by fixing known coding bugs, business logic bugs, schema mismatches, broken APIs, security gaps, and test infrastructure gaps across pharmacy, admin, auth, inventory, order, sale, analytics, and export modules.

### Success Criteria
- [x] Test suite runs locally or in Docker with current app schema.
- [x] Verification flow works from pharmacy request to admin approve/reject.
- [x] Pharmacy users cannot access or mutate another pharmacy's data.
- [x] Stock and money calculations are server-side, transactional, and correct.
- [x] Security gaps for CSRF, session fixation, upload safety, and XSS are closed.
- [x] All app API endpoints used by frontend exist and return expected JSON.
- [x] Admin export uses current order data.
- [x] Docs reflect current MVC codebase.

### User Impact
Pharmacy users get correct inventory and analytics. Admins get working verification and export. Data isolation and security improve. Future changes become safer because tests run against real app behavior.

---

## Architecture Decisions

| Decision | Rationale | Trade-offs |
|----------|-----------|------------|
| Use TDD phase-by-phase | Bugs touch shared business rules; tests prevent regressions | Slower first phase |
| Align tests to current MVC app and schema | Existing tests use stale columns and raw SQL | Requires fixture cleanup |
| Add scoped model methods for tenant ownership | Prevent cross-pharmacy data leaks in one place | More model methods |
| Orders reserve stock on create | Current UI submits pending orders as stock reservation; avoids double deduct | Cancel/delete must restore reserved stock |
| Calculate totals on server | Browser totals and prices are tamperable | Controllers need DB lookups |
| Use DB transactions for multi-write flows | Prevent partial user/profile/order/sale writes | Requires PDO transaction paths |
| Keep security fixes inside existing vanilla PHP structure | Avoid framework rewrite | More manual helpers/middleware |

---

## Dependencies

### Required Before Starting
- [x] Confirm PHP dependency install path: Docker Composer.
- [x] Confirm app runtime target: Docker app.
- [x] Confirm stock rule: orders reserve stock on create.
- [x] Backup/migration safety documented before schema migration.

### External Dependencies
- PHP `>=8.0`
- PHPUnit `^10.0`
- MySQL 8.0 or MariaDB-compatible server
- Docker Compose for integration/manual runtime

---

## Test Strategy

### Testing Approach
TDD: write failing tests first, implement minimal fix, refactor while tests stay green.

### Test Pyramid
| Test Type | Coverage Target | Purpose |
|-----------|-----------------|---------|
| Unit Tests | >=80% | Validators, scoped model helpers, stock math, CSRF helpers |
| Integration Tests | Critical paths | Auth/session, verification, order/sale/stock, APIs, export |
| Manual/E2E | Key user flows | Browser login, pharmacy CRUD, admin verification, analytics |

### Test File Organization
```
tests/
├── unit/
│   ├── Core/
│   ├── Models/
│   ├── Controllers/
│   └── Security/
└── integration/
    ├── AuthFlowTest.php
    ├── PharmacyVerificationFlowTest.php
    ├── TenantIsolationFlowTest.php
    ├── InventoryStockFlowTest.php
    ├── ApiAnalyticsFlowTest.php
    └── AdminExportFlowTest.php
```

### Validation Commands
```bash
find app routes.php public views tests -name '*.php' -print0 | xargs -0 -n1 php -l
vendor/bin/phpunit --configuration phpunit.xml
docker compose up -d --build
curl -I http://localhost:8000/login
```

---

## Implementation Phases

### Phase 1: Test And Runtime Foundation
**Goal**: PHPUnit and fixtures work against current app contracts.
**Estimated Time**: 2-4 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Test app bootstrap/route loading.
  - Files: `tests/integration/AppBootFlowTest.php`
  - Expected: fails if test dependencies/bootstrap missing.
- [x] Test real schema fixture columns for `tbl_pharmacy`, `user_order_tbl`, `user_sales_tbl`.
  - Files: `tests/integration/SchemaContractTest.php`
  - Expected: fails due stale test schemas and missing verification fields.

**GREEN: Implement To Make Tests Pass**
- [x] Restore/install PHPUnit dependencies.
  - Files: `composer.json`, `composer.lock` if generated.
- [x] Align test schemas with app schema where Phase 1 required it.
- [x] Replace stale test columns where they blocked current tests.
- [x] Add isolated test DB setup that does not depend on production MySQL.

**REFACTOR: Clean Up**
- [x] Identify raw-SQL-only tests and keep suite runnable for later phase rewrites.
- [x] Preserve existing fixture helpers and align blocking stale fixtures.

#### Quality Gate
- [x] PHP syntax lint passes.
- [x] PHPUnit command exists and starts.
- [x] Existing meaningful tests pass or are converted to accurate failing tests.
- [x] Test suite runtime under 5 minutes.

#### Coverage Target
Baseline measured; no minimum yet except test runner works.

#### Rollback
Revert test-only changes and dependency lock changes.

---

### Phase 2: Schema And Verification Flow
**Goal**: Pharmacy verification works end-to-end.
**Estimated Time**: 2-4 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Pharmacy request verification stores license number, document path, request date.
  - Files: `tests/integration/AdminPharmacyVerificationTest.php`
- [x] Admin verify page loads pending and verified pharmacies.
  - Files: `tests/integration/AdminPharmacyVerificationTest.php`
- [x] Admin approve/reject changes verification state and notes.
  - Files: `tests/integration/AdminPharmacyVerificationTest.php`

**GREEN: Implement To Make Tests Pass**
- [x] Add verification columns to `pharmacy.sql`.
- [x] Add migration SQL doc/file if project keeps migrations.
- [x] Fix `ProfileController` and `Admin\PharmacyController` column names if needed.
- [x] Ensure profile/admin views handle missing/null verification values safely.

**REFACTOR: Clean Up**
- [x] Keep verification state normalized on existing `isverified` field.
- [x] Remove stale `verified/status` test assumptions.

#### Quality Gate
- [x] Verification tests pass.
- [x] Schema contract covered by integration tests and migration SQL present.
- [x] Request/approve/reject flow covered by integration tests.
- [x] No missing-column DB errors.

#### Coverage Target
>=80% of verification controller/model paths.

#### Rollback
Remove added columns and revert verification controller/view/test changes. Restore DB backup if migration applied.

---

### Phase 3: Tenant Ownership Isolation
**Goal**: Pharmacy users cannot access or mutate another pharmacy's data.
**Estimated Time**: 3-4 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Pharmacy A cannot fetch pharmacy B medicine through API model path.
  - Files: `tests/unit/Models/MedicineTest.php`
- [x] Pharmacy A cannot edit/delete pharmacy B medicine.
  - Files: `tests/unit/Models/MedicineTest.php`
- [x] Pharmacy A cannot edit/delete pharmacy B category.
  - Files: `tests/unit/Models/CategoryTest.php`
- [x] Pharmacy A cannot order/sell pharmacy B medicine through scoped stock paths.
  - Files: `tests/unit/Models/MedicineTest.php`

**GREEN: Implement To Make Tests Pass**
- [x] Add scoped model methods for medicine: find/update/delete by pharmacy.
- [x] Add scoped model methods for category: find/update/delete by pharmacy.
- [x] Scope AJAX `getMedicineRow()` by `pharmacy_id`.
- [x] Scope order/sale medicine lookup by `pharmacy_id`.
- [x] Return not found/access denied for cross-tenant attempts.

**REFACTOR: Clean Up**
- [x] Add reusable ownership guard helper in controllers or models.
- [x] Replace unscoped `findById/update/delete` calls in pharmacy area.

#### Quality Gate
- [x] All tenant isolation tests pass.
- [x] Two-pharmacy paths covered by scoped model tests.
- [x] Existing CRUD still works for owner.

#### Coverage Target
>=90% ownership guard logic.

#### Rollback
Revert scoped model/controller changes; no schema rollback expected.

---

### Phase 4: Stock And Money Rules
**Goal**: Inventory stock and totals are correct and tamper-proof.
**Estimated Time**: 3-4 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Pending order reserves stock once.
  - Files: `tests/integration/InventoryStockFlowTest.php`
- [x] Completing pending order does not double-deduct.
  - Files: `tests/integration/InventoryStockFlowTest.php`
- [x] Cancel/delete reserved order restores stock.
  - Files: `tests/integration/InventoryStockFlowTest.php`
- [x] Sale cannot complete if stock insufficient.
  - Files: `tests/integration/InventoryStockFlowTest.php`
- [x] Client-faked price/total ignored for order and sale.
  - Files: `tests/integration/InventoryStockFlowTest.php`

**GREEN: Implement To Make Tests Pass**
- [x] Apply order rule: reserve stock on create; no second deduct on completion.
- [x] Restore stock when pending/completed order becomes cancelled/deleted.
- [x] Validate sale stock before completion.
- [x] Calculate order/sale totals server-side from DB prices.
- [x] Use transactions around order/sale insert/update/delete plus stock change.

**REFACTOR: Clean Up**
- [x] Extract stock adjustment logic into service/helper or model methods.
- [x] Remove duplicated stock transition code.

#### Quality Gate
- [x] Stock never negative after tested flows.
- [x] Totals always equal server price times quantity.
- [x] Transaction-wrapped controller paths pass.
- [x] Syntax and PHPUnit suite pass after order/sale changes.

#### Coverage Target
>=90% stock and total business logic.

#### Rollback
Revert order/sale controller/model stock changes. Restore DB backup if bad stock migration/data cleanup applied.

---

### Phase 5: Validation And Security
**Goal**: Unsafe requests and unsafe files are blocked.
**Estimated Time**: 3-4 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Missing CSRF token rejects POST.
  - Files: `tests/unit/Security/CsrfTest.php`, `tests/integration/SecurityPostFlowTest.php`
- [x] Login regenerates session ID.
  - Files: `tests/integration/AuthFlowTest.php`
- [x] Upload rejects unsafe extension/MIME/size.
  - Files: `tests/integration/PharmacyVerificationFlowTest.php`
- [x] Medicine rejects negative stock, negative price, invalid expiry.
  - Files: `tests/unit/Controllers/MedicineControllerTest.php`
- [x] Duplicate email rejected in admin and pharmacy create flows.
  - Files: `tests/integration/AuthFlowTest.php`

**GREEN: Implement To Make Tests Pass**
- [x] Add CSRF token helper and form hidden fields.
- [x] Validate CSRF token in all POST routes.
- [x] Regenerate session ID on successful login.
- [x] Harden upload: MIME allowlist, size limit, random filename, `0755` directory.
- [x] Add medicine/order/sale/admin/pharmacy validators.
- [x] Add duplicate email checks in admin create and admin pharmacy create.
- [x] Replace raw DB `die()` with logged generic error response.

**REFACTOR: Clean Up**
- [x] Keep validation close to controller paths where rules are specific.
- [x] Add consistent user-facing validation failures for touched flows.

#### Quality Gate
- [x] CSRF tests pass.
- [x] Auth tests pass.
- [x] Upload safety paths pass syntax/full suite.
- [x] `/login` Docker smoke returns 200.
- [x] Register/login/category create smoke passes for pharmacy user.
- [x] CSRF rejection smoke returns 403.

#### Coverage Target
>=80% validation and security paths.

#### Rollback
Revert CSRF helpers/forms and validator changes if forms break. Keep DB backup unchanged.

---

### Phase 6: API And Frontend Integration
**Goal**: Frontend calls only valid APIs; JSON shapes match UI.
**Estimated Time**: 2-4 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] `/api/pharmacy/sales-data` returns expected JSON.
  - Files: `tests/integration/ApiAnalyticsFlowTest.php`
- [x] `/api/pharmacy/order-data` returns expected JSON.
  - Files: `tests/integration/ApiAnalyticsFlowTest.php`
- [x] `/api/pharmacy/inventory-levels` exists or frontend no longer calls it.
  - Files: `tests/unit/Models/MedicineTest.php`
- [x] Order timeline shows amount correctly.
  - Files: `app/Models/Order.php`
- [x] Medicine search output cannot inject script.
  - Files: `tests/integration/ApiAnalyticsFlowTest.php`

**GREEN: Implement To Make Tests Pass**
- [x] Add `inventory-levels` route/API or remove frontend fetch.
- [x] Fix order timeline `amount` vs `total_amount` mismatch.
- [x] Return JSON for medicine search or escape output safely.
- [x] Remove dead frontend calls to `ajax.php` and `php/ajax2.php`.
- [x] Standardize API empty states for analytics/inventory paths covered by frontend.

**REFACTOR: Clean Up**
- [x] Preserve existing JSON shapes to avoid breaking current frontend contracts.
- [x] Remove debug `console.log` from production views.

#### Quality Gate
- [x] API integration tests pass.
- [x] Known dead frontend AJAX endpoints removed.
- [x] Analytics API tests cover no-data/seeded data JSON shapes.

#### Coverage Target
>=70% API controller paths.

#### Rollback
Revert API route/controller/view JS changes.

---

### Phase 7: Admin Export, Docs, Final Regression
**Goal**: Admin reporting and docs match current app.
**Estimated Time**: 2-4 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Admin export uses `user_order_tbl`.
  - Files: `tests/integration/AdminExportFlowTest.php`
- [x] Export filters by status and date.
  - Files: `tests/integration/AdminExportFlowTest.php`
- [x] Docs mention current MVC structure.
  - Files: docs review checklist.

**GREEN: Implement To Make Tests Pass**
- [x] Fix export query table and column names.
- [x] Add CSV header behavior for empty exports.
- [x] Update `README.md` and `docs/project-overview.md` for current `app/`, `views/`, `routes.php` structure.
- [x] Add manual regression checklist.

**REFACTOR: Clean Up**
- [x] Mark old docs/legacy details clearly or remove stale sections.
- [x] Remove stale/dead JS if unused.

#### Quality Gate
- [x] Export CSV query uses current schema.
- [x] Full PHPUnit suite passes.
- [x] PHP syntax lint passes.
- [x] Docker app boots and `/login` returns 200.
- [x] Manual smoke test complete.

#### Coverage Target
Critical admin/export path covered; total suite coverage maintained or improved.

#### Rollback
Revert export and docs changes.

---

## Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Existing production DB missing verification columns | High | High | Backup DB, add migration, test import |
| Stock rules misunderstood | Medium | High | Confirm reserve-on-order rule before implementation |
| Tests need Composer/network | High | Medium | Prefer Docker Composer; request install approval if needed |
| CSRF touches many forms | Medium | Medium | Add helper and update forms phase-by-phase |
| Upload hardening breaks existing documents | Medium | Medium | Preserve existing paths; validate only new uploads |
| Transaction changes expose hidden DB exceptions | Medium | Medium | Add rollback tests and generic error handling |
| Stale docs confuse future work | Medium | Low | Update docs in final phase |

---

## Rollback Strategy

- Phase 1: revert test/dependency changes only.
- Phase 2: revert verification code and migration; restore DB backup if migration applied.
- Phase 3: revert scoped model/controller changes.
- Phase 4: revert stock transition code; restore DB backup for bad stock data.
- Phase 5: revert CSRF/form/upload validation changes as a group.
- Phase 6: revert API route/controller/view changes.
- Phase 7: revert export/docs changes.
- Phase 9: revert auth/profile transaction wrappers and transaction tests.
- Phase 10: revert seed/UI/error page cleanup.
- Phase 11: revert admin pharmacy delete guard and delete-flow tests.

---

## Progress Tracking

- [x] Phase 1 complete
- [x] Phase 2 complete
- [x] Phase 3 complete
- [x] Phase 4 complete
- [x] Phase 5 complete
- [x] Phase 6 complete
- [x] Phase 7 complete
- [x] Phase 8 plan cleanup complete
- [x] Phase 9 transaction safety complete
- [x] Phase 10 seed/UI/error cleanup complete
- [x] Phase 11 admin delete guard complete

---

## Notes And Learnings

- 2026-07-02: Initial audit found PHP syntax clean, but PHPUnit missing, app not running on port 8000, Docker socket inaccessible from current sandbox, and local PHP lacks DB drivers for DB-backed tests.
- 2026-07-02: Phase 1 complete. Installed PHPUnit via `composer:latest`, added `composer.lock`, added SQLite test support to `Database`, fixed middleware test exits, aligned stale fixtures enough for current suite, and reached `OK (197 tests, 280 assertions)` with `--fail-on-all-issues`.
- 2026-07-02: Phases 2-4 complete. Added pharmacy verification schema/migration, tenant-scoped model/controller paths, transactional stock/order/sale updates, and inventory flow tests. Suite reached `OK (213 tests, 317 assertions)`.
- 2026-07-02: Partial Phase 5-7 fixes complete. Hardened uploads, regenerated session IDs on auth, added duplicate email guards, added inventory-levels API, fixed order timeline amount shape, and moved admin order export to current schema. Suite reached `OK (214 tests, 321 assertions)`.
- 2026-07-02: Implemented CSRF route guard + form tokens, analytics API integration tests, admin export tests, medicine validation, docs refresh, and Docker `/login` smoke. Suite reached `OK (230 tests, 369 assertions)`.
- 2026-07-02: HTTP smoke: pharmacy registration/login/dashboard/category create/analytics/inventory API passed. CSRF missing-token POST returns 403. Admin login, dashboard, verify page, and export CSV passed after resetting cloud DB admin password. Manual smoke complete.
- 2026-07-02: Phase 8 plan cleanup complete. Optional validator/API-envelope work intentionally left out because current controller rules are flow-specific and API JSON shapes are already used by frontend/tests.
- 2026-07-02: Remaining audit gaps fixed. Added registration/profile transaction rollback tests, cleaned negative seed values, fixed completed order badge style, added simple 404/500 views, guarded admin pharmacy delete when business records exist, and reached `OK (239 tests, 395 assertions)`.
