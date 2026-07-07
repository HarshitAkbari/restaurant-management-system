# Product Requirements Document: Restaurant Management System

## Executive Summary

The Restaurant Management System (RMS) is a Petpooja-style platform for running restaurant operations end-to-end: menu management, POS billing, table service, kitchen order tickets (KOT), inventory, staff management, and reporting. The system is built on **Laravel 10** with the GetSkills admin theme as the UI shell.

**Core surfaces:**

| Surface | Route prefix | Purpose |
|---------|--------------|---------|
| Admin back-office | `/admin/*` | Menu, inventory, staff, reports, settings |
| POS | `/pos/*` | In-restaurant billing, tables, KOT, order flow |
| REST API | `/api/v1/*` | POS tablets, captain/waiter apps, online ordering (later) |

**Core value proposition:**

- Single platform for dine-in, takeaway, and delivery orders
- Real-time menu and stock availability across POS and online channels
- Role-based staff access to prevent fraud and unauthorized changes
- Recipe-based inventory deduction tied to orders
- GST/tax-aware billing with multiple payment methods
- Scalable from single-outlet MVP to multi-outlet and aggregator integrations

**Default configuration** (from `config/restaurant.php`):

- Currency: `INR`
- Timezone: `Asia/Kolkata`

---

## User Roles

| Role | Description | Primary surfaces |
|------|-------------|------------------|
| **Owner** | Full access; restaurant profile, tax, outlets, staff, reports | Admin, POS |
| **Manager** | Day-to-day operations; menu, inventory, staff (limited), reports | Admin, POS |
| **Cashier** | Billing, payments, order voids (with limits), day settlement | POS, Admin (orders) |
| **Waiter / Captain** | Table assignment, order taking, KOT trigger | POS (tablet/API) |
| **Kitchen** | View and update KOT status | POS kitchen display / API |
| **Customer** *(Phase 3)* | Online ordering, order tracking | API only |

---

## Phased Delivery

### Phase 1 — MVP

Minimum viable restaurant: take orders, send KOT, bill customers, view dashboard.

- Auth & roles (basic)
- Restaurant settings (profile, tax, payment methods)
- Menu (categories, items, variants, add-ons)
- Areas & tables
- POS billing (dine-in / takeaway / delivery)
- Orders lifecycle
- KOT / kitchen display
- Admin dashboard (basic metrics)

### Phase 2 — Operations

- Inventory (raw materials, recipes, purchase orders, suppliers, low-stock alerts)
- Staff management (employees, roles & permissions)
- Customers / CRM (customer list, order history)
- Discounts & coupons
- Reports (sales, items, tax/GST, staff)
- Day close / settlement

### Phase 3 — Growth

- Online ordering API (public menu, place order, track)
- QR / digital menu
- Multi-outlet management
- Aggregator sync (Zomato, Swiggy — integration layer)
- Loyalty program
- Advanced analytics

---

## User Stories

### Owner (Phase 1–3)

- As an **owner**, I want to configure my restaurant profile, tax rates, and payment methods so billing is accurate.
- As an **owner**, I want to define menu categories, items, variants, and add-ons so staff can sell consistently priced dishes.
- As an **owner**, I want to assign roles to staff so each person only sees what they need.
- As an **owner**, I want sales and tax reports so I can understand business performance.
- As an **owner**, I want to manage multiple outlets from one dashboard *(Phase 3)*.

### Manager (Phase 1–2)

- As a **manager**, I want to update menu availability when items run out so customers are not sold unavailable dishes.
- As a **manager**, I want to configure dining areas and tables so waiters can assign orders correctly.
- As a **manager**, I want to view live and historical orders so I can resolve issues quickly.
- As a **manager**, I want inventory alerts and purchase orders so stock does not run out *(Phase 2)*.

### Cashier (Phase 1–2)

- As a **cashier**, I want to create orders, apply discounts, split bills, and accept payments so service is fast at the counter.
- As a **cashier**, I want to void or cancel orders within policy limits so mistakes can be corrected.
- As a **cashier**, I want to run day-close settlement so cash and card totals reconcile *(Phase 2)*.

### Waiter / Captain (Phase 1)

- As a **waiter**, I want to select a table and add items to an order from a tablet so I do not need to walk to the counter.
- As a **waiter**, I want to send items to the kitchen (KOT) so cooking starts immediately.

### Kitchen staff (Phase 1)

