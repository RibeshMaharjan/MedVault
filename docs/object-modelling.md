# Object Modelling — Class & Object Diagrams

MedVault's domain layer is built around eight model classes that all inherit from a single abstract base, `App\Core\Model`. The base class encapsulates generic CRUD behaviour against a PDO connection, while each concrete model binds itself to a database table and adds domain-specific query methods (pharmacy-scoped lookups, pagination, analytics). The diagrams below capture this **static structure** (class diagram) and a **single runtime snapshot** of how instances of these classes relate during a day of operation at one pharmacy (object diagram).

---

## Class Diagram

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
        +findById(id, idCol) array
        +findAllBy(col, value) array
        +findOneBy(col, value) array
        +count(conditions, params) int
        +insert(data) int
        +update(id, data, idCol) bool
        +delete(id, idCol) bool
        +paginate(page, perPage, conditions, params) array
        #query(sql, params) PDOStatement
    }

    class Admin {
        #table = "tbl_admin"
        #primaryKey = "admin_id"
    }

    class Pharmacy {
        #table = "tbl_pharmacy"
        #primaryKey = "pharmacy_id"
        +createMinimal(pharmacyId, name, email) bool
    }

    class User {
        #table = "role"
        #primaryKey = "user_id"
        +findByEmail(email) array
        +create(name, email, passwordHash, role) int
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
        +findByIdAndPharmacy(orderId, pharmacyId) array
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
        +findByIdAndPharmacy(saleId, pharmacyId) array
        +deleteByPharmacy(saleId, pharmacyId) bool
        +updateByPharmacy(saleId, pharmacyId, data) bool
        +getSalesData(pharmacyId, start, end) array
    }

    class Setting {
        #table = "settings"
        #primaryKey = "id"
    }

    Model <|-- Admin
    Model <|-- Pharmacy
    Model <|-- User
    Model <|-- Category
    Model <|-- UserMedicine
    Model <|-- Order
    Model <|-- Sale
    Model <|-- Setting

    Pharmacy "1" *-- "0..*" Category : owns
    Pharmacy "1" *-- "0..*" UserMedicine : stocks
    Pharmacy "1" *-- "0..*" Order : receives
    Pharmacy "1" *-- "0..*" Sale : records
    Category "1" o-- "0..*" UserMedicine : classifies
    UserMedicine "1" -- "0..*" Order : ordered_as
    UserMedicine "1" -- "0..*" Sale : sold_as
```

### Legend

| Arrow | Meaning |
|---|---|
| `<|--` | Generalisation (inheritance) — concrete model extends the abstract `Model` |
| `*--` | Composition — the part cannot exist without the whole (every record is `pharmacy_id`-scoped) |
| `o--` | Aggregation — the whole groups the parts, but the parts outlive the grouping |
| `--` | Association — referenced via foreign key but loosely coupled |
| `"1" / "0..*"` | Multiplicity — exactly one on the owning side, zero or more on the owned side |

---

## Object Diagram

> **Note on syntax:** Mermaid has no dedicated object-diagram primitive, so we reuse `classDiagram` with **instance-style labels** (`p1 : Pharmacy`) and fill the bodies with concrete attribute values instead of types. This is the standard UML object-diagram convention rendered in Mermaid.

**Scenario — "HealthFirst Pharmacy, mid-day snapshot":** A single pharmacy with one active category (`Antibiotics`) and two medicines on the shelf. One pending wholesale order has been placed to restock Amoxicillin, and a completed retail sale has just gone through for Azithromycin.

```mermaid
classDiagram
    direction TB

    class p1 {
        <<Pharmacy>>
        pharmacy_id = 1
        name = "HealthFirst"
        email = "ops@healthfirst.np"
    }

    class c1 {
        <<Category>>
        c_id = 10
        pharmacy_id = 1
        name = "Antibiotics"
    }

    class m1 {
        <<UserMedicine>>
        m_id = 101
        pharmacy_id = 1
        c_id = 10
        medicine_name = "Amoxicillin 500mg"
        in_stock = 48
    }

    class m2 {
        <<UserMedicine>>
        m_id = 102
        pharmacy_id = 1
        c_id = 10
        medicine_name = "Azithromycin 250mg"
        in_stock = 20
    }

    class o1 {
        <<Order>>
        o_id = 501
        pharmacy_id = 1
        m_id = 101
        quantity = 50
        status = "pending"
        total_amount = 4500
        order_date = "2026-05-21"
    }

    class s1 {
        <<Sale>>
        s_id = 701
        pharmacy_id = 1
        m_id = 102
        quantity = 2
        status = "completed"
        total_amount = 180
        sales_date = "2026-05-21"
    }

    p1 -- c1 : owns
    p1 -- m1 : stocks
    p1 -- m2 : stocks
    c1 -- m1 : classifies
    c1 -- m2 : classifies
    m1 -- o1 : ordered_as
    m2 -- s1 : sold_as
```

---

## Notes

- **Multi-tenancy by `pharmacy_id`.** Every domain record except `User`, `Admin`, and `Setting` carries a `pharmacy_id`, and every query method on the concrete models filters by it. This is why `Pharmacy` composes the other entities rather than merely associating with them — a `Category` or `Order` row is meaningless without its owning pharmacy.
- **Active-record pattern.** All persistence behaviour lives on the model itself; there are no separate repositories. The abstract `Model` provides `findAll`, `findById`, `insert`, `update`, `delete`, `paginate`, and friends, and concrete models add domain-specific query helpers on top.
- **`Setting`, `User`, and `Admin` are standalone in the class diagram.** They have no foreign-key associations with the domain entities. `User` carries a `role` discriminator (`admin` / `user`) that is read at runtime to select which dashboard a session is sent to, but this is a runtime decision rather than a structural class-level relationship — see the *Authentication Session* state diagram in [dynamic-modelling.md](./dynamic-modelling.md) for that view.
