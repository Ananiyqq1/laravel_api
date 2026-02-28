# Architectura Studio Management API

A RESTful API built with Laravel for managing architectural clients and billing. This project follows the Restful API architecture patterns and integrates with the structural studio theme.

## Features

- **RESTful Endpoints**: Full CRUD for Customers and Invoices.
- **API Versioning**: Implemented in `v1`.
- **Advanced Filtering**: Support for query parameters like `postalCode[gt]=30000` or `amount[lt]=1000`.
- **Conditional Loading**: Include related data using `includeInvoices=true`.
- **Bulk Operations**: Specialized endpoint for batch invoice imports.
- **Token-based Authentication**: Secure access using Laravel Sanctum with tiered capabilities (`basic`, `update`, `admin`).

## Tech Stack

- **Framework**: Laravel 12
- **Database**: SQLite
- **Authentication**: Laravel Sanctum

## Environment Setup

1.  **Dependencies**:
    ```bash
    composer install
    ```
2.  **Database**:
    ```bash
    touch database/database.sqlite
    php artisan migrate --seed
    ```
3.  **Authentication Setup**:
    - Visit `/setup` in your browser to generate your initial API tokens.

## API Documentation

### Authentication
All API requests must include a Bearer token in the `Authorization` header.

### Endpoints

#### Customers
- `GET /api/v1/customers`: List all customers.
- `GET /api/v1/customers/{id}`: Show a specific customer.
- `POST /api/v1/customers`: Create a new customer.
- `PUT/PATCH /api/v1/customers/{id}`: Update a customer.
- `DELETE /api/v1/customers/{id}`: Delete a customer.

#### Invoices
- `GET /api/v1/invoices`: List all invoices.
- `GET /api/v1/invoices/{id}`: Show a specific invoice.
- `POST /api/v1/invoices`: Create a single invoice.
- `PUT/PATCH /api/v1/invoices/{id}`: Update an invoice.
- `DELETE /api/v1/invoices/{id}`: Delete an invoice.
- `POST /api/v1/invoices/bulk`: Bulk insert invoices.

### Filtering Examples
- `/api/v1/customers?city[eq]=London`
- `/api/v1/customers?postalCode[gt]=50000&includeInvoices=true`
- `/api/v1/invoices?status[eq]=P&amount[gt]=5000`

## Development Notes

> [!NOTE]
> This project includes a custom compatibility patch in `bootstrap/app.php` to support environments with limited PHP extensions (missing `DOM` and `mbstring`).

---
Built for the Architectura Portfolio.