- As **kitchen staff**, I want to see pending KOTs by station so I know what to prepare next.
- As **kitchen staff**, I want to mark items as ready so waiters and cashiers are notified.

### Customer *(Phase 3)*

- As a **customer**, I want to browse the menu and place an order online so I can order without calling.
- As a **customer**, I want to track my order status so I know when food is ready.

---

## Module Overview

### Menu Management *(Phase 1)*

Categories, items, variants (e.g. size), add-ons (extra cheese), and combos. Items support base price, tax category, veg/non-veg flag, and availability toggle (manual or stock-linked in Phase 2).

### Areas & Tables *(Phase 1)*

Dining areas (e.g. AC Hall, Terrace) with configurable tables, capacity, and status (available, occupied, reserved, billing).

### Orders & POS Billing *(Phase 1)*

Order types: dine-in, takeaway, delivery. Order lifecycle: draft → confirmed → preparing → ready → served → billed → paid → completed (or cancelled/voided). Support hold/park orders, item-level notes, and split payments.

### KOT / Kitchen Display *(Phase 1)*

Kitchen Order Tickets generated when items are sent to kitchen. Routed by cooking station (e.g. main kitchen, bar, tandoor). Status: pending → preparing → ready.

### Inventory *(Phase 2)*

Raw materials, units, recipes (item → ingredients), automatic stock deduction on order completion, purchase orders, suppliers, low-stock alerts.

### Staff & Roles *(Phase 2)*

Employee records linked to user accounts. Role-based permissions per module (read / write / none). Audit log for sensitive actions (voids, discounts, day close).

### Customers / CRM *(Phase 2)*

Customer profiles (name, phone, email), order history, optional loyalty points.

### Reports *(Phase 2)*

Sales summary, item-wise sales, tax/GST breakdown, payment method summary, staff performance, inventory consumption.

### Online Ordering *(Phase 3)*

Public menu API, cart/checkout, order placement, status tracking, optional OTP customer auth.

---

## Data Schema (High-Level)

### Phase 1 Tables

#### `restaurants`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `name` | string | Restaurant name |
| `address` | text | Full address |
| `phone` | string | Contact phone |
| `email` | string | Contact email |
| `gstin` | string, nullable | GST registration number |
| `currency` | string | Default `INR` |
| `timezone` | string | Default `Asia/Kolkata` |
| `logo_path` | string, nullable | Logo image path |
| `is_active` | boolean | Active flag |
| `created_at`, `updated_at` | timestamp | Audit |

#### `roles` / `permissions` *(or Spatie package)*

Standard RBAC: roles (owner, manager, cashier, waiter, kitchen) with module-level permissions.

#### `menu_categories`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `restaurant_id` | bigint | FK → restaurants |
| `name` | string | Category name (e.g. Starters) |
| `sort_order` | int | Display order |
| `is_active` | boolean | Visible on POS/menu |
| `created_at`, `updated_at`, `deleted_at` | timestamp | Soft delete |

#### `menu_items`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `category_id` | bigint | FK → menu_categories |
| `name` | string | Item name |
| `description` | text, nullable | Item description |
| `base_price` | decimal(10,2) | Base selling price |
| `tax_rate` | decimal(5,2) | Tax percentage |
| `is_veg` | boolean | Vegetarian flag |
| `is_available` | boolean | Available for sale |
| `image_path` | string, nullable | Item image |
| `sort_order` | int | Display order |
| `created_at`, `updated_at`, `deleted_at` | timestamp | Soft delete |

#### `menu_item_variants`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `menu_item_id` | bigint | FK → menu_items |
| `name` | string | e.g. Small, Medium, Large |
| `price` | decimal(10,2) | Variant price |
| `is_default` | boolean | Default selection |
| `is_available` | boolean | Available flag |

#### `menu_addons` / `menu_item_addon` *(pivot)*

Add-on groups (e.g. Extra toppings) with optional/min/max selection rules.

#### `areas`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `restaurant_id` | bigint | FK → restaurants |
| `name` | string | Area name |
| `sort_order` | int | Display order |
| `is_active` | boolean | Active flag |

#### `tables`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `area_id` | bigint | FK → areas |
| `name` | string | Table number/name |
| `capacity` | int | Seat count |
| `status` | enum | available, occupied, reserved, billing |
| `sort_order` | int | Layout order |

