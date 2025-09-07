# Microservice Challenge
## Architecture
- Built with **Laravel 12**, combining a web application (front-end and back-end) and an API.
- **Laravel Sanctum** handles authentication via secure token-based access.
- **Form Requests** validate all incoming data from users.
- **Migrations, Factories, and Seeders** manage the database schema and sample data.
- Route files:
  - `web.php` → Dashboard routes.
  - `api.php` → API routes.
## Setting Project Up
1. Clone this repository or download the zip file.
2. Run command `composer i` to install all the projects dependicies.
3. Rename the file `.env.example` to `.env`
4. Set the Database parameters on `.env` file: 
    * DB_CONNECTION
    * DB_HOST
    * DB_PORT
    * DB_DATABASE
    * DB_USERNAME
    * DB_PASSWORD
5. Generate the application key using `php artisan key:generate`

## Database
1. Create the tables - to create the tables it's necessary to run the migration using the following command
```
php artisan migrate
```
2. Populate the Database - to populate the tables with data it's necessary to run the migration using the following command, wich will create users and vendors, using seeders and factories. It also calls to a command that imports invoices using a JSON file. 
```
php artisan db:seed
```
## Run the Project
To make the API and the dashboard accessble it's necessary to run the migration using the following command
```
php artisan serve
```

## Project Usage
* By accessing [Dashboard](http://localhost:8000/) you can view a summary of invoices per vendor.
* To use the API you need to GET your token first, by sending your email and password to the endpoint `POST /api/login`, the endpoint will return the token that you must use in the request header as a Bearer token, by putting the following on your header `Authorization: Bearer {token}`.

# API Documentation

## Get API Authentication Token
Endpoint to get the Bearer Token to be used on the other endpoints.
### Endpoint
`POST /api/login`
### Paramenters (Request Body)
| Name      | Type  | Mandatory | Description        |
|-----------|-------|-----------|--------------------|
| `email`   | email | Yes       | User's email       |
| `password`| string| Yes       | User's password    |
### Request Example
```json
{
  "email": "john.doe@example.com",
  "password": "password123"
}
```

## Create Vendor
Endpoint to create Vendors.
### Authentication
Use the Bearer Token.
### Endpoint
`POST /api/vendors/create`
### Paramenters (Request Body)
| Name      | Type  | Mandatory | Description        |
|-----------|-------|-----------|--------------------|
| `name`   | string | Yes       | name     |
| `vat_number`   | string | Yes       | Vendors's VAT Number       |
| `payment_terms`| integer| Yes       | Default number of due days    |
### Request Example
```json
{
    "name" : "M&M Inc",
    "vat_number" : "BE987654321",
    "payment_terms" : 3
}
```

## Get Vendor
Endpoint to get a Vendor's information.
### Authentication
Use the Bearer Token.
### Endpoint
`GET /api/vendors/{id}`
### Request Example
`http://localhost/api/vendors/1`

## Get Vendor's Summary
Endpoint to get a Vendor's invoicing summary.
### Authentication
Use the Bearer Token.
### Endpoint
`GET /api/vendors/{id}/summary`
### Request Example
`http://localhost/api/vendors/1/summary`

## Create Invoice
Endpoint to create invoices.
### Authentication
Use the Bearer Token.
### Endpoint
`POST /api/vendors/invoices/create`
### Paramenters (Request Body)
| Name      | Type  | Mandatory | Description        |
|-----------|-------|-----------|--------------------|
| `invoice_number`   | string | Yes       | Invoice Identification     |
| `vendor_id`   | integer | Yes       | Invoice's Vendor      |
| `doc_date`   | date | Yes       | Invoice's Date      |
| `ammount`| decimal| Yes       | Invoice's Ammount    |
| `due_date`| date| No       | Invoice's Due Date, if not present calculated using the Vendor's payment_terms    |
| `status`| string| No       | Invoice's Status, if not present assumed as `pending` |


### Request Example
```json
{
    "invoice_number": "INV-001",
    "vendor_id": 1,
    "doc_date": "2025-01-05",
    "ammount": 523.00,
    "status": "paid"
}
```

## List Invoices
Endpoint to list invoices using filters.
### Authentication
Use the Bearer Token.
### Endpoint
`GET /api/vendors/invoices`
### Paramenters (Request Body)
| Name      | Type  | Mandatory | Description        |
|-----------|-------|-----------|--------------------|
| `vendor_id`   | integer | No       | Filter Invoice list by vendor      |
| `status`| string| No       |  Filter Invoice list by status |


### Request Example
```json
{
    "vendor_id": 1,
    "status": "paid"
}
```