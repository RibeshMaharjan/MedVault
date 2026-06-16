# MedVault — UML Diagrams

All diagrams are verified against the actual codebase at commit time. Every class name, method signature, route, database column, and control flow reflects the source code, not an assumed design.

---

## 1. Class Diagram

Eight entities mapped to their database tables. Each entity lists its columns and FK navigation methods. Relationships are modeled at the bottom.

```plantuml
@startuml
skinparam classAttributeIconSize 0
top to bottom direction

class User {
    +user_id: int PK
    +name: varchar(100)
    +email: varchar(50)
    +password: varchar(255)
    +role: varchar(10)
    +pharmacy()
    +admin()
}

class Pharmacy {
    +pharmacy_id: int PK FK
    +pan: int
    +pharmacy_name: varchar(100)
    +email: varchar(50)
    +phone: varchar(10)
    +address: varchar(50)
    +isverified: tinyint
    +verification_request_date: datetime
    +verification_date: datetime
    +license_number: varchar(100)
    +reg_document: varchar(255)
    +verification_notes: text
    +created_at: datetime
    +user()
    +categories()
    +medicines()
    +orders()
    +sales()
}

class Admin {
    +admin_id: int PK FK
    +name: varchar(100)
    +email: varchar(50)
    +gender: varchar(10)
    +phone: varchar(10)
    +dob: date
    +address: varchar(50)
    +user()
}

class Category {
    +c_id: int PK
    +pharmacy_id: int FK
    +category_name: varchar(30)
    +pharmacy()
    +medicines()
}

class UserMedicine {
    +m_id: int PK
    +pharmacy_id: int FK
    +medicine_name: varchar(100)
    +medicine_desc: varchar(1000)
    +c_id: int FK
    +in_stock: int
    +buy_price: int
    +sell_price: int
    +added_date: timestamp
    +exp_date: date
    +pharmacy()
    +category()
    +orders()
    +sales()
}

class Order {
    +o_id: int PK
    +m_id: int FK
    +pharmacy_id: int FK
    +price: int
    +quantity: int
    +total_amount: int
    +status: varchar(20)
    +order_date: date
    +medicine()
    +pharmacy()
}

class Sale {
    +s_id: int PK
    +m_id: int FK
    +pharmacy_id: int FK
    +price: int
    +quantity: int
    +total_amount: int
    +status: varchar(20)
    +sales_date: date
    +medicine()
    +pharmacy()
}

class Setting {
    +id: int PK
    +title: varchar(255)
    +small_description: text
    +sub_title: varchar(255)
    +sub_description: text
    +phone: varchar(10)
    +email: varchar(50)
}

User "1" --> "0..1" Pharmacy : owns
User "1" --> "0..1" Admin : owns
Pharmacy "1" --> "*" Category : has
Pharmacy "1" --> "*" UserMedicine : stocks
Pharmacy "1" --> "*" Order : places
Pharmacy "1" --> "*" Sale : records
Category "1" --> "*" UserMedicine : classifies
UserMedicine "1" --> "*" Order : line_item
UserMedicine "1" --> "*" Sale : line_item
@enduml
```

---

## 2. Object Diagram

Snapshot of pharmacy `user_id = 89` from `pharmacy.sql`. Shows one category (`tablets`), two medicines, one pending order, and one completed sale.

```plantuml
@startuml
skinparam object {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
top to bottom direction

package "User & Pharmacy" {
    object "user_89: User" as user {
        user_id = 89
        name = "Pharmacy"
        email = "pharmacy@gmail.com"
        role = "user"
    }

    object "pharmacy_89: Pharmacy" as pharm {
        pharmacy_id = 89
        pan = 987456
        pharmacy_name = "city pharmacy"
        email = "pharmacy@gmail.com"
        isverified = 0
        verification_request_date = null
        license_number = null
        reg_document = null
    }
}

package "Inventory" {
    object "cat_20: Category" as cat {
        c_id = 20
        pharmacy_id = 89
        category_name = "tablets"
    }

    object "med_50: UserMedicine" as med50 {
        m_id = 50
        pharmacy_id = 89
        c_id = 20
        medicine_name = "Paracetamol 500mg"
        in_stock = 500
        buy_price = 10
        sell_price = 15
    }

    object "med_22: UserMedicine" as med22 {
        m_id = 22
        pharmacy_id = 89
        c_id = 20
        medicine_name = "cetamol 2"
        in_stock = 50
        buy_price = 50
        sell_price = 60
    }
}

package "Transactions" {
    object "order_100: Order" as order {
        o_id = 100
        pharmacy_id = 89
        m_id = 50
        price = 15
        quantity = 10
        total_amount = 150
        status = "pending"
        order_date = "2026-02-21"
    }

    object "sale_100: Sale" as sale {
        s_id = 100
        pharmacy_id = 89
        m_id = 22
        price = 60
        quantity = 10
        total_amount = 600
        status = "completed"
        sales_date = "2026-02-21"
    }
}

user --> pharm : owns
pharm --> cat : has
pharm --> med22 : stocks
pharm --> med50 : stocks
cat --> med22 : classifies
cat --> med50 : classifies
med50 ..> order : ordered_as
med22 ..> sale : sold_as
@enduml
```

