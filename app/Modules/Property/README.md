# PropertyModule

A CodeIgniter 4 module for managing real estate property listings.

## Features

- **Admin CRUD** – Create, read, update, delete properties
- **Public Listing** – Browse and view property details
- **Multi-language** – German, English, Turkish support
- **SQLite Compatible** – All queries work with SQLite

## Installation

1. Run migrations:
   ```bash
   php spark migrate
   ```

2. Seed sample data (optional):
   ```bash
   php spark db:seed PropertySeeder
   ```

## Routes

### Frontend
- `GET /properties` – Property listing
- `GET /properties/{slug}` – Property detail

### Admin (requires authentication)
- `GET /admin/properties` – List all properties
- `GET /admin/properties/create` – Create form
- `POST /admin/properties` – Store new property
- `GET /admin/properties/{id}` – View property
- `GET /admin/properties/{id}/edit` – Edit form
- `PUT /admin/properties/{id}` – Update property
- `DELETE /admin/properties/{id}` – Delete property

## Database Schema

| Column | Type | Description |
|--------|------|-------------|
| id | INTEGER | Primary key |
| title | VARCHAR(255) | Property title |
| slug | VARCHAR(255) | URL-friendly slug |
| description | TEXT | Full description |
| price | DECIMAL | Price in EUR |
| bedrooms | INTEGER | Number of bedrooms |
| bathrooms | INTEGER | Number of bathrooms |
| area_sqm | DECIMAL | Area in square meters |
| address | VARCHAR(255) | Street address |
| city | VARCHAR(100) | City name |
| zip_code | VARCHAR(20) | Postal code |
| status | VARCHAR(50) | available/sold/reserved |
| featured | BOOLEAN | Is featured listing |
| images | TEXT | JSON array of image paths |
| created_at | DATETIME | Creation timestamp |
| updated_at | DATETIME | Last update timestamp |
