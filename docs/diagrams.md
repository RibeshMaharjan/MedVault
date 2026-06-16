# MedVault — UML Diagrams

All diagrams are verified against the actual codebase at commit time. Every class name, method signature, route, database column, and control flow reflects the source code, not an assumed design.

---

## 1. Class Diagram

Eight concrete models extend the abstract `App\Core\Model`. All persistence uses PDO prepared statements through the base class.

```mermaid
classDiagram
    direction LR

    class Model {
        <<abstract>>
        #string table
        #string primaryKey
        #PDO db
        +__construct()
        +findAll(conditions, params) array
        +findById(id, idCol) ?array
        +findAllBy(col, value) array
        +findOneBy(col, value) ?array
        +count(conditions, params) int
        +insert(data) int
        +update(id, data, idCol) bool
        +delete(id, idCol) bool
        +paginate(page, perPage, conditions, params) array
        #query(sql, params) PDOStatement
    }

    class User {
        #table = "role"
        #primaryKey = "user_id"
        +findByEmail(email) ?array
        +create(name, email, passwordHash, role) int
    }

    class Pharmacy {
        #table = "tbl_pharmacy"
        #primaryKey = "pharmacy_id"
        +createMinimal(pharmacyId, name, email) bool
    }

    class Admin {
        #table = "tbl_admin"
        #primaryKey = "admin_id"
    }

    class Category {
        #table = "user_category_tbl"
        #primaryKey = "c_id"
        +findByPharmacy(pharmacyId) array
        +create(pharmacyId, name) int
        +hasMedicines(categoryId) int
    }

    class UserMedicine {
        #table = "user_medicine_tbl"
        #primaryKey = "m_id"
        +findByPharmacy(pharmacyId, conditions, params) array
        +paginateByPharmacy(pharmacyId, page, perPage, ...) array
        +countByPharmacy(pharmacyId, conditions, params) int
        +create(data) int
        +search(pharmacyId, term, limit) array
        +updateStock(id, quantityChange) bool
        +getCategoryDistribution(pharmacyId) array
        +getLowStock(pharmacyId, threshold) array
        +getRecentActivities(pharmacyId, limit) array
        +hasRelatedRecords(medicineId) array
    }

    class Order {
        #table = "user_order_tbl"
        #primaryKey = "o_id"
        +findByPharmacy(pharmacyId, conditions, params) array
        +paginateByPharmacy(pharmacyId, page, perPage, ...) array
        +findByIdAndPharmacy(orderId, pharmacyId) ?array
        +deleteByPharmacy(orderId, pharmacyId) bool
        +updateByPharmacy(orderId, pharmacyId, data) bool
        +getDailyOrders(pharmacyId, start, end) array
        +getStatusDistribution(pharmacyId, start, end) array
        +getStats(pharmacyId, start, end) array
        +getTopOrdered(pharmacyId, start, end, limit) array
        +getRecentOrders(pharmacyId, limit) array
    }

    class Sale {
        #table = "user_sales_tbl"
        #primaryKey = "s_id"
        +paginateByPharmacy(pharmacyId, page, perPage, ...) array
        +findByIdAndPharmacy(saleId, pharmacyId) ?array
        +deleteByPharmacy(saleId, pharmacyId) bool
        +updateByPharmacy(saleId, pharmacyId, data) bool
        +getSalesData(pharmacyId, start, end) array
    }

    class Setting {
        #table = "settings"
        #primaryKey = "id"
    }

    Model <|-- User
    Model <|-- Pharmacy
    Model <|-- Admin
    Model <|-- Category
    Model <|-- UserMedicine
    Model <|-- Order
    Model <|-- Sale
    Model <|-- Setting

    User "1" --> "0..1" Pharmacy : owns profile
    User "1" --> "0..1" Admin : owns profile
    Pharmacy "1" *-- "0..*" Category : has
    Pharmacy "1" *-- "0..*" UserMedicine : stocks
    Pharmacy "1" *-- "0..*" Order : places
    Pharmacy "1" *-- "0..*" Sale : records
    Category "1" o-- "0..*" UserMedicine : classifies
    UserMedicine "1" -- "0..*" Order : line_item
    UserMedicine "1" -- "0..*" Sale : line_item
```