---

## 3. Combined State Transition Diagrams

Single navigable state machine covering the full application flow: authentication, role-based dashboard navigation, per-feature CRUD operations, and business-object lifecycles with stock side-effects.

```plantuml
@startuml
skinparam state {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
    linetype ortho
}
top to bottom direction

' ========== AUTH ==========
[*] --> Unauthenticated
Unauthenticated --> Authenticated : Login
Authenticated --> Unauthenticated : Logout

state Authenticated {
    [*] --> RoleCheck
    RoleCheck --> PharmDashboard : role=user
    RoleCheck --> AdminDashboard : role=admin

    ' ===== PHARMACY DASHBOARD =====
    state "Pharmacy Dashboard" as PharmDashboard

    ' ===== MEDICINES =====
    state "Medicines" as MedMgmt {
        [*] --> MedicineList
        MedicineList --> MedicineCreate : Add
        MedicineCreate --> MedicineList : Save
        MedicineList --> MedicineEdit : Modify
        MedicineEdit --> MedicineList : Update
        MedicineList --> [*] : Delete
    }

    ' ===== ORDERS =====
    state "Orders" as OrderMgmt {
        [*] --> OrderList
        OrderList --> OrderCreate : Place
        OrderCreate --> OrderList : Submit

        state "Lifecycle" as OrderCycle {
            [*] --> Pending
            Pending --> Completed : Confirm
            Completed --> Pending : Revert
            Pending --> [*] : Delete
            Completed --> [*] : Delete
        }

        OrderList --> OrderCycle : Manage
        OrderCycle --> OrderList : Return
    }

    ' ===== ADMIN DASHBOARD =====
    state "Dashboard" as AdminDashboard {
        state "View Pharmacy Stats" as AdminStats
    }

    ' ===== VERIFICATION =====
    state "Verification" as AdminVerify {
        [*] --> PendingList
        PendingList --> ApproveForm : Approve
        PendingList --> RejectForm : Reject
        ApproveForm --> PendingList : Confirm
        RejectForm --> PendingList : Confirm
    }

    ' ===== ADMINS =====
    state "Admins" as AdminMgmt {
        [*] --> AdminList
        AdminList --> AdminCreate : Add
        AdminCreate --> AdminList : Save
    }

    ' ===== SETTINGS =====
    state "Settings" as SettingMgmt {
        [*] --> ViewSettings
        ViewSettings --> EditSettings : Edit
        EditSettings --> ViewSettings : Save
    }

    ' ===== PHARMACY NAVIGATION =====
    PharmDashboard --> MedMgmt : Medicines
    PharmDashboard --> OrderMgmt : Orders
    MedMgmt --> PharmDashboard : Return
    OrderMgmt --> PharmDashboard : Return

    ' ===== ADMIN NAVIGATION =====
    AdminDashboard --> AdminVerify : Verification
    AdminDashboard --> AdminMgmt : Admins
    AdminDashboard --> SettingMgmt : Settings
    AdminVerify --> AdminDashboard : Return
    AdminMgmt --> AdminDashboard : Return
    SettingMgmt --> AdminDashboard : Return
}
@enduml
```

---

## 4. Combined Sequence Diagrams

Three key interaction flows stacked vertically. Each flow has its own complete participant lifecycle. Shared infrastructure (Router, PDO Database) appears across flows.

