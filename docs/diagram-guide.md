# PlantUML Diagram Style Guide

Based on refactoring sessions for the MedVault project. Follow these rules to create clean, A4-portrait-ready diagrams for any project without re-examining every detail.

---

## General Principles

| Rule | Why |
|------|-----|
| **A4 portrait layout** — minimize width, maximize height | Fits printed output without horizontal scroll |
| **No code snippets** in diagram labels | Diagrams describe behavior, not implementation |
| **Short labels** — 1-3 words per action/state/transition | Keeps boxes small, diagram narrow |
| **Remove duplicate/less-important features** | If two entities share identical CRUD, keep only the core one |
| **Consistent palette** | Background `#F0F8FF`, border/arrow `#2C3E50` |
| **No `\n` in labels** | Everything must fit on one line |

---

## 1. Class Diagram (Entity Style)

**What to show:**
- DB columns per entity (SQL types: `int`, `varchar`, `tinyint`, `datetime`, `text`)
- FK navigation methods only — no inherited `Model` methods

**What NOT to show:**
- Abstract base Model class
- CRUD methods inherited from a base class
- Controller or Middleware classes *(keep those for refinement)*

**Naming:**
```
class Pharmacy {
    +pharmacy_id: int PK
    +pharmacy_name: varchar(100)
    +isverified: tinyint
    +user()
    +medicines()
    +orders()
    +createMinimal(pharmacyId, name, email)
}
```

---

## 2. Object Diagram

- Use `object` keyword with `<<Stereotype>>` (table name in parentheses)
- Show actual FK values so object arrows match real data
- Use `top to bottom direction`

```
object "role_89: User" as role {
    user_id = 89
    name = "Pharmacy"
    email = "pharmacy@gmail.com"
    role = "user"
}
```

---

## 3. Combined State Diagram

Build a **single navigable state machine** covering the full app flow:

### Structure
```
[*] --> Unauthenticated
Unauthenticated --> Authenticated : Login
Authenticated --> Unauthenticated : Logout

state Authenticated {
    [*] --> RoleCheck
    RoleCheck --> PharmDashboard : role=user
    RoleCheck --> AdminDashboard : role=admin

    state "Dashboard" as PharmDashboard

    state "Feature" as FeatureMgmt {
        [*] --> List
        List --> Create : Add
        Create --> List : Save
        List --> Edit : Modify
        Edit --> List : Update
        List --> [*] : Delete
    }

    state "Feature" as FeatureMgmt {
        [*] --> List
        ...
        state "Lifecycle" as Lifecycle {
            [*] --> Pending
            Pending --> Completed : Confirm
            Completed --> Pending : Revert
            Pending --> [*] : Delete
            Completed --> [*] : Delete
        }
    }

    ' Navigation
    PharmDashboard --> FeatureMgmt : FeatureName
    FeatureMgmt --> PharmDashboard : Return
}
```

### Rules
- **Auth wrapper** → RoleCheck → Dashboard → Feature → Return pattern
- **`linetype ortho`** inside `skinparam state {}` — eliminates overlapping curved arrows
- **Short transition labels**: `Confirm` not `Confirm / updateStock(-qty)`
- **Short composite titles**: `"Orders"` not `"Order Management"`
- **Remove duplicate lifecycles**: if Orders and Sales have identical lifecycle, keep only Orders
- **Drop decorative inner states** from dashboards (`Stats → Alerts → Activity` chain)
- **Drop less-important features** that are identical CRUD to core features

---

## 4. Sequence Diagram

### Participants
```
actor User
participant "Router" as R
participant "Controller" as C
participant "Model" as M
participant "Database" as DB
```

### Structure
```
group FlowName
    User -> R: Action
    R -> C: Mount Controller
    activate C
    C -> C: Validate Input
    C -> M: Find Resource
    activate M
    M -> DB: Fetch Data
    DB --> M: Result
    M --> C: Info
    deactivate M
    alt Failure
        C --> User: Redirect with Error
    else Success
        C -> M: Store Record
        activate M
        M -> DB: Save
        DB --> M: Confirmation
        deactivate M
        C --> User: Redirect to Success
    end
    deactivate C
end
```

### Rules
- **`group` blocks only** — no `===` separators between flows
- **Single `actor User`** — not separate actors per flow
- **Abstract messages only** — never SQL, never `SELECT`/`INSERT`/`UPDATE`
- **Activate/deactivate** on all processing participants
- **`alt/else` for branching**
- **No `autonumber`**
- **No `\n` in labels** — everything on one line

---

## 5. Activity Diagram

### Swimlane colors
```
|#LightCyan|Auth|
|#White|Controller|
|#AntiqueWhite|Model|
|#LightCyan|User|
```