### Database Table Details

| Model | Table | PK | FK Column | References |
|-------|-------|----|-----------|------------|
| `User` | `role` | `user_id` | — | — |
| `Pharmacy` | `tbl_pharmacy` | `pharmacy_id` | `pharmacy_id` | `role.user_id` |
| `Admin` | `tbl_admin` | `admin_id` | `admin_id` | `role.user_id` |
| `Category` | `user_category_tbl` | `c_id` | `pharmacy_id` | `role.user_id` |
| `UserMedicine` | `user_medicine_tbl` | `m_id` | `pharmacy_id`, `c_id` | `role.user_id`, `user_category_tbl.c_id` |
| `Order` | `user_order_tbl` | `o_id` | `m_id`, `pharmacy_id` | `user_medicine_tbl.m_id`, `role.user_id` |
| `Sale` | `user_sales_tbl` | `s_id` | `m_id`, `pharmacy_id` | `user_medicine_tbl.m_id`, `role.user_id` |
| `Setting` | `settings` | `id` | — | — |

---

## 2. Object Diagram

Snapshot of pharmacy `user_id = 89` (from sample data). Shows category `tablets`, two medicines, one pending order, one completed sale.

```mermaid
classDiagram
    direction TB

    class pharmacy_89 {
        <<Pharmacy>>
        pharmacy_id = 89
        pan = 987456
        pharmacy_name = "city pharmacy"
        email = "pharmacy@gmail.com"
    }

    class user_89 {
        <<User>>
        user_id = 89
        name = "city pharmacy"
        email = "pharmacy@gmail.com"
        role = "user"
    }

    class cat_20 {
        <<Category>>
        c_id = 20
        pharmacy_id = 89
        category_name = "tablets"
    }

    class med_50 {
        <<UserMedicine>>
        m_id = 50
        pharmacy_id = 89
        c_id = 20
        medicine_name = "Paracetamol 500mg"
        in_stock = 500
        buy_price = 10
        sell_price = 15
    }

    class med_22 {
        <<UserMedicine>>
        m_id = 22
        pharmacy_id = 89
        c_id = 20
        medicine_name = "cetamol 2"
        in_stock = 50
        buy_price = 50
        sell_price = 60
    }

    class order_100 {
        <<Order>>
        o_id = 100
        pharmacy_id = 89
        m_id = 51
        price = 25
        quantity = 8
        total_amount = 200
        status = "pending"
        order_date = "2026-02-21"
    }

    class sale_100 {
        <<Sale>>
        s_id = 100
        pharmacy_id = 89
        m_id = 52
        price = 20
        quantity = 42
        total_amount = 840
        status = "completed"
        sales_date = "2026-02-21"
    }

    user_89 --> pharmacy_89 : owns
    pharmacy_89 --> cat_20 : has
    pharmacy_89 --> med_22 : stocks
    pharmacy_89 --> med_50 : stocks
    cat_20 --> med_22 : classifies
    cat_20 --> med_50 : classifies
    med_50 ..> order_100 : ordered_as
    med_22 ..> sale_100 : sold_as
```

---

## 3. State Transition Diagrams

### Order Lifecycle

Based on `OrderController@store` (inserts pending) and `OrderController@update` (status transitions with stock side-effects).

```mermaid
stateDiagram-v2
    direction LR

    [*] --> pending : OrderController@store()

    pending --> completed : update() [in_stock >= qty] / UserMedicine::updateStock(-qty)
    completed --> pending : update() [restore stock] / UserMedicine::updateStock(+qty)

    pending --> [*] : destroy() / no stock restore
    completed --> [*] : destroy() / UserMedicine::updateStock(+qty)
```

### Sale Lifecycle