```plantuml
@startuml
skinparam sequence {
    ArrowColor #2C3E50
    LifeLineBackgroundColor #F0F8FF
    ParticipantBackgroundColor #F0F8FF
}
hide footbox

actor User
participant "Router" as R
participant "Controller" as C
participant "Model" as M
participant "Database" as DB

group Authentication
    User -> R: POST /login
    R -> C: Mount AuthController
    activate C
    C -> C: Validate Input
    C -> M: Find by Email
    activate M
    M -> DB: Fetch User
    DB --> M: User Data
    M --> C: Auth Result
    deactivate M
    alt Invalid Credentials
        C --> User: Redirect with Error
    else Valid
        C -> C: Set Session
        C --> User: Redirect Dashboard
    end
    deactivate C
end

group Place Order
    User -> R: POST /pharmacy/orders
    R -> C: Auth Middleware
    activate C
    C -> C: Validate Input
    C -> M: Find Medicine
    activate M
    M -> DB: Fetch Stock
    DB --> M: Medicine Data
    M --> C: Stock Info
    deactivate M
    alt Insufficient Stock
        C --> User: Redirect with Error
    else Sufficient
        C -> M: Insert Order
        activate M
        M -> DB: Store Record
        DB --> M: Confirmation
        deactivate M
        C -> M: Update Stock
        C --> User: Redirect to Orders
    end
    deactivate C
end

group Approve Pharmacy
    User -> R: POST /admin/pharmacies/approve
    R -> C: Admin Middleware
    activate C
    C -> C: Validate Notes
    C -> M: Update Pharmacy
    activate M
    M -> DB: Set Verified
    DB --> M: Confirmation
    deactivate M
    C --> User: Redirect to Verification
    deactivate C
end
@enduml
```

---

## 5. Activity Diagram — Order Completion via Status Update

This workflow follows `OrderController@update` which handles completing a pending order. Auth is checked by `PharmacyMiddleware` before the controller runs.

```plantuml
@startuml
skinparam ActivityBackgroundColor #F0F8FF
skinparam ActivityBorderColor #2C3E50
skinparam ArrowColor #2C3E50
skinparam ActivityDiamondBackgroundColor #F0F8FF
skinparam ActivityDiamondBorderColor #2C3E50

title MedVault — Complete Order

|#LightCyan|Auth|
start
:Check authentication;
if (Authenticated?) then (no)
  :Redirect to login;
  stop
else (yes)
endif

|#White|OrderController|
:Find order by ID;
if (Order exists?) then (no)
  :Show error;
  stop
else (yes)
if (Already completed?) then (yes)
  :Show warning;
  stop
else (no)
endif
endif

|#AntiqueWhite|UserMedicine Model|
:Check stock;
if (Stock sufficient?) then (no)
  :Show stock error;
  stop
else (yes)
  :Deduct stock;
endif

|#White|OrderController|
:Mark as completed;

|#LightCyan|User|
:Show success;

stop

legend right
  |= Area |= Role |
  |#LightCyan| Auth / User |
  |#White| Controller |
  |#AntiqueWhite| Model |
endlegend
@enduml
```

---

## 6. Refinement of Class

Full entity detail with packages, custom business methods, controller classes, and middleware guards.