#### `orders`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `restaurant_id` | bigint | FK → restaurants |
| `order_number` | string | Human-readable order ID |
| `order_type` | enum | dine_in, takeaway, delivery |
| `table_id` | bigint, nullable | FK → tables |
| `customer_name` | string, nullable | Walk-in customer name |
| `customer_phone` | string, nullable | Customer phone |
| `status` | enum | draft, confirmed, preparing, ready, served, billed, paid, completed, cancelled, voided |
| `subtotal` | decimal(10,2) | Before tax/discount |
| `tax_amount` | decimal(10,2) | Total tax |
| `discount_amount` | decimal(10,2) | Total discount |
| `total_amount` | decimal(10,2) | Final amount |
| `notes` | text, nullable | Order notes |
| `created_by` | bigint | FK → users |
| `assigned_to` | bigint, nullable | Waiter/cashier |
| `created_at`, `updated_at`, `deleted_at` | timestamp | Soft delete |

#### `order_items`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `order_id` | bigint | FK → orders |
| `menu_item_id` | bigint | FK → menu_items |
| `variant_id` | bigint, nullable | FK → menu_item_variants |
| `quantity` | int | Quantity ordered |
| `unit_price` | decimal(10,2) | Price at time of order |
| `tax_amount` | decimal(10,2) | Line tax |
| `total_price` | decimal(10,2) | Line total |
| `notes` | string, nullable | Item notes (e.g. less spicy) |
| `kot_status` | enum | pending, sent, preparing, ready, served |
| `kot_sent_at` | timestamp, nullable | When sent to kitchen |

#### `order_item_addons` *(pivot)*

Links order items to selected add-ons with price snapshot.

#### `kots`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `order_id` | bigint | FK → orders |
| `kot_number` | string | KOT reference |
| `station` | string | Kitchen station |
| `status` | enum | pending, preparing, ready, cancelled |
| `printed_at` | timestamp, nullable | Print timestamp |
| `created_at`, `updated_at` | timestamp | Audit |

#### `payments`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `order_id` | bigint | FK → orders |
| `method` | enum | cash, card, upi, other |
| `amount` | decimal(10,2) | Payment amount |
| `reference` | string, nullable | Transaction reference |
| `received_by` | bigint | FK → users |
| `created_at` | timestamp | Payment time |

### Phase 2 Tables (summary)

- `raw_materials`, `recipes`, `recipe_ingredients` — inventory & recipe management
- `purchase_orders`, `purchase_order_items`, `suppliers` — procurement
- `stock_movements` — audit trail for stock in/out
- `customers` — CRM profiles (may extend walk-in fields on orders)
- `discounts`, `coupons` — promotional rules
- `day_closes` — end-of-day settlement records
- `audit_logs` — sensitive action tracking

### Phase 3 Tables (summary)

- `outlets` — multi-outlet hierarchy
- `online_orders` — channel-specific metadata
- `aggregator_mappings` — external platform item/order IDs
- `loyalty_transactions` — points earn/redeem

---

## Functional Requirements

### FR-1: Authentication & Authorization *(Phase 1)*

**FR-1.1**: Staff can log in via email/phone + password on web (admin, POS) and API (tablet apps).

**FR-1.2**: API uses Laravel Sanctum bearer tokens; tokens are revoked on logout.

**FR-1.3**: Each request is scoped to the staff member's restaurant (single-outlet in Phase 1).

**FR-1.4**: Role-based middleware gates admin routes, POS actions, and API endpoints.

**FR-1.5**: Inactive staff accounts cannot authenticate.

### FR-2: Menu Management *(Phase 1)*

**FR-2.1**: Manager/Owner can CRUD menu categories with sort order and active flag.

**FR-2.2**: Manager/Owner can CRUD menu items under categories with price, tax, veg flag, and image.

**FR-2.3**: Items support multiple variants; exactly one variant may be marked default.

**FR-2.4**: Items support add-on groups with min/max selection constraints.

**FR-2.5**: Toggling `is_available = false` hides item from POS and API menu responses.

**FR-2.6**: Soft delete preserves historical order references.

### FR-3: Areas & Tables *(Phase 1)*

**FR-3.1**: Manager can CRUD areas and tables with capacity and sort order.

**FR-3.2**: Table status updates automatically when order is assigned (occupied) and when bill is settled (available).

**FR-3.3**: POS displays tables grouped by area with color-coded status.