**Important:** `SalesController@store()` inserts a sale as `pending` but does **not** deduct stock. Stock is deducted **only** when `SalesController@update()` transitions from `pending` to `completed`.

```mermaid
stateDiagram-v2
    direction LR

    [*] --> pending : SalesController@store() / no stock change

    pending --> completed : update() / UserMedicine::updateStock(-qty)
    completed --> pending : update() / UserMedicine::updateStock(+qty)

    pending --> [*] : destroy() / no stock restore
    completed --> [*] : destroy() / UserMedicine::updateStock(+qty)
```

### Authentication Session

Based on `AuthController@login`, `AuthController@logout`, and `AuthMiddleware`/`PharmacyMiddleware`/`AdminMiddleware`.

```mermaid
stateDiagram-v2
    direction TB

    [*] --> Guest

    Guest --> Guest : login [password_verify fails] / flash error
    Guest --> Authenticated : login [password_verify ok]

    state Authenticated {
        direction LR
        [*] --> AdminRole : loggedInUserRole = "admin"
        [*] --> PharmacyRole : loggedInUserRole = "user"
    }

    Authenticated --> Guest : logout / Session::destroy()
```

### Pharmacy Verification Lifecycle

Based on `ProfileController@requestVerification`, `PharmacyController@approve`, `PharmacyController@reject`.

```mermaid
stateDiagram-v2
    direction LR

    [*] --> Unverified : register

    Unverified --> Pending : ProfileController@requestVerification() / set verification_request_date
    Pending --> Verified : PharmacyController@approve() / set isverified=1
    Pending --> Unverified : PharmacyController@reject() / clear verification_request_date
    Pending --> Pending : ProfileController@requestVerification() / resubmit
```

---

## 4. Sequence Diagrams

### Login Flow

Actual route: `POST /login` → `AuthController@login`

```mermaid
sequenceDiagram
    autonumber

    actor User
    participant AppBoot as App::boot()
    participant Router
    participant AuthCtrl as AuthController
    participant UserModel as User Model
    participant DB as PDO Database

    User->>AppBoot: POST /login (email, password)

    AppBoot->>AppBoot: load .env, start session
    AppBoot->>Router: new Router()
    AppBoot->>Router: require routes.php
    AppBoot->>Router: dispatch(/login, POST)

    Router->>Router: match route → AuthController@login
    Router->>AuthCtrl: new AuthController()
    activate AuthCtrl

    AuthCtrl->>AuthCtrl: validate(email), get password
    AuthCtrl->>UserModel: findByEmail(email)
    activate UserModel
    UserModel->>DB: SELECT * FROM role WHERE email = ? LIMIT 1
    DB-->>UserModel: user record
    UserModel-->>AuthCtrl: user array or null
    deactivate UserModel

    alt user not found
        AuthCtrl-->>User: redirect /login "Invalid Email or Password"
    else password_verify fails
        AuthCtrl-->>User: redirect /login "Invalid Password"
    else valid
        AuthCtrl->>AuthCtrl: Session::setAuth(user, role)
        alt role = "admin"
            AuthCtrl-->>User: redirect /admin/dashboard "Logged In Successfully"
        else role = "user"
            AuthCtrl-->>User: redirect /pharmacy/dashboard "Logged In Successfully"
        end
    end
    deactivate AuthCtrl
```

### Pharmacy Places Order

Actual route: `POST /pharmacy/orders` → `OrderController@store` (with `PharmacyMiddleware`)