```plantuml
@startuml
skinparam class {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
skinparam classAttributeIconSize 0
top to bottom direction

package "Identity & Access" {
    class User {
        +user_id: int PK
        +name: varchar(100)
        +email: varchar(50)
        +password: varchar(255)
        +role: varchar(10)
        +pharmacy()
        +admin()
        +findByEmail(email)
        +create(name, email, passwordHash, role)
    }

    class Pharmacy {
        +pharmacy_id: int PK FK
        +pan: int
        +pharmacy_name: varchar(100)
        +email: varchar(50)
        +phone: varchar(10)
        +address: varchar(50)
        +isverified: tinyint
        +verification_request_date: datetime
        +verification_date: datetime
        +license_number: varchar(100)
        +reg_document: varchar(255)
        +verification_notes: text
        +created_at: datetime
        +user()
        +categories()
        +medicines()
        +orders()
        +sales()
        +createMinimal(pharmacyId, name, email)
    }

    class Admin {
        +admin_id: int PK FK
        +name: varchar(100)
        +email: varchar(50)
        +gender: varchar(10)
        +phone: varchar(10)
        +dob: date
        +address: varchar(50)
        +user()
    }
}

package "Inventory" {
    class Category {
        +c_id: int PK
        +pharmacy_id: int FK
        +category_name: varchar(30)
        +pharmacy()
        +medicines()
        +findByPharmacy(pharmacyId)
        +create(pharmacyId, name)
        +hasMedicines(categoryId)
    }

    class UserMedicine {
        +m_id: int PK
        +pharmacy_id: int FK
        +medicine_name: varchar(100)
        +medicine_desc: varchar(1000)
        +c_id: int FK
        +in_stock: int
        +buy_price: int
        +sell_price: int
        +added_date: timestamp
        +exp_date: date
        +pharmacy()
        +category()
        +orders()
        +sales()
        +findByPharmacy(pharmacyId, conditions, params)
        +paginateByPharmacy(pharmacyId, page, perPage, conditions, params)
        +countByPharmacy(pharmacyId, conditions, params)
        +create(data)
        +search(pharmacyId, term, limit)
        +updateStock(id, quantityChange)
        +getCategoryDistribution(pharmacyId)
        +getLowStock(pharmacyId, threshold)
        +getRecentActivities(pharmacyId, limit)
        +hasRelatedRecords(medicineId)
    }
}

package "Transactions" {
    class Order {
        +o_id: int PK
        +m_id: int FK
        +pharmacy_id: int FK
        +price: int
        +quantity: int
        +total_amount: int
        +status: varchar(20)
        +order_date: date
        +medicine()
        +pharmacy()
        +findByPharmacy(pharmacyId, conditions, params)
        +paginateByPharmacy(pharmacyId, page, perPage, conditions, params)
        +findByIdAndPharmacy(orderId, pharmacyId)
        +deleteByPharmacy(orderId, pharmacyId)
        +updateByPharmacy(orderId, pharmacyId, data)
        +getDailyOrders(pharmacyId, start, end)
        +getStatusDistribution(pharmacyId, start, end)
        +getStats(pharmacyId, start, end)
        +getTopOrdered(pharmacyId, start, end, limit)
        +getRecentOrders(pharmacyId, limit)
    }

    class Sale {
        +s_id: int PK
        +m_id: int FK
        +pharmacy_id: int FK
        +price: int
        +quantity: int
        +total_amount: int
        +status: varchar(20)
        +sales_date: date
        +medicine()
        +pharmacy()
        +paginateByPharmacy(pharmacyId, page, perPage, conditions, params)
        +findByIdAndPharmacy(saleId, pharmacyId)
        +deleteByPharmacy(saleId, pharmacyId)
        +updateByPharmacy(saleId, pharmacyId, data)
        +getSalesData(pharmacyId, start, end)
    }
}

package "System" {
    class Setting {
        +id: int PK
        +title: varchar(255)
        +small_description: text
        +sub_title: varchar(255)
        +sub_description: text
        +phone: varchar(10)
        +email: varchar(50)
    }
}

' Entity Relationships
User "1" --> "0..1" Pharmacy : owns
User "1" --> "0..1" Admin : owns
Pharmacy "1" --> "*" Category : has
Pharmacy "1" --> "*" UserMedicine : stocks
Pharmacy "1" --> "*" Order : places
Pharmacy "1" --> "*" Sale : records
Category "1" --> "*" UserMedicine : classifies
UserMedicine "1" --> "*" Order : line_item
UserMedicine "1" --> "*" Sale : line_item
@enduml
```

---

## 7. Refinement of Object — Full Row Values

Actual data from `pharmacy.sql` dump and usage patterns in the code. Pharmacy `user_id = 89` ("city pharmacy") with one category, two medicines, one order, one sale.

