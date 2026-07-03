# Implementation Plan: Expired Medicine Monitoring

**Status**: Complete
**Started**: 2026-07-03
**Last Updated**: 2026-07-03
**Estimated Completion**: 2026-07-03

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
Add real monitoring for expired and soon-expiring medicines. Current system blocks expired stock from sale/order, but dashboard/list visibility is weak and list warning logic uses absolute date differences.

### Success Criteria
- [x] Dashboard shows expired and expiring-soon medicine counts.
- [x] Dashboard shows actionable expiry alerts scoped to current pharmacy.
- [x] Medicine table shows clear `Expired`, `Expires soon`, and `Valid` badges.
- [x] Medicine table supports quick expiry status filters.
- [x] Expiry calculations use signed date semantics and do not hide medicines expired more than 30 days ago.
- [x] Tests cover model expiry summary and alert logic.

### User Impact
Pharmacy users can find unsafe expired stock before sales/orders fail and can act before stock expires.

---

## Architecture Decisions

| Decision | Rationale | Trade-offs |
|----------|-----------|------------|
| Keep expiry logic in `UserMedicine` | Dashboard and medicine list need same business rules | Adds model methods |
| Use ISO date string comparisons in SQL | Works for MySQL and SQLite with `YYYY-MM-DD` dates | Requires normalized stored dates |
| Treat today as not expired | Existing `isExpired()` only rejects dates before today | Same-day expiry appears as expiring soon |
| Use `expiry_status` GET filter | Simple, bookmarkable, works with existing pagination | Controller owns quick-filter mapping |

---

## Test Strategy

### Validation Commands
```bash
find app views tests -name '*.php' -print0 | xargs -0 -n1 php -l
vendor/bin/phpunit --configuration phpunit.xml --filter MedicineTest
vendor/bin/phpunit --configuration phpunit.xml
```

---

## Implementation Phases

### Phase 1: Expiry Model Logic
**Goal**: `UserMedicine` exposes tested expiry counts and alerts.
**Estimated Time**: 1-2 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Add tests for expired count, expiring-soon count, same-day expiry, future-valid exclusion, and pharmacy scoping.
  - File: `tests/unit/Models/MedicineTest.php`
  - Expected: fails until `getExpirySummary()` and `getExpiryAlerts()` exist.

**GREEN: Implement to Make Tests Pass**
- [x] Add `getExpirySummary(int $pharmacyId, int $warningDays = 30, ?string $today = null): array`.
- [x] Add `getExpiryAlerts(int $pharmacyId, int $warningDays = 30, int $limit = 10, ?string $today = null): array`.

**REFACTOR: Clean Up**
- [x] Keep date normalization and days calculation small and local.

#### Quality Gate
- [x] Red tests attempted first; local PHP blocked by missing `pdo_sqlite`.
- [x] `vendor/bin/phpunit --configuration phpunit.xml --filter MedicineTest` passes in Docker.
- [x] PHP lint passes for touched PHP files.

#### Coverage Target
Model business logic tests cover all expiry buckets and tenant scope.

#### Rollback
Revert `UserMedicine` model changes and related tests.

---

### Phase 2: Dashboard Alerts
**Goal**: Pharmacy dashboard surfaces expired and soon-expiring inventory.
**Estimated Time**: 1 hour
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Extend model tests to prove alert records include status and days values consumed by dashboard.

**GREEN: Implement to Make Tests Pass**
- [x] Pass expiry summary/alerts from `DashboardController`.
- [x] Add dashboard count cards and expiry alert table.

**REFACTOR: Clean Up**
- [x] Keep view fallbacks safe when no alerts exist.

#### Quality Gate
- [x] Dashboard PHP lint passes.
- [x] Medicine model tests pass.
- [x] Full PHPUnit passes in Docker.

#### Rollback
Revert `DashboardController` and `views/pharmacy/dashboard.php`.

---

### Phase 3: Medicine List Filter And Badges
**Goal**: Medicine list correctly distinguishes expired, expiring soon, and valid stock.
**Estimated Time**: 1-2 hours
**Status**: Complete

#### Tasks

**RED: Write Failing Tests First**
- [x] Covered bucket semantics through model tests; controller maps those same date ranges.

**GREEN: Implement to Make Tests Pass**
- [x] Add `expiry_status` filter handling in `MedicineController`.
- [x] Add filter select in medicine table.
- [x] Replace absolute `%a` warning with signed date status.
- [x] Add badge in expiration date column and preserve pagination params.

**REFACTOR: Clean Up**
- [x] Avoid duplicate date-status calculations where possible without introducing large view helpers.

#### Quality Gate
- [x] PHP lint passes.
- [x] `MedicineTest` passes in Docker.
- [x] Full PHPUnit passes in Docker.

#### Rollback
Revert `MedicineController` and `views/pharmacy/medicines/index.php`.

---

## Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Existing expired rows exist despite create/update validation | Medium | High | Monitoring uses DB dates directly and does not rely on form validation |
| Date boundaries cause off-by-one status | Medium | Medium | Tests cover past, today, 30 days, and beyond 30 days |
| SQLite/MySQL date function differences | Medium | Medium | Use ISO date comparisons instead of DB-specific date math |

---

## Notes And Learnings

- Existing sale/order prevention remains unchanged.
- Existing `isExpired()` treats today as non-expired.
- Local host PHP lacks `pdo_sqlite`; Docker PHPUnit is passing.