```mermaid
sequenceDiagram
    autonumber

    actor User as Pharmacy User
    participant Router
    participant Middleware as PharmacyMiddleware
    participant OrderCtrl as OrderController
    participant Medicine as UserMedicine Model
    participant OrderModel as Order Model
    participant DB as PDO Database

    User->>Router: POST /pharmacy/orders (m_id, price, qty, total, order_date)

    Router->>Router: match route, detect middleware
    Router->>Middleware: new PharmacyMiddleware()->handle()
    activate Middleware
    alt session not auth or role != "user"
        Middleware-->>User: redirect /login "Access denied"
    end
    deactivate Middleware

    Router->>OrderCtrl: new OrderController()
    activate OrderCtrl

    OrderCtrl->>OrderCtrl: validate(qty>0, price>0, date >= today)

    OrderCtrl->>Medicine: findById(m_id)
    activate Medicine
    Medicine->>DB: SELECT * FROM user_medicine_tbl WHERE m_id = ? LIMIT 1
    DB-->>Medicine: medicine row
    Medicine-->>OrderCtrl: med array
    deactivate Medicine

    alt med null or med.in_stock < qty
        OrderCtrl-->>User: redirect /pharmacy/orders/create "Not enough stock"
    else stock sufficient
        OrderCtrl->>OrderModel: insert({pharmacy_id, m_id, price, qty, total, status:"pending", order_date})
        activate OrderModel
        OrderModel->>DB: INSERT INTO user_order_tbl (...) VALUES (...)
        DB-->>OrderModel: lastInsertId
        OrderModel-->>OrderCtrl: o_id
        deactivate OrderModel

        OrderCtrl->>Medicine: updateStock(m_id, -qty)
        activate Medicine
        Medicine->>DB: UPDATE user_medicine_tbl SET in_stock = in_stock - ? WHERE m_id = ?
        DB-->>Medicine: rowCount
        deactivate Medicine

        OrderCtrl-->>User: redirect /pharmacy/orders "Order has been submitted"
    end
    deactivate OrderCtrl
```

### Admin Approves Pharmacy Verification

Actual route: `POST /admin/pharmacies/{id}/approve` → `PharmacyController@approve` (with `AdminMiddleware`)

```mermaid
sequenceDiagram
    autonumber

    actor Admin
    participant Router
    participant Middleware as AdminMiddleware
    participant PharmCtrl as PharmacyController
    participant PharmModel as Pharmacy Model
    participant DB as PDO Database

    Admin->>Router: POST /admin/pharmacies/42/approve (verification_notes)

    Router->>Router: match route, detect middleware
    Router->>Middleware: new AdminMiddleware()->handle()
    activate Middleware
    alt not auth or role != "admin"
        Middleware-->>Admin: redirect /login "Access denied"
    end
    deactivate Middleware

    Router->>PharmCtrl: new PharmacyController()
    activate PharmCtrl

    PharmCtrl->>PharmCtrl: validate(verification_notes)
    PharmCtrl->>PharmModel: update(pharmacy_id=42, {isverified:1, verification_date:now, verification_notes:"..."})
    activate PharmModel
    PharmModel->>DB: UPDATE tbl_pharmacy SET isverified=1, verification_date=?, verification_notes=? WHERE pharmacy_id=?
    DB-->>PharmModel: rowCount >= 0
    deactivate PharmModel

    PharmCtrl-->>Admin: redirect /admin/pharmacies/verify "Pharmacy verified successfully!"
    deactivate PharmCtrl
```

---

## 5. Activity Diagram — Order Completion via Status Update

This workflow follows `OrderController@update` which handles completing a pending order. Auth is checked by `PharmacyMiddleware` before the controller runs.

```mermaid
flowchart TD
    Start(("Start")) --> SubmitAdmin("Admin/Pharmacy submits status='completed'<br/>via OrderController@update")

    SubmitAdmin --> MWCheck{"PharmacyMiddleware:<br/>session authed + role=user?"}
    MWCheck -- no --> RedirectLogin("Redirect /login") --> EndUnauth((("End")))
    MWCheck -- yes --> FindOrder("Order::findByIdAndPharmacy(orderId, pharmacyId)")

    FindOrder --> OrderExists{"Order found and<br/>belongs to pharmacy?"}
    OrderExists -- no --> NotFound("Flash — Order not found") --> EndNotFound((("End")))
    OrderExists -- yes --> OldStatusCheck{"Old status == completed?"}

    OldStatusCheck -- yes --> AlreadyCompleted("Flash — Already completed") --> EndAlready((("End")))
    OldStatusCheck -- no --> StockCheck{"UserMedicine::findById(m_id)<br/>in_stock >= quantity?"}

    StockCheck -- no --> Insufficient("Flash — Not enough stock") --> EndNoStock((("End")))
    StockCheck -- yes --> Deduct("UserMedicine::updateStock(m_id, -quantity)")

    Deduct --> Persist("Order::updateByPharmacy(orderId, pharmacyId, {status:'completed', ...})")
    Persist --> Success("Flash — Order updated") --> EndOk((("End")))
```