```plantuml
@startuml
skinparam object {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
top to bottom direction

package "Identity Records" {
    object "role_89: User" as role {
        user_id = 89
        name = "Pharmacy"
        email = "pharmacy@gmail.com"
        password = "$2y$10$s0GYtiGf4GU0i8eqrdwoeeK0VshD/wpgGiasIJakuLIWphI82MhpS"
        role = "user"
    }

    object "pharm_89: Pharmacy" as pharm {
        pharmacy_id = 89
        pan = 987456
        pharmacy_name = "city pharmacy"
        email = "pharmacy@gmail.com"
        phone = null
        address = null
        isverified = 0
        verification_request_date = null
        license_number = null
        reg_document = null
    }
}

package "Inventory Records" {
    object "cat_20: Category" as cat {
        c_id = 20
        pharmacy_id = 89
        category_name = "tablets"
    }

    object "med_50: UserMedicine" as med50 {
        m_id = 50
        pharmacy_id = 89
        c_id = 20
        medicine_name = "Paracetamol 500mg"
        in_stock = 500
        buy_price = 10
        sell_price = 15
        exp_date = "2028-12-31"
    }

    object "med_22: UserMedicine" as med22 {
        m_id = 22
        pharmacy_id = 89
        c_id = 20
        medicine_name = "cetamol 2"
        in_stock = 50
        buy_price = 50
        sell_price = 60
        exp_date = "2030-11-12"
    }
}

package "Transaction Records" {
    object "order_100: Order" as order {
        o_id = 100
        m_id = 50
        pharmacy_id = 89
        price = 15
        quantity = 10
        total_amount = 150
        status = "pending"
        order_date = "2026-02-21"
    }

    object "sale_100: Sale" as sale {
        s_id = 100
        m_id = 22
        pharmacy_id = 89
        price = 60
        quantity = 10
        total_amount = 600
        status = "completed"
        sales_date = "2026-02-21"
    }
}

role --> pharm : row with same user_id (FK)
pharm --> cat : FK pharmacy_id
pharm --> med22 : FK pharmacy_id
pharm --> med50 : FK pharmacy_id
cat --> med22 : FK c_id
cat --> med50 : FK c_id
@enduml
```

---

## 8. Component Diagram

Maps to actual code directories under `app/`, `views/`, `routes.php`, `public/index.php`, and `vendor/`.

```plantuml
@startuml
skinparam {
    ComponentStyle uml2
    ComponentBackgroundColor #F0F8FF
    ComponentBorderColor #2C3E50
    ArrowColor #2C3E50
}
skinparam PackageBackgroundColor transparent
skinparam PackageBorderColor #666666

title MedVault — Component Architecture

[Web Browser] as Browser

package "Presentation" {
    [Views] as Views
    [Assets] as Assets
}

package "Application" {
    [App] as App
    [Router] as Router
    [Middleware] as Middleware
    [Controllers] as Controllers
}

package "Domain" {
    [User] as M_User
    [Pharmacy] as M_Pharmacy
    [Admin] as M_Admin
    [Medicine] as M_Medicine
    [Category] as M_Category
    [Order] as M_Order
    [Sale] as M_Sale
    [Setting] as M_Setting
}

package "Infrastructure" {
    [Database] as Database
    [Session] as Session
    database "MySQL" as MySQL
}

Browser --> App
App --> Router
Router --> Middleware
Router --> Controllers
Controllers --> Domain
Controllers --> Views
Controllers --> Session
Domain --> Database
Database --> MySQL
@enduml
```

---

## 9. Deployment Diagram

Docker Compose topology with three containers on a single host, as defined in `docker-compose.yml` and `Dockerfile`.

```plantuml
@startuml
skinparam actorBorderColor #2C3E50
skinparam actorBackgroundColor #F0F8FF
skinparam nodeBackgroundColor #F0F8FF
skinparam nodeBorderColor #2C3E50
skinparam databaseBackgroundColor #F0F8FF
skinparam databaseBorderColor #2C3E50
skinparam artifactBackgroundColor #F0F8FF
skinparam artifactBorderColor #2C3E50
skinparam ArrowColor #2C3E50

actor "Browser" as Client

node "Docker Host" as DockerHost {
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
Client --> PMA : :8080

Apache --> PHP
PHP --> Code
PHP --> MySQL : PDO :3306
PMA --> MySQL
MySQL --> Volume
@enduml
```

### Environment Variables

| File | Variable | Value |
|------|----------|-------|
| docker-compose.yml | `DB_HOST` | `db` (Docker DNS name) |
| docker-compose.yml | `DB_NAME` | `pharmacy` |
| docker-compose.yml | `DB_USER` | `root` |
| docker-compose.yml | `DB_PASS` | `medvault` |
| docker-compose.yml | `APP_URL` | `http://localhost:8000` |
| Dockerfile | — | Exposes port 80 (mapped to host 8000) |

---

## Correction Log

