# Restaurant Management System — API Documentation

## Table of Contents

- [API Overview](#api-overview)
- [Authentication](#authentication)
- [Common Headers](#common-headers)
- [Rate Limiting](#rate-limiting)
- [Error Responses](#error-responses)
- [Pagination](#pagination)
- [Endpoints](#endpoints)
  - [Authentication](#authentication-endpoints) *(Phase 1)*
  - [Menu](#menu-endpoints) *(Phase 1)*
  - [Orders](#order-endpoints) *(Phase 1)*
  - [Tables](#table-endpoints) *(Phase 1)*
  - [KOT](#kot-endpoints) *(Phase 1)*
  - [POS / Billing](#pos-billing-endpoints) *(Phase 1–2)*
  - [Inventory](#inventory-endpoints) *(Phase 2)*
  - [Customers](#customer-endpoints) *(Phase 2)*
  - [Reports](#report-endpoints) *(Phase 2)*
  - [Online Ordering](#online-ordering-endpoints) *(Phase 3)*

---

## API Overview

This API powers POS terminals, captain/waiter tablet apps, kitchen display systems, and (in Phase 3) online ordering channels.

### Base URL

```
http://localhost:8080/api/v1
```

Production base URL will be `https://your-domain.com/api/v1`.

### Versioning

All endpoints are prefixed with `/api/v1`. Breaking changes will increment the version prefix.

### Content Type

All requests must send `Content-Type: application/json` and `Accept: application/json`.

### Date and Time Format

Datetime values in responses use format `DD-MM-YYYY HH:mm:ss` in the restaurant timezone (`Asia/Kolkata` by default, from `config/restaurant.php`).

Monetary values use `decimal(10,2)` and currency `INR` by default.

### Target Clients

| Client | Phase | Auth |
|--------|-------|------|
| POS terminal app | 1 | Staff Sanctum token |
| Captain / waiter tablet | 1 | Staff Sanctum token |
| Kitchen display app | 1 | Staff Sanctum token |
| Manager mobile app | 2 | Staff Sanctum token |
| Online ordering (customer) | 3 | Public menu; OTP for orders |

> **Status:** This document is a **specification**. Endpoints are planned; implementation is in progress. Only `GET /api/user` exists today.

---

## Authentication

Staff API authentication uses **Laravel Sanctum** bearer tokens.

### Authentication Flow

```
┌──────────────┐
│  POS / App   │
└──────┬───────┘
       │
       │ POST /api/v1/auth/login
       │ { email, password }
       │
       ▼
┌─────────────┐
│   Server    │
│ (validates) │
└──────┬──────┘
       │
       │ 200 { token, user, role }
       │
       ▼
┌──────────────┐
│  POS / App   │
│ stores token │
└──────┬───────┘
       │
       │ Subsequent requests
       │ Authorization: Bearer {token}
       │
       ▼
┌─────────────┐
│   Server    │
│ (protected) │
└─────────────┘
```

### Token Usage

- Include `Authorization: Bearer {token}` on all protected endpoints.
- Tokens are revoked on `POST /api/v1/auth/logout`.
- Inactive staff accounts receive `403 Forbidden`.

### Phase 3 — Customer OTP *(planned)*

Online ordering customers authenticate via OTP sent to phone number. Flow mirrors staff login but issues a customer-scoped token with limited permissions.

---

## Common Headers

| Header | Required | Description | Example |
|--------|----------|-------------|---------|
| `Content-Type` | Yes (POST/PUT/PATCH) | Request body format | `application/json` |
| `Accept` | Yes | Response format | `application/json` |
| `Authorization` | Protected endpoints | Bearer token | `Bearer 1|abc123...` |

---

## Rate Limiting

| Endpoint group | Limit | Window |
|----------------|-------|--------|
| `POST /auth/login` | 5 requests | 60 seconds |
| `POST /auth/logout` | 10 requests | 60 seconds |
| Protected endpoints | 120 requests | 1 minute |
| `POST /online/orders` *(Phase 3)* | 10 requests | 60 seconds |

When rate limit is exceeded, the API returns `429 Too Many Requests`.

---

## Error Responses

### Standard Error Shape

```json
{
    "success": false,
    "message": "Error message describing what went wrong",
    "errors": {
        "field_name": ["Validation error message"]
    }
}
```

`errors` is present only for validation failures (`422`).

### Success Shape

```json
{
    "success": true,
    "message": "Optional success message",
    "data": {}
}
```

List endpoints return paginated data inside `data` with Laravel pagination meta.

### HTTP Status Codes

| Code | Description |
|------|-------------|
| `200` | Success |
| `201` | Created |
| `400` | Bad request |
| `401` | Unauthenticated — missing or invalid token |
| `403` | Forbidden — insufficient role/permission |
| `404` | Resource not found |
| `422` | Validation error |
| `429` | Rate limit exceeded |
| `500` | Server error |

### Example Validation Error

```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

---

## Pagination

List endpoints support standard query parameters:

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `page` | integer | 1 | Page number |
| `per_page` | integer | 15 | Items per page (max 100) |

Paginated response meta:

```json
{
    "success": true,
    "data": [],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 72
    }
}
```

---

## Endpoints

---

## Authentication Endpoints

*Phase 1*

### Login

**Endpoint:** `POST /api/v1/auth/login`

**Authentication:** None

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `email` | string | Yes | Staff email |
| `password` | string | Yes | Staff password |

**Success Response (200):**

```json
{
    "success": true,
    "message": "Login successful.",
    "data": {
        "token": "1|abcdefghijklmnopqrstuvwxyz",
        "user": {
            "id": 1,
            "name": "Rajesh Kumar",
            "email": "rajesh@restaurant.com",
            "role": "manager",
            "restaurant_id": 1
        }
    }
}
```

**Error Responses:** `401` invalid credentials, `403` account inactive, `422` validation error

---

### Logout

**Endpoint:** `POST /api/v1/auth/logout`

**Authentication:** Bearer token required

**Success Response (200):**

```json
{
    "success": true,
    "message": "Logged out successfully."
}
```

---

### Get Current User

**Endpoint:** `GET /api/v1/auth/me`

**Authentication:** Bearer token required

**Success Response (200):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Rajesh Kumar",
        "email": "rajesh@restaurant.com",
        "role": "manager",
        "restaurant_id": 1,
        "permissions": ["menu.read", "menu.write", "orders.read", "orders.write"]
    }
}
```

---

## Menu Endpoints

*Phase 1*

### List Categories

**Endpoint:** `GET /api/v1/menu/categories`

**Authentication:** Bearer token required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `active_only` | boolean | No | Default `true` — return only active categories |

**Success Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Starters",
            "sort_order": 1,
            "is_active": true,
            "items_count": 12
        }
    ]
}
```

---

### List Menu Items

**Endpoint:** `GET /api/v1/menu/items`

**Authentication:** Bearer token required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `category_id` | integer | No | Filter by category |
| `available_only` | boolean | No | Default `true` |
| `search` | string | No | Search by item name |

**Success Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 10,
            "category_id": 1,
            "name": "Paneer Tikka",
            "description": "Grilled cottage cheese with spices",
            "base_price": "280.00",
            "tax_rate": "5.00",
            "is_veg": true,
            "is_available": true,
            "image_url": null,
            "variants": [
                {
                    "id": 1,
                    "name": "Half",
                    "price": "180.00",
                    "is_default": false,
                    "is_available": true
                },
                {
                    "id": 2,
                    "name": "Full",
                    "price": "280.00",
                    "is_default": true,
                    "is_available": true
                }
            ],
            "addons": [
                {
                    "id": 1,
                    "name": "Extra Mint Chutney",
                    "price": "30.00",
                    "is_available": true
                }
            ]
        }
    ]
}
```

---

### Get Menu Item

**Endpoint:** `GET /api/v1/menu/items/{id}`

**Authentication:** Bearer token required

**Success Response (200):** Single item object (same shape as list item)

**Error Responses:** `404` item not found

---

### Toggle Item Availability

**Endpoint:** `PATCH /api/v1/menu/items/{id}/availability`

**Authentication:** Bearer token required (Manager, Owner)

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `is_available` | boolean | Yes | Availability flag |

**Success Response (200):**

```json
{
    "success": true,
    "message": "Item availability updated.",
    "data": {
        "id": 10,
        "is_available": false
    }
}
```

---

## Order Endpoints

*Phase 1*

### Create Order

**Endpoint:** `POST /api/v1/orders`

**Authentication:** Bearer token required (Cashier, Waiter, Manager)

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `order_type` | string | Yes | `dine_in`, `takeaway`, `delivery` |
| `table_id` | integer | Conditional | Required for `dine_in` |
| `customer_name` | string | No | Customer name |
| `customer_phone` | string | No | Customer phone |
| `notes` | string | No | Order notes |

**Success Response (201):**

```json
{
    "success": true,
    "message": "Order created.",
    "data": {
        "id": 101,
        "order_number": "ORD-20260707-001",
        "order_type": "dine_in",
        "table_id": 5,
        "status": "draft",
        "subtotal": "0.00",
        "tax_amount": "0.00",
        "discount_amount": "0.00",
        "total_amount": "0.00",
        "items": [],
        "created_at": "07-07-2026 14:30:00"
    }
}
```

---

### List Orders

**Endpoint:** `GET /api/v1/orders`

**Authentication:** Bearer token required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `status` | string | No | Filter by status |
| `order_type` | string | No | `dine_in`, `takeaway`, `delivery` |
| `table_id` | integer | No | Filter by table |
| `date` | string | No | Filter by date `DD-MM-YYYY` |
| `page` | integer | No | Page number |
| `per_page` | integer | No | Items per page |

**Success Response (200):** Paginated list of order summaries

---

### Get Order

**Endpoint:** `GET /api/v1/orders/{id}`

**Authentication:** Bearer token required

**Success Response (200):**

```json
{
    "success": true,
    "data": {
        "id": 101,
        "order_number": "ORD-20260707-001",
        "order_type": "dine_in",
        "table": { "id": 5, "name": "T-5", "area": "AC Hall" },
        "status": "confirmed",
        "customer_name": null,
        "customer_phone": null,
        "subtotal": "560.00",
        "tax_amount": "28.00",
        "discount_amount": "0.00",
        "total_amount": "588.00",
        "notes": null,
        "items": [
            {
                "id": 1,
                "menu_item_id": 10,
                "name": "Paneer Tikka",
                "variant": { "id": 2, "name": "Full" },
                "quantity": 2,
                "unit_price": "280.00",
                "tax_amount": "28.00",
                "total_price": "588.00",
                "notes": "Less spicy",
                "kot_status": "sent",
                "addons": [
                    { "id": 1, "name": "Extra Mint Chutney", "price": "30.00" }
                ]
            }
        ],
        "payments": [],
        "created_by": { "id": 3, "name": "Amit Singh" },
        "created_at": "07-07-2026 14:30:00"
    }
}
```

---

### Update Order Status

**Endpoint:** `PATCH /api/v1/orders/{id}/status`

**Authentication:** Bearer token required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `status` | string | Yes | Target status |

Valid transitions: `draft` → `confirmed` → `preparing` → `ready` → `served` → `billed` → `paid` → `completed`

**Success Response (200):** Updated order summary

**Error Responses:** `422` invalid status transition

---

### Add Item to Order

**Endpoint:** `POST /api/v1/orders/{id}/items`

**Authentication:** Bearer token required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `menu_item_id` | integer | Yes | Menu item ID |
| `variant_id` | integer | No | Selected variant |
| `quantity` | integer | Yes | Min 1 |
| `addon_ids` | array | No | Array of add-on IDs |
| `notes` | string | No | Item notes |

**Success Response (201):** Updated order with new line item

**Error Responses:** `422` item unavailable, order not editable

---

### Update Order Item

**Endpoint:** `PUT /api/v1/orders/{id}/items/{itemId}`

**Authentication:** Bearer token required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `quantity` | integer | No | Updated quantity |
| `notes` | string | No | Updated notes |

---

### Remove Order Item

**Endpoint:** `DELETE /api/v1/orders/{id}/items/{itemId}`

**Authentication:** Bearer token required

**Success Response (200):** Updated order totals

---

### Send to Kitchen (KOT)

**Endpoint:** `POST /api/v1/orders/{id}/send-kot`

**Authentication:** Bearer token required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `item_ids` | array | No | Specific items to send; omit for all pending |

**Success Response (200):**

```json
{
    "success": true,
    "message": "KOT sent to kitchen.",
    "data": {
        "kots": [
            {
                "id": 50,
                "kot_number": "KOT-20260707-001",
                "station": "main_kitchen",
                "status": "pending",
                "items_count": 2
            }
        ]
    }
}
```

---

### Hold Order

**Endpoint:** `POST /api/v1/orders/{id}/hold`

**Authentication:** Bearer token required

**Success Response (200):** Order marked as held

---

### Resume Order

**Endpoint:** `POST /api/v1/orders/{id}/resume`

**Authentication:** Bearer token required

**Success Response (200):** Order resumed from hold

---

### Void Order

**Endpoint:** `POST /api/v1/orders/{id}/void`

**Authentication:** Bearer token required (Manager, Owner)

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `reason` | string | Yes | Void reason (min 5 chars) |

**Success Response (200):** Order status set to `voided`

---

## Table Endpoints

*Phase 1*

### List Areas

**Endpoint:** `GET /api/v1/tables/areas`

**Authentication:** Bearer token required

**Success Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "AC Hall",
            "sort_order": 1,
            "tables_count": 10
        }
    ]
}
```

---

### List Tables

**Endpoint:** `GET /api/v1/tables`

**Authentication:** Bearer token required

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `area_id` | integer | No | Filter by area |
| `status` | string | No | `available`, `occupied`, `reserved`, `billing` |

**Success Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 5,
            "area_id": 1,
            "name": "T-5",
            "capacity": 4,
            "status": "occupied",
            "active_order_id": 101
        }
    ]
}
```

---

### Update Table Status

**Endpoint:** `PATCH /api/v1/tables/{id}/status`

**Authentication:** Bearer token required (Manager)

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `status` | string | Yes | `available`, `occupied`, `reserved`, `billing` |

---

## KOT Endpoints

*Phase 1*

### List Pending KOTs

**Endpoint:** `GET /api/v1/kot`

**Authentication:** Bearer token required (Kitchen, Manager)

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `station` | string | No | Filter by kitchen station |
| `status` | string | No | `pending`, `preparing`, `ready` |

**Success Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 50,
            "kot_number": "KOT-20260707-001",
            "order_id": 101,
            "order_number": "ORD-20260707-001",
            "table": "T-5",
            "station": "main_kitchen",
            "status": "pending",
            "items": [
                {
                    "id": 1,
                    "name": "Paneer Tikka",
                    "quantity": 2,
                    "notes": "Less spicy",
                    "kot_status": "pending"
                }
            ],
            "created_at": "07-07-2026 14:32:00"
        }
    ]
}
```

---

### Update KOT Status

**Endpoint:** `PATCH /api/v1/kot/{id}`

**Authentication:** Bearer token required (Kitchen, Manager)

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `status` | string | Yes | `preparing`, `ready`, `cancelled` |

**Success Response (200):** Updated KOT object

---

### Mark KOT Ready

**Endpoint:** `POST /api/v1/kot/{id}/ready`

**Authentication:** Bearer token required (Kitchen)

**Success Response (200):** KOT status set to `ready`; order items updated

---

## POS / Billing Endpoints

*Phase 1–2*

### Record Payment

**Endpoint:** `POST /api/v1/pos/payments`

**Authentication:** Bearer token required (Cashier, Manager)

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `order_id` | integer | Yes | Order ID |
| `payments` | array | Yes | Array of payment records |
| `payments[].method` | string | Yes | `cash`, `card`, `upi`, `other` |
| `payments[].amount` | string | Yes | Payment amount |
| `payments[].reference` | string | No | Transaction reference |

**Success Response (200):**

```json
{
    "success": true,
    "message": "Payment recorded.",
    "data": {
        "order_id": 101,
        "status": "paid",
        "total_amount": "588.00",
        "paid_amount": "588.00",
        "payments": [
            {
                "id": 1,
                "method": "upi",
                "amount": "588.00",
                "reference": "UPI123456",
                "created_at": "07-07-2026 15:00:00"
            }
        ]
    }
}
```

**Error Responses:** `422` payment total mismatch

---

### Apply Discount

**Endpoint:** `POST /api/v1/pos/orders/{id}/discount`

**Authentication:** Bearer token required (Cashier, Manager)

*Phase 2 — large discounts require manager PIN*

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `type` | string | Yes | `percentage`, `flat` |
| `value` | number | Yes | Discount value |
| `coupon_code` | string | No | Coupon code |
| `manager_pin` | string | Conditional | Required if discount exceeds threshold |

---

### Day Close Summary

**Endpoint:** `GET /api/v1/pos/day-close`

**Authentication:** Bearer token required (Cashier, Manager, Owner)

*Phase 2*

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `date` | string | No | Business date; default today |

**Success Response (200):**

```json
{
    "success": true,
    "data": {
        "date": "07-07-2026",
        "total_orders": 45,
        "total_revenue": "32500.00",
        "payment_breakdown": {
            "cash": "12000.00",
            "card": "15000.00",
            "upi": "5500.00"
        },
        "voided_orders": 2,
        "is_closed": false
    }
}
```

---

### Submit Day Close

**Endpoint:** `POST /api/v1/pos/day-close`

**Authentication:** Bearer token required (Cashier, Manager, Owner)

*Phase 2*

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `date` | string | Yes | Business date |
| `cash_actual` | string | Yes | Physical cash count |
| `notes` | string | No | Discrepancy notes |

**Success Response (201):** Day close record created

---

## Inventory Endpoints

*Phase 2*

### List Raw Materials

**Endpoint:** `GET /api/v1/inventory/materials`

**Authentication:** Bearer token required (Manager, Owner)

**Query Parameters:** `search`, `low_stock_only` (boolean), `page`, `per_page`

**Success Response (200):** Paginated list of materials with `current_stock`, `unit`, `low_stock_threshold`

---

### Get Stock Levels

**Endpoint:** `GET /api/v1/inventory/stock`

**Authentication:** Bearer token required (Manager, Owner)

**Success Response (200):** Summary of all material stock levels with alert flags

---

### Create Purchase Order

**Endpoint:** `POST /api/v1/inventory/purchase-orders`

**Authentication:** Bearer token required (Manager, Owner)

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `supplier_id` | integer | Yes | Supplier ID |
| `items` | array | Yes | Line items |
| `items[].material_id` | integer | Yes | Raw material ID |
| `items[].quantity` | number | Yes | Order quantity |
| `items[].unit_price` | string | Yes | Unit price |
| `expected_date` | string | No | Expected delivery date |

**Success Response (201):** Created purchase order

---

### Receive Purchase Order

**Endpoint:** `POST /api/v1/inventory/purchase-orders/{id}/receive`

**Authentication:** Bearer token required (Manager, Owner)

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `items` | array | Yes | Received quantities per line item |

**Success Response (200):** Stock updated; PO status set to received

---

## Customer Endpoints

*Phase 2*

### List Customers

**Endpoint:** `GET /api/v1/customers`

**Authentication:** Bearer token required (Manager, Owner)

**Query Parameters:** `search` (name/phone), `page`, `per_page`

---

### Create Customer

**Endpoint:** `POST /api/v1/customers`

**Authentication:** Bearer token required

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `name` | string | Yes | Customer name |
| `phone` | string | Yes | Phone number (unique) |
| `email` | string | No | Email address |

---

### Get Customer

**Endpoint:** `GET /api/v1/customers/{id}`

**Authentication:** Bearer token required

**Success Response (200):** Customer profile with `total_orders`, `total_spent`, `last_order_at`

---

### Customer Order History

**Endpoint:** `GET /api/v1/customers/{id}/orders`

**Authentication:** Bearer token required

**Success Response (200):** Paginated list of customer orders

---

## Report Endpoints

*Phase 2*

### Sales Summary

**Endpoint:** `GET /api/v1/reports/sales-summary`

**Authentication:** Bearer token required (Manager, Owner)

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `from_date` | string | Yes | Start date `DD-MM-YYYY` |
| `to_date` | string | Yes | End date `DD-MM-YYYY` |
| `group_by` | string | No | `day`, `week`, `month` |

**Success Response (200):**

```json
{
    "success": true,
    "data": {
        "total_orders": 320,
        "total_revenue": "245000.00",
        "total_tax": "12250.00",
        "total_discount": "5000.00",
        "payment_breakdown": {
            "cash": "80000.00",
            "card": "120000.00",
            "upi": "45000.00"
        },
        "by_period": [
            { "date": "01-07-2026", "orders": 45, "revenue": "35000.00" }
        ]
    }
}
```

---

### Item-wise Sales

**Endpoint:** `GET /api/v1/reports/item-wise`

**Authentication:** Bearer token required (Manager, Owner)

**Query Parameters:** `from_date`, `to_date`, `category_id`, `page`, `per_page`

**Success Response (200):** Paginated items with `quantity_sold`, `revenue`, `category`

---

### Tax Report

**Endpoint:** `GET /api/v1/reports/tax`

**Authentication:** Bearer token required (Manager, Owner)

**Query Parameters:** `from_date`, `to_date`

**Success Response (200):** Tax breakdown by rate (CGST, SGST, IGST as applicable)

---

## Online Ordering Endpoints

*Phase 3*

### Public Menu

**Endpoint:** `GET /api/v1/online/menu`

**Authentication:** None (public)

**Query Parameters:** `outlet_id` (required for multi-outlet)

**Success Response (200):** Active categories and available items (no internal IDs exposed optionally)

---

### Place Online Order

**Endpoint:** `POST /api/v1/online/orders`

**Authentication:** Customer token *(or guest with phone)*

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `order_type` | string | Yes | `delivery`, `pickup` |
| `customer_name` | string | Yes | Customer name |
| `customer_phone` | string | Yes | Phone number |
| `delivery_address` | string | Conditional | Required for delivery |
| `items` | array | Yes | Order line items |
| `items[].menu_item_id` | integer | Yes | Item ID |
| `items[].variant_id` | integer | No | Variant ID |
| `items[].quantity` | integer | Yes | Quantity |
| `items[].addon_ids` | array | No | Add-on IDs |
| `payment_method` | string | Yes | `cod`, `online` |
| `notes` | string | No | Order notes |

**Success Response (201):**

```json
{
    "success": true,
    "message": "Order placed successfully.",
    "data": {
        "id": 500,
        "order_number": "ONL-20260707-001",
        "status": "confirmed",
        "estimated_time": "30 minutes",
        "total_amount": "450.00"
    }
}
```

---

### Track Order

**Endpoint:** `GET /api/v1/online/orders/{id}/track`

**Authentication:** Customer token or order number + phone verification

**Success Response (200):**

```json
{
    "success": true,
    "data": {
        "order_number": "ONL-20260707-001",
        "status": "preparing",
        "status_history": [
            { "status": "confirmed", "at": "07-07-2026 18:00:00" },
            { "status": "preparing", "at": "07-07-2026 18:05:00" }
        ],
        "estimated_ready_at": "07-07-2026 18:35:00"
    }
}
```

---

### Customer OTP — Send

**Endpoint:** `POST /api/v1/online/auth/otp/send`

**Authentication:** None

*Phase 3*

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `phone` | string | Yes | Customer phone number |

---

### Customer OTP — Verify

**Endpoint:** `POST /api/v1/online/auth/otp/verify`

**Authentication:** None

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `phone` | string | Yes | Customer phone |
| `otp` | string | Yes | 6-digit OTP |

**Success Response (200):** Customer token issued

---

## Endpoint Summary Table

| Method | Endpoint | Phase | Auth | Description |
|--------|----------|-------|------|-------------|
| POST | `/auth/login` | 1 | No | Staff login |
| POST | `/auth/logout` | 1 | Yes | Staff logout |
| GET | `/auth/me` | 1 | Yes | Current user |
| GET | `/menu/categories` | 1 | Yes | List categories |
| GET | `/menu/items` | 1 | Yes | List items |
| GET | `/menu/items/{id}` | 1 | Yes | Get item |
| PATCH | `/menu/items/{id}/availability` | 1 | Yes | Toggle availability |
| POST | `/orders` | 1 | Yes | Create order |
| GET | `/orders` | 1 | Yes | List orders |
| GET | `/orders/{id}` | 1 | Yes | Get order |
| PATCH | `/orders/{id}/status` | 1 | Yes | Update status |
| POST | `/orders/{id}/items` | 1 | Yes | Add item |
| PUT | `/orders/{id}/items/{itemId}` | 1 | Yes | Update item |
| DELETE | `/orders/{id}/items/{itemId}` | 1 | Yes | Remove item |
| POST | `/orders/{id}/send-kot` | 1 | Yes | Send KOT |
| POST | `/orders/{id}/hold` | 1 | Yes | Hold order |
| POST | `/orders/{id}/resume` | 1 | Yes | Resume order |
| POST | `/orders/{id}/void` | 1 | Yes | Void order |
| GET | `/tables/areas` | 1 | Yes | List areas |
| GET | `/tables` | 1 | Yes | List tables |
| PATCH | `/tables/{id}/status` | 1 | Yes | Update table status |
| GET | `/kot` | 1 | Yes | Pending KOTs |
| PATCH | `/kot/{id}` | 1 | Yes | Update KOT |
| POST | `/kot/{id}/ready` | 1 | Yes | Mark KOT ready |
| POST | `/pos/payments` | 1 | Yes | Record payment |
| POST | `/pos/orders/{id}/discount` | 2 | Yes | Apply discount |
| GET | `/pos/day-close` | 2 | Yes | Day close summary |
| POST | `/pos/day-close` | 2 | Yes | Submit day close |
| GET | `/inventory/materials` | 2 | Yes | List materials |
| GET | `/inventory/stock` | 2 | Yes | Stock levels |
| POST | `/inventory/purchase-orders` | 2 | Yes | Create PO |
| POST | `/inventory/purchase-orders/{id}/receive` | 2 | Yes | Receive PO |
| GET | `/customers` | 2 | Yes | List customers |
| POST | `/customers` | 2 | Yes | Create customer |
| GET | `/customers/{id}` | 2 | Yes | Get customer |
| GET | `/customers/{id}/orders` | 2 | Yes | Order history |
| GET | `/reports/sales-summary` | 2 | Yes | Sales report |
| GET | `/reports/item-wise` | 2 | Yes | Item report |
| GET | `/reports/tax` | 2 | Yes | Tax report |
| GET | `/online/menu` | 3 | No | Public menu |
| POST | `/online/orders` | 3 | Customer | Place order |
| GET | `/online/orders/{id}/track` | 3 | Customer | Track order |
| POST | `/online/auth/otp/send` | 3 | No | Send OTP |
| POST | `/online/auth/otp/verify` | 3 | No | Verify OTP |

---

## Per-Endpoint Postman Docs

When endpoints are implemented, add detailed Postman documentation under:

```
docs/auth/postman-login.md
docs/menu/postman-list-items.md
docs/orders/postman-create-order.md
...
```

Each file should reference this master document for shared auth and error handling details.

---

**Document Version:** 1.0  
**Last Updated:** July 2026  
**Status:** Active — specification for implementation