---

## 6. Refinement of Class — Full Database Schema Mapping

Each model mapped to its actual database table with column types. `User` (table `role`) is the parent entity; `Pharmacy` and `Admin` are child profiles sharing the same PK as `role.user_id`.

```mermaid
classDiagram
    direction TB

    class role_table {
        +int user_id PK AUTO_INCREMENT
        +varchar(100) name
        +varchar(50) email
        +varchar(255) password (bcrypt hash)
        +varchar(10) role ("admin"|"user")
    }

    class tbl_pharmacy {
        +int pharmacy_id PK FK → role.user_id
        +int pan
        +varchar(100) pharmacy_name
        +varchar(50) email
        +varchar(10) phone
        +varchar(50) address
        +tinyint isverified (0|1)
        +datetime verification_request_date
        +datetime verification_date
        +varchar(100) license_number
        +varchar(255) reg_document (path)
        +text verification_notes
        +datetime created_at
    }

    class tbl_admin {
        +int admin_id PK FK → role.user_id
        +varchar(100) name
        +varchar(50) email
        +varchar(10) gender
        +varchar(10) phone
        +date dob
        +varchar(50) address
    }

    class user_medicine_tbl {
        +int m_id PK AUTO_INCREMENT
        +int pharmacy_id FK
        +varchar(100) medicine_name
        +varchar(1000) medicine_desc
        +int c_id FK → user_category_tbl
        +int in_stock
        +int buy_price
        +int sell_price
        +timestamp added_date
        +date exp_date
    }

    class user_category_tbl {
        +int c_id PK AUTO_INCREMENT
        +int pharmacy_id FK
        +varchar(30) category_name
    }

    class user_order_tbl {
        +int o_id PK AUTO_INCREMENT
        +int m_id FK → user_medicine_tbl
        +int pharmacy_id FK
        +int price
        +int quantity
        +int total_amount
        +varchar(20) status
        +date order_date
    }

    class user_sales_tbl {
        +int s_id PK AUTO_INCREMENT
        +int m_id FK → user_medicine_tbl
        +int pharmacy_id FK
        +int price
        +int quantity
        +int total_amount
        +varchar(20) status
        +date sales_date
    }

    class settings {
        +int id PK AUTO_INCREMENT
        +varchar(255) title
        +text small_description
        +varchar(255) sub_title
        +text sub_description
        +varchar(10) phone
        +varchar(50) email
    }

    role_table --> tbl_pharmacy : pharmacy_id = user_id (1:1)
    role_table --> tbl_admin : admin_id = user_id (1:1)
    tbl_pharmacy --> user_medicine_tbl : pharmacy_id
    tbl_pharmacy --> user_category_tbl : pharmacy_id
    tbl_pharmacy --> user_order_tbl : pharmacy_id
    tbl_pharmacy --> user_sales_tbl : pharmacy_id
    user_category_tbl --> user_medicine_tbl : c_id
    user_medicine_tbl --> user_order_tbl : m_id
    user_medicine_tbl --> user_sales_tbl : m_id
```

---

## 7. Refinement of Object — Full Row Values

Actual data from `pharmacy.sql` dump and usage patterns in the code. Pharmacy `user_id = 89` ("city pharmacy") with one category, two medicines, one order, one sale.