### Style
- **Plain English actions only**: `Check authentication;`, `Find order by ID;`, `Deduct stock;`, `Show error;`
- **No method calls**: no `::`, `no ->`, no parentheses, no parameters
- **No `Flash "..."`**: use `Show error;`, `Show success;`, `Show warning;`
- **Keep legend** showing color-to-role mapping
- **Widen narrow swimlanes** by using natural phrases: `Find order;` → `Find order by ID;`

```
|#LightCyan|Auth|
start
:Check authentication;
if (Authenticated?) then (no)
  :Redirect to login;
  stop
else (yes)
endif

|#White|Controller|
:Find order by ID;
if (Order exists?) then (no)
  :Show error;
  stop
else (yes)
endif

if (Already completed?) then (yes)
  :Show warning;
  stop
else (no)
endif

|#AntiqueWhite|Model|
:Check stock;
if (Stock sufficient?) then (no)
  :Show stock error;
  stop
else (yes)
  :Deduct stock;
endif

|#White|Controller|
:Mark as completed;

|#LightCyan|User|
:Show success;

stop
```

---

## 6. Refinement of Class

**Keep only entities** with full columns + business methods + FK nav methods.

**Remove:**
- Controller classes (all of them)
- Middleware classes
- Dependency arrows referencing removed components

**Layout:**
```
top to bottom direction
```
Entities stack vertically — no `left to right`.

**Keep:**
- Entity relationship arrows (`User "1" --> "0..1" Pharmacy : owns`)

---

## 7. Component Diagram

### Package structure
```
package "Presentation" {
    [Views]
    [Assets]
}

package "Application" {
    [App]
    [Router]
    [Middleware]
    [Controllers]
}

package "Domain" {
    [Entity1]
    [Entity2]
    ...
}

package "Infrastructure" {
    [Database]
    [Session]
    database "MySQL"
}
```

### Rules
- **No file paths** in component names — `[Router]` not `[Router: route matching\n+ middleware chain]`
- **No descriptions or metadata** in brackets
- **No `left to right direction`** — let it stack vertically
- **Clean relationships**: `App --> Router --> Controllers --> Domain --> Database`

---

## 8. Deployment Diagram

### Rules
- **Keep all structural elements** (Apache, PHP, Code, MySQL, phpMyAdmin, Volume)
- **Shorten labels to 1-2 words**
- **No verbose descriptions** inside boxes

```
node "Docker Host" {
    node "App (php:8.2-apache)" as AppContainer {
        artifact "Apache" as Apache
        artifact "PHP 8.2" as PHP
        artifact "Source Code" as Code
    }
    node "DB (mysql:8.0)" as DBContainer {
        database "MySQL" as MySQL
    }
    node "phpMyAdmin" as PMAContainer {
        artifact "phpMyAdmin" as PMA
    }
    folder "mysql_data" as Volume
}

Client --> Apache : :8000
Apache --> PHP
PHP --> Code
PHP --> MySQL : PDO :3306
PMA --> MySQL
MySQL --> Volume
```

---

## Checklist Before Finalizing

- [ ] All labels are 1-3 words — no long sentences
- [ ] No code/method-call syntax anywhere
- [ ] No SQL queries (`SELECT`, `INSERT`, `UPDATE`)
- [ ] No `\n` in labels
- [ ] `linetype ortho` set for state diagram
- [ ] `top to bottom direction` for class diagrams
- [ ] No `===` separators in sequence diagram — use `group` blocks
- [ ] Single `actor User` in sequence diagram
- [ ] `activate`/`deactivate` on all processing participants
- [ ] Swimlane legend present in activity diagram
- [ ] Duplicate/identical features removed from state diagram
- [ ] Controllers/Middleware removed from refinement of class
- [ ] Component names have no file paths or descriptions
- [ ] Deployment labels are 1-2 words per box
- [ ] Consistent color palette (`#F0F8FF` / `#2C3E50`)

## Quick Reference: Bad vs Good Labels

| Bad (code-like) | Good (plain English) |
|---|---|
| `PharmacyMiddleware::handle()` | `Check authentication` |
| `Order::findByIdAndPharmacy(orderId, pharmacyId)` | `Find order by ID` |
| `UserMedicine::updateStock(m_id, -quantity)` | `Deduct stock` |
| `Flash "Order not found"` | `Show error` |
| `SELECT * FROM user WHERE email = ?` | `Fetch User` |
| `INSERT INTO orders VALUES (...)` | `Store Record` |
| `Confirm / updateStock(-qty)` | `Confirm` |
| `admin (dashboard, pharmacies, settings)` | `Dashboard` |