### FR-4: Orders & POS Billing *(Phase 1)*

**FR-4.1**: Cashier/Waiter can create orders with type dine-in, takeaway, or delivery.

**FR-4.2**: Dine-in orders require table selection; takeaway/delivery require customer name/phone (optional in MVP).

**FR-4.3**: Staff can add, update quantity, and remove line items on draft/confirmed orders.

**FR-4.4**: Order totals recalculate automatically: subtotal + tax − discount = total.

**FR-4.5**: Staff can send items to kitchen, generating KOT records.

**FR-4.6**: Staff can hold/park orders and resume later.

**FR-4.7**: Cashier can settle bill with one or more payment methods (split payment).

**FR-4.8**: Void/cancel requires manager approval or role permission; void reason is recorded.

**FR-4.9**: Completed orders are immutable except for admin audit corrections.

### FR-5: KOT / Kitchen Display *(Phase 1)*

**FR-5.1**: Sending items to kitchen creates KOT grouped by station.

**FR-5.2**: Kitchen display shows pending KOTs sorted by creation time.

**FR-5.3**: Kitchen staff can mark KOT or individual items as preparing/ready.

**FR-5.4**: KOT can be printed to station-assigned printers *(configuration in settings)*.

### FR-6: Dashboard *(Phase 1)*

**FR-6.1**: Admin dashboard shows today's order count, revenue, and active tables.

**FR-6.2**: Metrics respect restaurant timezone (`Asia/Kolkata` default).

### FR-7: Inventory *(Phase 2)*

**FR-7.1**: Manager can define raw materials with unit and current stock.

**FR-7.2**: Recipes link menu items to ingredient quantities; completing an order deducts stock.

**FR-7.3**: Low-stock alerts when quantity falls below threshold.

**FR-7.4**: Purchase orders can be created, received, and linked to suppliers.

**FR-7.5**: Unavailable stock can auto-disable menu items (`is_available`).

### FR-8: Staff Management *(Phase 2)*

**FR-8.1**: Owner/Manager can create staff accounts with assigned roles.

**FR-8.2**: Permissions are configurable per role per module (read/write/none).

**FR-8.3**: Staff deactivation immediately revokes access.

### FR-9: Customers / CRM *(Phase 2)*

**FR-9.1**: Customer record created or matched by phone on order.

**FR-9.2**: Customer order history viewable in admin.

### FR-10: Discounts *(Phase 2)*

**FR-10.1**: Percentage or flat discounts applicable at order or item level.

**FR-10.2**: Coupon codes with validity window and usage limits.

**FR-10.3**: Discount above threshold requires manager PIN/approval.

### FR-11: Reports *(Phase 2)*

**FR-11.1**: Sales report by date range with payment method breakdown.

**FR-11.2**: Item-wise sales report (quantity and revenue).

**FR-11.3**: Tax/GST report for compliance.

**FR-11.4**: Reports exportable to CSV.

### FR-12: Day Close *(Phase 2)*

**FR-12.1**: Cashier runs day close summarizing cash, card, UPI totals vs. system records.

**FR-12.2**: Day close locks further edits to that business day's settled orders.

### FR-13: Online Ordering *(Phase 3)*

**FR-13.1**: Public API returns active menu for online channel.

**FR-13.2**: Customers place orders with delivery/pickup type.

**FR-13.3**: Order status updates propagate to customer tracking endpoint.

### FR-14: Multi-Outlet *(Phase 3)*

**FR-14.1**: Owner manages multiple outlets under one account.

**FR-14.2**: Menu can be outlet-specific or shared from central kitchen.

---

## Technical Implementation

### Route Files

| File | Prefix | Purpose |
|------|--------|---------|
| `routes/admin.php` | `/admin` | Back-office web routes |
| `routes/pos.php` | `/pos` | POS web routes |
| `routes/api.php` | `/api/v1` | REST API for apps & integrations |
| `routes/web.php` | `/` | GetSkills theme demos (unchanged) |

Registered in `app/Providers/RouteServiceProvider.php`.

### Folder Structure (target)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # MenuController, OrderController, etc.
│   │   ├── Pos/            # BillingController, KitchenController, etc.
│   │   └── Api/V1/         # REST API controllers
│   ├── Requests/           # Form request validation
│   └── Resources/          # API transformers
├── Services/               # OrderService, MenuService, KotService, etc.
├── Repositories/
│   ├── Contracts/
│   └── Eloquent/
├── Enums/                  # OrderStatus, PaymentMethod, TableStatus, etc.
└── Models/                 # MenuItem, Order, Table, Kot, etc.