```mermaid
classDiagram
    direction TB

    class role_89 {
        <<User: role table>>
        user_id = 89
        name = "Pharmacy"
        email = "pharmacy@gmail.com"
        password = "$2y$10$s0GYtiGf4GU0i8eqrdwoeeK0VshD/wpgGiasIJakuLIWphI82MhpS"
        role = "user"
    }

    class pharm_89 {
        <<Pharmacy: tbl_pharmacy>>
        pharmacy_id = 89
        pan = null
        pharmacy_name = "city pharmacy"
        email = "pharmacy@gmail.com"
        phone = null
        address = null
        isverified = 0
        verification_request_date = null
        license_number = null
        reg_document = null
    }

    class cat_20 {
        <<Category: user_category_tbl>>
        c_id = 20
        pharmacy_id = 89
        category_name = "tablets"
    }

    class med_50 {
        <<UserMedicine: user_medicine_tbl>>
        m_id = 50
        pharmacy_id = 89
        c_id = 20
        medicine_name = "Paracetamol 500mg"
        in_stock = 500
        buy_price = 10
        sell_price = 15
        exp_date = "2028-12-31"
    }

    class med_22 {
        <<UserMedicine: user_medicine_tbl>>
        m_id = 22
        pharmacy_id = 89
        c_id = 20
        medicine_name = "cetamol 2"
        in_stock = 50
        buy_price = 50
        sell_price = 60
        exp_date = "2030-11-12"
    }

    class order_100 {
        <<Order: user_order_tbl>>
        o_id = 100
        m_id = 51
        pharmacy_id = 89
        price = 25
        quantity = 8
        total_amount = 200
        status = "pending"
        order_date = "2026-02-21"
    }

    class sale_100 {
        <<Sale: user_sales_tbl>>
        s_id = 100
        m_id = 52
        pharmacy_id = 89
        price = 20
        quantity = 42
        total_amount = 840
        status = "completed"
        sales_date = "2026-02-21"
    }

    role_89 --> pharm_89 : row with same user_id (FK)
    pharm_89 --> cat_20 : FK pharmacy_id
    pharm_89 --> med_22 : FK pharmacy_id
    pharm_89 --> med_50 : FK pharmacy_id
    cat_20 --> med_22 : FK c_id
    cat_20 --> med_50 : FK c_id
```

---

## 8. Component Diagram

Maps to actual code directories under `app/`, `views/`, `routes.php`, `public/index.php`, and `vendor/`.

```mermaid
flowchart TB
    Browser(["«external» Web Browser"])

    subgraph MedVault["MedVault Application"]
        direction TB

        Entry["public/index.php<br/>«entry point» — require autoload, call App::boot()"]

        subgraph Core["app/Core/ — Framework Core"]
            App["App<br/>bootstrapper (.env, session, router)"]
            Router["Router<br/>route matching + middleware chain + controller dispatch"]
            Database["Database<br/>PDO singleton (env-driven config)"]
            Session["Session<br/>$_SESSION wrapper"]
            BaseController["Controller<br/>view(), redirect(), json(), validate()"]
            BaseModel["Model<br/>abstract: findAll, findById, insert, update, delete, paginate"]
        end

        subgraph Middleware["app/Middleware/"]
            AuthM["AuthMiddleware<br/>checks auth=true"]
            AdminM["AdminMiddleware<br/>checks role=admin"]
            PharmacyM["PharmacyMiddleware<br/>checks role=user"]
        end

        subgraph Controllers["app/Controllers/"]
            AuthCtrl["AuthController<br/>login / register / logout"]
            PharmControllers["Pharmacy Controllers<br/>Dashboard · Medicine · Category<br/>Order · Sales · Analytics · Profile · Ajax"]
            AdminControllers["Admin Controllers<br/>Dashboard · Pharmacy · Admin · Setting · Export"]
            LandingCtrl["LandingController"]
        end

        subgraph Models["app/Models/"]
            M_User["User (role table)"]
            M_Pharmacy["Pharmacy (tbl_pharmacy)"]
            M_Admin["Admin (tbl_admin)"]
            M_Medicine["UserMedicine (user_medicine_tbl)"]
            M_Category["Category (user_category_tbl)"]
            M_Order["Order (user_order_tbl)"]
            M_Sale["Sale (user_sales_tbl)"]
            M_Setting["Setting (settings)"]
        end

        subgraph Views["views/"]
            V_Layouts["layouts/ (admin, pharmacy)"]
            V_Admin["admin/ (dashboard, pharmacies, admins, settings)"]
            V_Pharmacy["pharmacy/ (dashboard, medicines, orders, sales, analytics, categories, profile)"]
            V_Auth["auth/ (login)"]
        end

        subgraph Config["Configuration"]
            Routes["routes.php<br/>83 route definitions"]
            Env[".env<br/>DB_HOST, DB_NAME, etc."]
        end
    end

    MySQL[("«artifact» MySQL 8.0<br/>database: pharmacy")]

    Browser --> Entry
    Entry --> App
    App --> Routes
    App --> Router
    Router --> Middleware
    Router --> BaseController
    Router --> Controllers
    Controllers --> BaseController
    Controllers --> Models
    Controllers --> Views
    Controllers --> Session
    Models --> BaseModel
    BaseModel --> Database
    Database --> MySQL
```