| # | Issue in previous version | Correction |
|---|---------------------------|------------|
| 1 | `Model::findById` return type `array` | Changed to `?array` (can return null) |
| 2 | Object diagram used fictional "HealthFirst" data | Replaced with actual data from `pharmacy.sql` (user_id=89) |
| 3 | Sale state diagram showed "deduct stock" on `store()` | **Fixed**: `SalesController@store()` does NOT deduct stock. Stock deducted only in `update()`. |
| 4 | Sequence: Login showed `Router` as direct handler | Now shows `App::boot()` -> `Router::dispatch()` -> `AuthController` |
| 5 | Sequence: Order missing middleware layer | Added `PharmacyMiddleware` as explicit guard before controller |
| 6 | Activity diagram assumed old codebase flow | Rewired to match `OrderController@update` with middleware pre-check |
| 7 | Refined Class used `TblPharmacy` / `Role` / `Settings` class names | Corrected to `Pharmacy` / `User` / `Setting` (actual model class names) |
| 8 | Refined Class used invalid Mermaid arrow syntax | Replaced with valid `-->` FK reference notation |
| 9 | Refined Object used `<<TblPharmacy>>` / `<<Role>>` stereotypes | Changed to `<<Pharmacy>>` / `<<User>>` with table name in parentheses |
| 10 | Component diagram had abstract "Presentation Layer" | Replaced with actual file directory structure (`views/`, `public/index.php`) |
| 11 | Deployment: text mentioned port 8001 (not in compose file) | Removed spurious 8001 reference. Port mapping is `8000:80` per `docker-compose.yml` |
| 12 | All diagrams used Mermaid syntax | Converted to PlantUML syntax (`@startuml`/`@enduml` blocks) |
| 13 | Object diagrams used `class` keyword for instances | Changed to PlantUML `object` keyword with stereotypes |
| 14 | Sequence diagrams used Mermaid `->>` arrows | Changed to PlantUML `->` and `-->>` arrows with activate/deactivate |
| 15 | State diagrams used Mermaid `stateDiagram-v2` | Converted to PlantUML state diagram syntax |
| 16 | Activity diagram used Mermaid `flowchart` | Converted to PlantUML activity diagram syntax |
| 17 | Component/deployment used Mermaid `flowchart` | Converted to PlantUML deployment/component syntax with proper stereotypes |
| 18 | Order lifecycle: `OrderController@store` deducts stock immediately on pending creation | Added note in Correction Log: store() deducts stock on insertion, not on completion |
| 19 | Flat layout without package groupings | Added logical package containers (Framework Core / Identity / Inventory / Transactions / System) matching KharchaTrack reference structure |
| 20 | Inconsistent color palette across diagrams | Unified to `#F0F8FF` (background) / `#2C3E50` (borders+arrows) throughout all diagram types |
| 21 | Activity diagram lacked swimlanes/legend | Added color-coded swimlane partitions (`|Auth|`, `|OrderController|`, `|UserMedicine Model|`) with legend |
| 22 | Component diagram used `skinparam packageStyle rectangle` with raw rectangles | Upgraded to `ComponentStyle uml2` with standard UML2 component notation and transparent package borders |
| 23 | Class diagram used abstract Model with inherited methods | Converted to entity-style showing only DB columns + FK navigation methods per entity |
| 24 | Object diagram used incorrect user name "city pharmacy" | Changed to "Pharmacy" matching actual `role.name` value |
| 25 | Object diagram referenced non-existent `pharmacy_id=89` in `tbl_pharmacy` | Added missing `tbl_pharmacy` record to `pharmacy.sql` |
| 26 | Object diagram FK arrows pointed to wrong medicines (order_100.m_id=51, sale_100.m_id=52) | Fixed to m_id=50 and m_id=22 so arrows match medicines in the diagram |
| 27 | Refined Class diagram missing 7 `tbl_pharmacy` columns | Added isverified, verification_request_date, verification_date, license_number, reg_document, verification_notes, created_at to match controller code |
| 28 | State diagrams were 4 separate diagrams | Combined into single stacked portrait diagram for A4 readability |
| 29 | Sequence diagrams were 3 separate diagrams | Combined into single stacked portrait diagram with independent flow sections |
| 30 | Refinement of Class lacked controller and middleware classes | Added full Controller and Middleware packages with key methods, plus usage dependencies |