resources/views/
├── getskills/              # Theme demos (reference)
└── restaurant/
    ├── admin/              # Admin Blade views
    ├── pos/                # POS Blade views
    └── components/         # Shared components
```

### Admin Sidebar

**File:** `resources/views/restaurant/admin/elements/sidebar.blade.php`

Menu items and role gates are defined in [menus-and-navigation.md](menus-and-navigation.md).

### API Documentation

Master API reference: [docs/api.md](../docs/api.md)

Per-endpoint Postman docs will be added under `docs/{feature}/` when endpoints are implemented.

### Web Admin Routes (planned)

```
GET    /admin                          - Dashboard
GET    /admin/orders                   - Order list
GET    /admin/orders/{id}              - Order detail
GET    /admin/menu/categories          - Category list
POST   /admin/menu/categories          - Create category
GET    /admin/menu/items               - Item list
POST   /admin/menu/items               - Create item
GET    /admin/tables/areas             - Area list
GET    /admin/tables                   - Table list
GET    /admin/settings                 - Restaurant settings
POST   /admin/settings                 - Update settings
```

### POS Routes (planned)

```
GET    /pos                            - POS home / new order
GET    /pos/tables                     - Table view
GET    /pos/orders                     - Active orders
GET    /pos/orders/{id}                - Order detail / billing
GET    /pos/kitchen                    - Kitchen display
GET    /pos/hold                       - Held orders
GET    /pos/day-close                  - Day settlement (Phase 2)
```

### API Routes (planned)

See [docs/api.md](../docs/api.md) for the full endpoint specification.

---

## Business Rules

### Order Rules

1. Only draft/confirmed orders can have items added or removed.
2. KOT is generated only for items not yet sent to kitchen.
3. Bill settlement requires at least one payment record totaling the order amount.
4. Voided orders do not count toward revenue reports.
5. Order numbers are unique per restaurant per day (e.g. `ORD-20260707-001`).

### Menu Rules

1. Inactive categories hide all child items from POS/API.
2. Variant price overrides base price when variant is selected.
3. Add-on prices are additive to line item total.

### Table Rules

1. One active dine-in order per table at a time.
2. Table status `billing` indicates bill printed but not yet paid.

### Inventory Rules *(Phase 2)*

1. Stock cannot go negative unless outlet allows backorder (configurable).
2. Recipe deduction occurs on order completion (paid status).

### Security Rules

1. All admin and POS routes require authentication.
2. API endpoints require Sanctum token except public online menu *(Phase 3)*.
3. Sensitive actions (void, large discount, day close) require elevated role or PIN.

---

## Phased Delivery Roadmap

### Phase 1 Checklist

- [ ] Staff auth (web + API login/logout)
- [ ] Basic roles (owner, manager, cashier, waiter, kitchen)
- [ ] Restaurant settings (profile, tax, payment methods)
- [ ] Menu CRUD (categories, items, variants, add-ons)
- [ ] Areas & tables CRUD
- [ ] POS order creation and item management
- [ ] KOT generation and kitchen display
- [ ] Payment settlement
- [ ] Admin dashboard (basic)
- [ ] Order history in admin

### Phase 2 Checklist

- [ ] Inventory (materials, recipes, POs, suppliers)
- [ ] Stock deduction on order completion
- [ ] Staff management UI
- [ ] Customer CRM
- [ ] Discounts and coupons
- [ ] Reports (sales, items, tax)
- [ ] Day close / settlement
- [ ] Audit log for sensitive actions

### Phase 3 Checklist

- [ ] Online ordering API
- [ ] QR / digital menu
- [ ] Multi-outlet support
- [ ] Aggregator integration layer
- [ ] Loyalty program
- [ ] Advanced analytics dashboard

---

## Future Enhancements

1. **Captain ordering app** — dedicated mobile app for waiters
2. **Token display system** — queue numbers for takeaway
3. **Feedback / QR rating** — post-meal customer feedback
4. **Central kitchen module** — supply inventory across outlets
5. **Offline POS mode** — sync when connection restored
6. **WhatsApp bill / notification** — send e-bill to customer

---

**Document Version:** 1.0  
**Last Updated:** July 2026  
**Status:** Active — specification for implementation