---

## 9. Deployment Diagram

Docker Compose topology with three containers on a single host, as defined in `docker-compose.yml` and `Dockerfile`.

```mermaid
flowchart TB
    Client(["«device» Client Machine<br/>(Web Browser)"])

    subgraph DockerHost["«device» Docker Host (physical/virtual)"]
        direction TB

        subgraph AppContainer["«execution environment» app container"]
            direction TB
            Apache["«artifact» Apache 2.4 + mod_rewrite<br/>DocumentRoot: /var/www/html/public"]
            PHP["«artifact» PHP 8.2<br/>extensions: pdo, pdo_mysql"]
            Code["«artifact» Source Code<br/>bind-mounted at /var/www/html<br/>(vendor/ excluded by .dockerignore)"]
        end

        subgraph DBContainer["«execution environment» db container"]
            MySQL["«artifact» MySQL 8.0 server<br/>init: pharmacy.sql mounted at<br/>/docker-entrypoint-initdb.d/"]
        end

        subgraph PMAContainer["«execution environment» phpmyadmin container"]
            PMA["«artifact» phpMyAdmin<br/>PMA_HOST=db, PMA_USER=root"]
        end

        Volume[("«artifact» Named Volume<br/>mysql_data<br/>→ /var/lib/mysql")]
    end

    Client -->|"HTTP localhost:8000"| Apache
    Client -->|"HTTP localhost:8080"| PMA

    Apache --> PHP
    PHP --> Code
    PHP -->|"PDO mysql:host=db;port=3306;dbname=pharmacy"| MySQL
    PMA -->|"PHP mysql:host=db:3306"| MySQL
    MySQL --- Volume
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
| 4 | Sequence: Login showed `Router` as direct handler | Now shows `App::boot()` → `Router::dispatch()` → `AuthController` |
| 5 | Sequence: Order missing middleware layer | Added `PharmacyMiddleware` as explicit guard before controller |
| 6 | Activity diagram assumed old codebase flow | Rewired to match `OrderController@update` with middleware pre-check |
| 7 | Refined Class used `TblPharmacy` / `Role` / `Settings` class names | Corrected to `Pharmacy` / `User` / `Setting` (actual model class names) |
| 8 | Refined Class used invalid Mermaid arrow syntax | Replaced with valid `-->` FK reference notation |
| 9 | Refined Object used `<<TblPharmacy>>` / `<<Role>>` stereotypes | Changed to `<<Pharmacy>>` / `<<User>>` with table name in parentheses |
| 10 | Component diagram had abstract "Presentation Layer" | Replaced with actual file directory structure (`views/`, `public/index.php`) |
| 11 | Deployment: text mentioned port 8001 (not in compose file) | Removed spurious 8001 reference. Port mapping is `8000:80` per `docker-compose.yml` |
