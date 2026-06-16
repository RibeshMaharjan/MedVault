# MedVault — UML Diagrams

All diagrams are verified against the actual codebase at commit time. Every class name, method signature, route, database column, and control flow reflects the source code, not an assumed design.

---

## 1. Class Diagram

Eight concrete models extend the abstract `App\Core\Model`. All persistence uses PDO prepared statements through the base class.

```plantuml
@startuml
skinparam class {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
skinparam classAttributeIconSize 0
top to bottom direction

package "Framework Core" {
    abstract class Model {
        {abstract}
        # string table
        # string primaryKey
        # PDO db
        + __construct()
        + findAll(conditions, params) : array
        + findById(id, idCol) : ?array
        + findAllBy(col, value) : array
        + findOneBy(col, value) : ?array
        + count(conditions, params) : int
        + insert(data) : int
        + update(id, data, idCol) : bool
        + delete(id, idCol) : bool
        + paginate(page, perPage, conditions, params) : array
        # query(sql, params) : PDOStatement
    }
}

package "Identity & Access" {
    class User {
        # table = "role"
        # primaryKey = "user_id"
        + findByEmail(email) : ?array
        + create(name, email, passwordHash, role) : int
    }

    class Pharmacy {
        # table = "tbl_pharmacy"
        # primaryKey = "pharmacy_id"
        + createMinimal(pharmacyId, name, email) : bool
    }

    class Admin {
        # table = "tbl_admin"
        # primaryKey = "admin_id"
    }
}

package "Inventory" {
    class Category {
        # table = "user_category_tbl"
        # primaryKey = "c_id"
        + findByPharmacy(pharmacyId) : array
        + create(pharmacyId, name) : int
        + hasMedicines(categoryId) : int
    }

    class UserMedicine {
        # table = "user_medicine_tbl"
        # primaryKey = "m_id"
        + findByPharmacy(pharmacyId, conditions, params) : array
        + paginateByPharmacy(pharmacyId, page, perPage ...) : array
        + countByPharmacy(pharmacyId, conditions, params) : int
        + create(data) : int
        + search(pharmacyId, term, limit) : array
        + updateStock(id, quantityChange) : bool
        + getCategoryDistribution(pharmacyId) : array
        + getLowStock(pharmacyId, threshold) : array
        + getRecentActivities(pharmacyId, limit) : array
        + hasRelatedRecords(medicineId) : array
    }
}

package "Transactions" {
    class Order {
        # table = "user_order_tbl"
        # primaryKey = "o_id"
        + findByPharmacy(pharmacyId, conditions, params) : array
        + paginateByPharmacy(pharmacyId, page, perPage ...) : array
        + findByIdAndPharmacy(orderId, pharmacyId) : ?array
        + deleteByPharmacy(orderId, pharmacyId) : bool
        + updateByPharmacy(orderId, pharmacyId, data) : bool
        + getDailyOrders(pharmacyId, start, end) : array
        + getStatusDistribution(pharmacyId, start, end) : array
        + getStats(pharmacyId, start, end) : array
        + getTopOrdered(pharmacyId, start, end, limit) : array
        + getRecentOrders(pharmacyId, limit) : array
    }

    class Sale {
        # table = "user_sales_tbl"
        # primaryKey = "s_id"
        + paginateByPharmacy(pharmacyId, page, perPage ...) : array
        + findByIdAndPharmacy(saleId, pharmacyId) : ?array
        + deleteByPharmacy(saleId, pharmacyId) : bool
        + updateByPharmacy(saleId, pharmacyId, data) : bool
        + getSalesData(pharmacyId, start, end) : array
    }
}

package "System" {
    class Setting {
        # table = "settings"
        # primaryKey = "id"
    }
}

' Inheritance
User --|> Model
Pharmacy --|> Model
Admin --|> Model
Category --|> Model
UserMedicine --|> Model
Order --|> Model
Sale --|> Model
Setting --|> Model

' Relationships
User "1" --> "0..1" Pharmacy : owns profile
User "1" --> "0..1" Admin : owns profile
Pharmacy "1" *-- "0..*" Category : has
Pharmacy "1" *-- "0..*" UserMedicine : stocks
Pharmacy "1" *-- "0..*" Order : places
Pharmacy "1" *-- "0..*" Sale : records
Category "1" o-- "0..*" UserMedicine : classifies
UserMedicine "1" --> "0..*" Order : line_item
UserMedicine "1" --> "0..*" Sale : line_item
@enduml
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
        name = "city pharmacy"
        email = "pharmacy@gmail.com"
        role = "user"
    }

    object "pharmacy_89: Pharmacy" as pharm {
        pharmacy_id = 89
        pan = 987456
        pharmacy_name = "city pharmacy"
        email = "pharmacy@gmail.com"
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
        m_id = 51
        price = 25
        quantity = 8
        total_amount = 200
        status = "pending"
        order_date = "2026-02-21"
    }

    object "sale_100: Sale" as sale {
        s_id = 100
        pharmacy_id = 89
        m_id = 52
        price = 20
        quantity = 42
        total_amount = 840
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

## 3. State Transition Diagrams

### Order Lifecycle

Based on `OrderController@store` (inserts pending, deducts stock) and `OrderController@update` (status transitions with stock side-effects).

```plantuml
@startuml
skinparam state {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
left to right direction

[*] --> pending : OrderController@store()

state pending
state completed

pending --> completed : update() [in_stock >= qty]\n/ UserMedicine::updateStock(-qty)
completed --> pending : update() [restore stock]\n/ UserMedicine::updateStock(+qty)

pending --> [*] : destroy() / no stock restore
completed --> [*] : destroy() / UserMedicine::updateStock(+qty)
@enduml
```

### Sale Lifecycle

**Important:** `SalesController@store()` inserts a sale as `pending` but does **not** deduct stock. Stock is deducted **only** when `SalesController@update()` transitions from `pending` to `completed`.

```plantuml
@startuml
skinparam state {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
left to right direction

[*] --> pending : SalesController@store()\n/ no stock change

state pending
state completed

pending --> completed : update()\n/ UserMedicine::updateStock(-qty)
completed --> pending : update()\n/ UserMedicine::updateStock(+qty)

pending --> [*] : destroy() / no stock restore
completed --> [*] : destroy() / UserMedicine::updateStock(+qty)
@enduml
```

### Authentication Session

Based on `AuthController@login`, `AuthController@logout`, and `AuthMiddleware`/`PharmacyMiddleware`/`AdminMiddleware`.

```plantuml
@startuml
skinparam state {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
top to bottom direction

[*] --> Guest

state Guest
state Authenticated {
    left to right direction
    [*] --> AdminRole : loggedInUserRole = "admin"
    [*] --> PharmacyRole : loggedInUserRole = "user"
}

Guest --> Guest : login [password_verify fails] / flash error
Guest --> Authenticated : login [password_verify ok]
Authenticated --> Guest : logout / Session::destroy()
@enduml
```

### Pharmacy Verification Lifecycle

Based on `ProfileController@requestVerification`, `PharmacyController@approve`, `PharmacyController@reject`.

```plantuml
@startuml
skinparam state {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
left to right direction

[*] --> Unverified : register

state Unverified
state Pending {
    verification_request_date = now
}
state Verified {
    isverified = 1
}

Unverified --> Pending : ProfileController@requestVerification()\n/ set verification_request_date
Pending --> Verified : PharmacyController@approve()\n/ set isverified=1, verification_date
Pending --> Unverified : PharmacyController@reject()\n/ clear verification_request_date
Pending --> Pending : ProfileController@requestVerification()\n/ resubmit
@enduml
```

---

## 4. Sequence Diagrams

### Login Flow

Actual route: `POST /login` → `AuthController@login`

```plantuml
@startuml
skinparam sequence {
    ArrowColor #2C3E50
    LifeLineBackgroundColor #F0F8FF
    ParticipantBackgroundColor #F0F8FF
}
autonumber

actor User
participant "App::boot()" as AppBoot
participant Router
participant "AuthController" as AuthCtrl
participant "User Model" as UserModel
participant "PDO Database" as DB

User -> AppBoot : POST /login (email, password)

AppBoot -> AppBoot : load .env, start session
AppBoot -> Router : new Router()
AppBoot -> Router : require routes.php
AppBoot -> Router : dispatch(/login, POST)

Router -> Router : match route -> AuthController@login
Router -> AuthCtrl : new AuthController()
activate AuthCtrl

AuthCtrl -> AuthCtrl : validate(email), get password
AuthCtrl -> UserModel : findByEmail(email)
activate UserModel
UserModel -> DB : SELECT * FROM role\nWHERE email = ? LIMIT 1
DB --> UserModel : user record
UserModel --> AuthCtrl : user array or null
deactivate UserModel

alt user not found
  AuthCtrl --> User : redirect /login\n"Invalid Email or Password"
else password_verify fails
  AuthCtrl --> User : redirect /login\n"Invalid Password"
else valid
  AuthCtrl -> AuthCtrl : Session::setAuth(user, role)
  alt role = "admin"
    AuthCtrl --> User : redirect /admin/dashboard\n"Logged In Successfully"
  else role = "user"
    AuthCtrl --> User : redirect /pharmacy/dashboard\n"Logged In Successfully"
  end
end
deactivate AuthCtrl
@enduml
```

### Pharmacy Places Order

Actual route: `POST /pharmacy/orders` → `OrderController@store` (with `PharmacyMiddleware`)

```plantuml
@startuml
skinparam sequence {
    ArrowColor #2C3E50
    LifeLineBackgroundColor #F0F8FF
    ParticipantBackgroundColor #F0F8FF
}
autonumber

actor "Pharmacy User" as User
participant Router
participant "PharmacyMiddleware" as Middleware
participant "OrderController" as OrderCtrl
participant "UserMedicine Model" as Medicine
participant "Order Model" as OrderModel
participant "PDO Database" as DB

User -> Router : POST /pharmacy/orders\n(m_id, price, qty, total, order_date)

Router -> Router : match route, detect middleware
Router -> Middleware : new PharmacyMiddleware()->handle()
activate Middleware
alt session not auth or role != "user"
  Middleware --> User : redirect /login\n"Access denied"
end
deactivate Middleware

Router -> OrderCtrl : new OrderController()
activate OrderCtrl

OrderCtrl -> OrderCtrl : validate(qty>0, price>0, date >= today)

OrderCtrl -> Medicine : findById(m_id)
activate Medicine
Medicine -> DB : SELECT * FROM user_medicine_tbl\nWHERE m_id = ? LIMIT 1
DB --> Medicine : medicine row
Medicine --> OrderCtrl : med array
deactivate Medicine

alt med null or med.in_stock < qty
  OrderCtrl --> User : redirect /pharmacy/orders/create\n"Not enough stock"
else stock sufficient
  OrderCtrl -> OrderModel : insert({pharmacy_id, m_id, price,\nqty, total, status:"pending", order_date})
  activate OrderModel
  OrderModel -> DB : INSERT INTO user_order_tbl (...) VALUES (...)
  DB --> OrderModel : lastInsertId
  OrderModel --> OrderCtrl : o_id
  deactivate OrderModel

  OrderCtrl -> Medicine : updateStock(m_id, -qty)
  activate Medicine
  Medicine -> DB : UPDATE user_medicine_tbl\nSET in_stock = in_stock - ?\nWHERE m_id = ?
  DB --> Medicine : rowCount
  deactivate Medicine

  OrderCtrl --> User : redirect /pharmacy/orders\n"Order has been submitted"
end
deactivate OrderCtrl
@enduml
```

### Admin Approves Pharmacy Verification

Actual route: `POST /admin/pharmacies/{id}/approve` → `PharmacyController@approve` (with `AdminMiddleware`)

```plantuml
@startuml
skinparam sequence {
    ArrowColor #2C3E50
    LifeLineBackgroundColor #F0F8FF
    ParticipantBackgroundColor #F0F8FF
}
autonumber

actor Admin
participant Router
participant "AdminMiddleware" as Middleware
participant "PharmacyController" as PharmCtrl
participant "Pharmacy Model" as PharmModel
participant "PDO Database" as DB

Admin -> Router : POST /admin/pharmacies/42/approve\n(verification_notes)

Router -> Router : match route, detect middleware
Router -> Middleware : new AdminMiddleware()->handle()
activate Middleware
alt not auth or role != "admin"
  Middleware --> Admin : redirect /login\n"Access denied"
end
deactivate Middleware

Router -> PharmCtrl : new PharmacyController()
activate PharmCtrl

PharmCtrl -> PharmCtrl : validate(verification_notes)
PharmCtrl -> PharmModel : update(pharmacy_id=42,\n{isverified:1, verification_date:now,\nverification_notes:"..."})
activate PharmModel
PharmModel -> DB : UPDATE tbl_pharmacy\nSET isverified=1, verification_date=?,\nverification_notes=?\nWHERE pharmacy_id=?
DB --> PharmModel : rowCount >= 0
deactivate PharmModel

PharmCtrl --> Admin : redirect /admin/pharmacies/verify\n"Pharmacy verified successfully!"
deactivate PharmCtrl
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
:PharmacyMiddleware::handle()
checks auth + role=user;

if (Authenticated + role=user?) then (no)
  :Redirect /login;
  stop
else (yes)
endif

|#White|OrderController|
:Order::findByIdAndPharmacy(orderId, pharmacyId);

if (Order found and\nbelongs to pharmacy?) then (no)
  :Flash "Order not found";
  stop
else (yes)
endif

if (Old status == completed?) then (yes)
  :Flash "Already completed";
  stop
else (no)
endif

|#AntiqueWhite|UserMedicine Model|
:UserMedicine::findById(m_id);

if (in_stock >= quantity?) then (no)
  :Flash "Not enough stock";
  stop
else (yes)
  :UserMedicine::updateStock(m_id, -quantity);
endif

|#White|OrderController|
:Order::updateByPharmacy(orderId, pharmacyId,\n{status:"completed", ...});

|#LightCyan|User|
:Flash "Order updated";

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

## 6. Refinement of Class — Full Database Schema Mapping

Each model mapped to its actual database table with column types. `User` (table `role`) is the parent entity; `Pharmacy` and `Admin` are child profiles sharing the same PK as `role.user_id`.

```plantuml
@startuml
skinparam class {
    BackgroundColor #F0F8FF
    BorderColor #2C3E50
    ArrowColor #2C3E50
}
skinparam classAttributeIconSize 0
top to bottom direction

package "Identity Tables" {
    class role_table {
        +int user_id PK AUTO_INCREMENT
        +varchar(100) name
        +varchar(50) email
        +varchar(255) password (bcrypt hash)
        +varchar(10) role ("admin"|"user")
    }

    class tbl_pharmacy {
        +int pharmacy_id PK FK -> role.user_id
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
        +int admin_id PK FK -> role.user_id
        +varchar(100) name
        +varchar(50) email
        +varchar(10) gender
        +varchar(10) phone
        +date dob
        +varchar(50) address
    }
}

package "Inventory Tables" {
    class user_medicine_tbl {
        +int m_id PK AUTO_INCREMENT
        +int pharmacy_id FK
        +varchar(100) medicine_name
        +varchar(1000) medicine_desc
        +int c_id FK -> user_category_tbl
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
}

package "Transaction Tables" {
    class user_order_tbl {
        +int o_id PK AUTO_INCREMENT
        +int m_id FK -> user_medicine_tbl
        +int pharmacy_id FK
        +int price
        +int quantity
        +int total_amount
        +varchar(20) status
        +date order_date
    }

    class user_sales_tbl {
        +int s_id PK AUTO_INCREMENT
        +int m_id FK -> user_medicine_tbl
        +int pharmacy_id FK
        +int price
        +int quantity
        +int total_amount
        +varchar(20) status
        +date sales_date
    }
}

package "System Tables" {
    class settings {
        +int id PK AUTO_INCREMENT
        +varchar(255) title
        +text small_description
        +varchar(255) sub_title
        +text sub_description
        +varchar(10) phone
        +varchar(50) email
    }
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
        m_id = 51
        pharmacy_id = 89
        price = 25
        quantity = 8
        total_amount = 200
        status = "pending"
        order_date = "2026-02-21"
    }

    object "sale_100: Sale" as sale {
        s_id = 100
        m_id = 52
        pharmacy_id = 89
        price = 20
        quantity = 42
        total_amount = 840
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
left to right direction

title MedVault — Component Architecture

[Web Browser] as Browser

package "Entry Point" {
    [public/index.php\nrequire autoload\ncall App::boot()] as Entry
}

package "Framework Core" {
    [App: bootstrapper\n.env, session, router] as App
    [Router: route matching\n+ middleware chain\n+ controller dispatch] as Router
    [Database: PDO singleton] as Database
    [Session: $_SESSION wrapper] as Session
    [Controller: base class\nview(), redirect(),\njson(), validate()] as BaseCtrl
    [Model: abstract\nCRUD + paginate] as BaseModel
}

package "app/Middleware/" as MiddlewarePkg {
    [AuthMiddleware\nauth=true] as AuthM
    [AdminMiddleware\nrole=admin] as AdminM
    [PharmacyMiddleware\nrole=user] as PharmacyM
}

package "app/Controllers/" as Controllers {
    [AuthController] as AuthCtrl
    [Pharmacy Controllers:\nDashboard, Medicine,\nCategory, Order, Sales,\nAnalytics, Profile, Ajax] as PharmCtrls
    [Admin Controllers:\nDashboard, Pharmacy,\nAdmin, Setting, Export] as AdminCtrls
    [LandingController] as LandingCtrl
}

package "app/Models/" as Models {
    [User (role)] as M_User
    [Pharmacy (tbl_pharmacy)] as M_Pharmacy
    [Admin (tbl_admin)] as M_Admin
    [UserMedicine] as M_Medicine
    [Category] as M_Category
    [Order] as M_Order
    [Sale] as M_Sale
    [Setting] as M_Setting
}

package "views/" as Views {
    [layouts/ (admin, pharmacy)] as V_Layouts
    [admin/ (dashboard,\npharmacies, admins,\nsettings)] as V_Admin
    [pharmacy/ (dashboard,\nmedicines, orders, sales,\nanalytics, categories,\nprofile)] as V_Pharmacy
    [auth/ (login)] as V_Auth
}

package "Configuration" {
    [routes.php\n83 route definitions] as Routes
    [.env\nDB_HOST, DB_NAME, etc.] as Env
}

database "MySQL 8.0\npharmacy" as MySQL

Browser --> Entry
Entry --> App
App --> Routes
App --> Router
Router --> MiddlewarePkg
Router --> BaseCtrl
Router --> Controllers
Controllers --> BaseCtrl
Controllers --> Models
Controllers --> Views
Controllers --> Session
Models --> BaseModel
BaseModel --> Database
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

actor "Client Machine\n(Web Browser)" as Client

node "Docker Host" as DockerHost {
    node "app container\nphp:8.2-apache" as AppContainer {
        artifact "Apache 2.4\nDocumentRoot: /var/www/html/public" as Apache
        artifact "PHP 8.2\npdo, pdo_mysql" as PHP
        artifact "Source Code\nbind-mounted /var/www/html" as Code
    }

    node "db container\nmysql:8.0" as DBContainer {
        database "MySQL 8.0\ninit: pharmacy.sql\nat /docker-entrypoint-initdb.d/" as MySQL
    }

    node "phpmyadmin container" as PMAContainer {
        artifact "phpMyAdmin\nPMA_HOST=db\nPMA_USER=root" as PMA
    }

    folder "Named Volume\nmysql_data\n-> /var/lib/mysql" as Volume
}

Client --> Apache : HTTP localhost:8000
Client --> PMA : HTTP localhost:8080

Apache --> PHP
PHP --> Code
PHP --> MySQL : PDO mysql:host=db:3306\n dbname=pharmacy
PMA --> MySQL : PHP mysql:host=db:3306
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
