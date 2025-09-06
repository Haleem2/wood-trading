# Wood Trading API Documentation

## Overview

The Wood Trading API is a comprehensive REST API built with Laravel for managing wood trading operations. It provides endpoints for inventory management, sales, purchases, customer/supplier management, and financial operations.

## Base URL

- **Development**: `http://localhost:8000/api`
- **Production**: `https://api.woodtrading.com/api`

## Authentication

The API uses Laravel Sanctum for authentication. Include the Bearer token in the Authorization header:

```
Authorization: Bearer {your-token}
```

## API Endpoints

### Authentication

#### POST /auth/login
Login with email and password.

**Request Body:**
```json
{
    "email": "admin@woodtrading.com",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Admin",
            "email": "admin@woodtrading.com",
            "roles": [...]
        },
        "token": "1|abc123..."
    }
}
```

#### POST /auth/logout
Logout and invalidate the current token.

**Headers:** `Authorization: Bearer {token}`

**Response:**
```json
{
    "success": true,
    "message": "Logout successful"
}
```

#### GET /auth/me
Get current user information.

**Headers:** `Authorization: Bearer {token}`

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "John Admin",
            "email": "admin@woodtrading.com",
            "tenant": {...},
            "roles": [...]
        }
    }
}
```

### Inventory Management

#### GET /items
Get list of items with optional filtering.

**Query Parameters:**
- `search` (string): Search by name, code, or species
- `species` (string): Filter by species
- `grade` (string): Filter by grade
- `page` (integer): Page number (default: 1)
- `per_page` (integer): Items per page (default: 15)

**Response:**
```json
{
    "success": true,
    "data": {
        "data": [
            {
                "id": 1,
                "code": "PINE-2X4-8",
                "name": "Pine 2x4 8ft",
                "species": "Pine",
                "grade": "A",
                "thickness": 38.1,
                "width": 88.9,
                "length": 2438.4,
                "unit": "piece",
                "barcode": "1234567890123",
                "moisture_level": 12.0,
                "low_stock_threshold": 50.0,
                "costing_method": "FIFO",
                "is_active": true,
                "total_stock": 150.0,
                "available_stock": 120.0,
                "reserved_stock": 30.0,
                "is_low_stock": false,
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "links": {...},
        "meta": {...}
    }
}
```

#### POST /items
Create a new item.

**Request Body:**
```json
{
    "code": "PINE-2X4-8",
    "name": "Pine 2x4 8ft",
    "species": "Pine",
    "grade": "A",
    "thickness": 38.1,
    "width": 88.9,
    "length": 2438.4,
    "unit": "piece",
    "barcode": "1234567890123",
    "moisture_level": 12.0,
    "low_stock_threshold": 50.0,
    "costing_method": "FIFO"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Item created successfully",
    "data": {
        "id": 1,
        "code": "PINE-2X4-8",
        "name": "Pine 2x4 8ft",
        ...
    }
}
```

#### GET /items/{id}
Get item by ID.

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "code": "PINE-2X4-8",
        "name": "Pine 2x4 8ft",
        "stock_lots": [...]
    }
}
```

#### PUT /items/{id}
Update an item.

**Request Body:** Same as POST /items (all fields optional)

**Response:**
```json
{
    "success": true,
    "message": "Item updated successfully",
    "data": {...}
}
```

#### DELETE /items/{id}
Delete an item (soft delete).

**Response:**
```json
{
    "success": true,
    "message": "Item deleted successfully"
}
```

### Stock Management

#### GET /stock
Get stock levels with optional filtering.

**Query Parameters:**
- `item_id` (integer): Filter by item ID
- `warehouse_id` (integer): Filter by warehouse ID
- `low_stock` (boolean): Show only low stock items

**Response:**
```json
{
    "success": true,
    "data": {
        "data": [
            {
                "id": 1,
                "lot_no": "LOT-PINE-2X4-8-1-1",
                "qty_on_hand": 100.0,
                "qty_reserved": 20.0,
                "qty_available": 80.0,
                "cost": 125.50,
                "received_at": "2024-01-01T00:00:00.000000Z",
                "expires_at": "2024-12-31T00:00:00.000000Z",
                "warehouse": {...}
            }
        ]
    }
}
```

#### POST /stock/adjust
Adjust stock levels.

**Request Body:**
```json
{
    "item_id": 1,
    "warehouse_id": 1,
    "quantity": 10.5,
    "type": "adjustment",
    "movement": "in",
    "reason": "Physical count adjustment",
    "notes": "Found additional stock during inventory"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Stock adjusted successfully",
    "data": {...}
}
```

### Customer Management

#### GET /customers
Get list of customers.

**Query Parameters:**
- `search` (string): Search by name or contact person
- `page` (integer): Page number
- `per_page` (integer): Items per page

#### POST /customers
Create a new customer.

**Request Body:**
```json
{
    "name": "Construction Corp.",
    "contact_person": "John Builder",
    "email": "john@constructioncorp.com",
    "phone": "+1-555-2000",
    "address": "500 Build Street, Construction City, CC 50000",
    "tax_id": "CUST001",
    "credit_limit": 100000.00
}
```

#### GET /customers/{id}
Get customer by ID.

#### PUT /customers/{id}
Update a customer.

#### DELETE /customers/{id}
Delete a customer.

### Supplier Management

#### GET /suppliers
Get list of suppliers.

#### POST /suppliers
Create a new supplier.

**Request Body:**
```json
{
    "name": "Premium Timber Co.",
    "contact_person": "Robert Supplier",
    "email": "robert@premiumtimber.com",
    "phone": "+1-555-1000",
    "address": "100 Timber Street, Forest City, FC 10000",
    "tax_id": "TAX001",
    "payment_terms": "Net 30",
    "lead_time_days": 7,
    "credit_limit": 50000.00
}
```

#### GET /suppliers/{id}
Get supplier by ID.

#### PUT /suppliers/{id}
Update a supplier.

#### DELETE /suppliers/{id}
Delete a supplier.

### Purchase Orders

#### GET /purchase-orders
Get list of purchase orders.

#### POST /purchase-orders
Create a new purchase order.

**Request Body:**
```json
{
    "supplier_id": 1,
    "expected_at": "2024-01-15T00:00:00.000000Z",
    "currency": "USD",
    "notes": "Urgent order for construction project",
    "items": [
        {
            "item_id": 1,
            "quantity": 100,
            "unit_price": 125.50,
            "discount_percent": 5.0,
            "tax_percent": 10.0
        }
    ]
}
```

#### GET /purchase-orders/{id}
Get purchase order by ID.

#### PUT /purchase-orders/{id}
Update a purchase order.

#### DELETE /purchase-orders/{id}
Delete a purchase order.

#### POST /purchase-orders/{id}/receive
Receive goods against a purchase order.

**Request Body:**
```json
{
    "reference_no": "GR-001",
    "received_at": "2024-01-15T10:00:00.000000Z",
    "warehouse_id": 1,
    "transport_cost": 50.00,
    "customs_cost": 25.00,
    "handling_cost": 15.00,
    "notes": "All items received in good condition",
    "items": [
        {
            "item_id": 1,
            "quantity_received": 100,
            "quantity_defective": 2,
            "quantity_wastage": 1,
            "unit_cost": 125.50,
            "landed_cost": 0.90,
            "lot_no": "LOT-001"
        }
    ]
}
```

### Quotations

#### GET /quotations
Get list of quotations.

#### POST /quotations
Create a new quotation.

**Request Body:**
```json
{
    "customer_id": 1,
    "valid_until": "2024-01-31T00:00:00.000000Z",
    "currency": "USD",
    "notes": "Quote for construction project",
    "items": [
        {
            "item_id": 1,
            "quantity": 50,
            "unit_price": 150.00,
            "discount_percent": 10.0,
            "tax_percent": 10.0
        }
    ]
}
```

#### GET /quotations/{id}
Get quotation by ID.

#### PUT /quotations/{id}
Update a quotation.

#### DELETE /quotations/{id}
Delete a quotation.

#### POST /quotations/{id}/convert-to-sales-order
Convert quotation to sales order.

### Sales Orders

#### GET /sales-orders
Get list of sales orders.

#### POST /sales-orders
Create a new sales order.

**Request Body:**
```json
{
    "customer_id": 1,
    "quotation_id": 1,
    "required_at": "2024-02-01T00:00:00.000000Z",
    "currency": "USD",
    "notes": "Urgent delivery required",
    "items": [
        {
            "item_id": 1,
            "quantity": 50,
            "unit_price": 150.00,
            "discount_percent": 10.0,
            "tax_percent": 10.0
        }
    ]
}
```

#### GET /sales-orders/{id}
Get sales order by ID.

#### PUT /sales-orders/{id}
Update a sales order.

#### DELETE /sales-orders/{id}
Delete a sales order.

#### POST /sales-orders/{id}/deliver
Create delivery note for sales order.

**Request Body:**
```json
{
    "delivered_at": "2024-02-01T14:00:00.000000Z",
    "vehicle": "Truck-001",
    "driver": "John Driver",
    "delivery_address": "500 Build Street, Construction City, CC 50000",
    "notes": "Delivered to site office",
    "items": [
        {
            "item_id": 1,
            "quantity_delivered": 50
        }
    ]
}
```

### Invoices

#### GET /invoices
Get list of invoices.

#### POST /invoices
Create a new invoice.

**Request Body:**
```json
{
    "sales_order_id": 1,
    "customer_id": 1,
    "issued_at": "2024-02-01T00:00:00.000000Z",
    "due_date": "2024-02-15",
    "currency": "USD",
    "notes": "Payment due within 15 days"
}
```

#### GET /invoices/{id}
Get invoice by ID.

#### PUT /invoices/{id}
Update an invoice.

#### DELETE /invoices/{id}
Delete an invoice.

#### POST /invoices/{id}/generate-pdf
Generate PDF for invoice.

### Payments

#### GET /payments
Get list of payments.

#### POST /payments
Record a payment.

**Request Body:**
```json
{
    "invoice_id": 1,
    "customer_id": 1,
    "type": "receipt",
    "method": "bank_transfer",
    "amount": 7500.00,
    "currency": "USD",
    "reference_no": "PAY-001",
    "paid_at": "2024-02-10T10:00:00.000000Z",
    "notes": "Payment received via bank transfer"
}
```

#### GET /payments/{id}
Get payment by ID.

#### PUT /payments/{id}
Update a payment.

#### DELETE /payments/{id}
Delete a payment.

### Reports

#### GET /reports/stock-valuation
Get stock valuation report.

**Query Parameters:**
- `warehouse_id` (integer): Filter by warehouse
- `as_of` (date): Valuation date (default: today)

#### GET /reports/sales-summary
Get sales summary report.

**Query Parameters:**
- `from` (date): Start date
- `to` (date): End date
- `customer_id` (integer): Filter by customer

#### GET /reports/purchase-summary
Get purchase summary report.

**Query Parameters:**
- `from` (date): Start date
- `to` (date): End date
- `supplier_id` (integer): Filter by supplier

#### GET /reports/aging-receivables
Get aging receivables report.

#### GET /reports/aging-payables
Get aging payables report.

#### GET /reports/low-stock-alerts
Get low stock alerts.

## Error Handling

The API returns consistent error responses:

```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Validation error message"]
    }
}
```

### HTTP Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

## Rate Limiting

The API implements rate limiting:
- 60 requests per minute per user
- 1000 requests per hour per user

## Pagination

List endpoints support pagination:

```json
{
    "data": [...],
    "links": {
        "first": "http://api.woodtrading.com/api/items?page=1",
        "last": "http://api.woodtrading.com/api/items?page=10",
        "prev": null,
        "next": "http://api.woodtrading.com/api/items?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 10,
        "per_page": 15,
        "to": 15,
        "total": 150
    }
}
```

## Filtering and Sorting

Most list endpoints support:
- **Search**: Use `search` parameter for text search
- **Filtering**: Use specific field parameters
- **Sorting**: Use `sort` parameter (e.g., `sort=name` or `sort=-created_at`)
- **Pagination**: Use `page` and `per_page` parameters

## Webhooks

The API supports webhooks for real-time notifications:

- `item.low_stock` - Triggered when item stock falls below threshold
- `invoice.overdue` - Triggered when invoice becomes overdue
- `payment.received` - Triggered when payment is recorded

## SDKs and Libraries

Official SDKs are available for:
- PHP (Laravel)
- JavaScript (Node.js)
- Python
- Java

## Support

For API support and questions:
- Email: api-support@woodtrading.com
- Documentation: https://docs.woodtrading.com
- Status Page: https://status.woodtrading.com
