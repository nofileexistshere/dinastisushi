# Dinasti Sushi API Documentation

## Overview

This document provides comprehensive API documentation for the Dinasti Sushi application. The API follows RESTful conventions and includes proper error handling, validation, and security measures.

## Base URL

```
http://localhost:8000/api
```

## Authentication

Most endpoints require authentication. Use Laravel's built-in authentication system.

## Error Handling

All API responses follow a consistent format:

### Success Response

```json
{
    "success": true,
    "data": {},
    "message": "Operation successful"
}
```

### Error Response

```json
{
    "success": false,
    "message": "Error description",
    "errors": {}
}
```

## Endpoints

### Menu Endpoints

#### GET /api/menu/search

Search menu items by name, description, or category.

**Parameters:**

-   `query` (string, required) - Search term (min 2 characters)
-   `limit` (integer, optional) - Number of results (max 50, default 20)

**Example Request:**

```bash
GET /api/menu/search?query=salmon&limit=10
```

**Example Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Salmon Maki",
            "description": "Gulungan nasi sushi kecil dengan isian salmon segar",
            "price": 25000,
            "category": "Sushi Roll",
            "average_rating": 4.5,
            "rating_count": 12,
            "orders_count": 25,
            "image": "https://example.com/image.jpg",
            "tags": ["Salmon", "Maki", "Nori"]
        }
    ],
    "count": 1
}
```

#### GET /api/menu/recommendations

Get menu recommendations based on category.

**Parameters:**

-   `category` (string, optional) - Category filter

**Example Request:**

```bash
GET /api/menu/recommendations?category=Sushi Roll
```

#### GET /api/menu/statistics

Get menu statistics (Admin only).

**Headers:**

-   `Authorization: Bearer {token}`

**Example Response:**

```json
{
    "success": true,
    "data": {
        "total_items": 25,
        "total_categories": 7,
        "average_rating": 4.2,
        "most_popular": {
            "id": 1,
            "name": "Salmon Maki",
            "orders_count": 50
        }
    }
}
```

### Cart Endpoints

#### GET /api/cart/count

Get current cart item count.

**Example Response:**

```json
{
    "success": true,
    "data": {
        "count": 3
    }
}
```

### Order Endpoints

#### GET /api/orders/statistics

Get order statistics (Admin only).

**Headers:**

-   `Authorization: Bearer {token}`

**Example Response:**

```json
{
    "success": true,
    "data": {
        "total_orders": 150,
        "total_revenue": 2500000,
        "recent_orders": [...]
    }
}
```

## Validation Rules

### Menu Search

-   `query`: Required, string, min 2 characters, max 255 characters
-   `limit`: Optional, integer, min 1, max 50

### Cart Operations

-   `menu_item_id`: Required, integer, must exist in menu_items table
-   `quantity`: Required, integer, min 1, max 10

### Order Creation

-   `menu_item_id`: Required, integer, must exist in menu_items table
-   `quantity`: Required, integer, min 1, max 10

## Security Headers

All API responses include the following security headers:

-   `X-Frame-Options: SAMEORIGIN`
-   `X-Content-Type-Options: nosniff`
-   `X-XSS-Protection: 1; mode=block`
-   `Content-Security-Policy: ...`
-   `Referrer-Policy: strict-origin-when-cross-origin`

## Rate Limiting

API endpoints are rate-limited to prevent abuse:

-   Search endpoints: 60 requests per minute
-   Cart endpoints: 120 requests per minute
-   Order endpoints: 30 requests per minute

## Error Codes

-   `200` - Success
-   `400` - Bad Request
-   `401` - Unauthorized
-   `403` - Forbidden
-   `404` - Not Found
-   `422` - Validation Error
-   `429` - Too Many Requests
-   `500` - Internal Server Error

## Data Models

### MenuItem

```json
{
    "id": 1,
    "name": "Salmon Maki",
    "description": "Gulungan nasi sushi kecil dengan isian salmon segar",
    "price": 25000,
    "category": "Sushi Roll",
    "average_rating": 4.5,
    "rating_count": 12,
    "orders_count": 25,
    "image": "https://example.com/image.jpg",
    "tags": ["Salmon", "Maki", "Nori"],
    "created_at": "2023-12-01T10:00:00Z",
    "updated_at": "2023-12-01T10:00:00Z"
}
```

### Order

```json
{
    "id": 1,
    "user_id": 1,
    "menu_item_id": 1,
    "quantity": 2,
    "total_price": 50000,
    "created_at": "2023-12-01T10:00:00Z",
    "updated_at": "2023-12-01T10:00:00Z"
}
```

## Testing

Use the following curl commands to test endpoints:

### Search Menu

```bash
curl -X GET "http://localhost:8000/api/menu/search?query=salmon" \
     -H "Accept: application/json"
```

### Get Cart Count

```bash
curl -X GET "http://localhost:8000/api/cart/count" \
     -H "Accept: application/json" \
     -H "Cookie: laravel_session=..."
```

## SDK Examples

### JavaScript

```javascript
// Search menu items
const searchMenu = async (query) => {
    try {
        const response = await fetch(`/api/menu/search?query=${query}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Search error:", error);
    }
};

// Get cart count
const getCartCount = async () => {
    try {
        const response = await fetch("/api/cart/count");
        const data = await response.json();
        return data.data.count;
    } catch (error) {
        console.error("Cart count error:", error);
    }
};
```

### PHP

```php
use Illuminate\Support\Facades\Http;

// Search menu items
$response = Http::get('/api/menu/search', [
    'query' => 'salmon',
    'limit' => 10
]);

if ($response->successful()) {
    $data = $response->json();
    // Handle results
}
```

## Best Practices

1. **Always validate input** before processing
2. **Use proper HTTP methods** (GET for reading, POST for creating)
3. **Handle errors gracefully** with appropriate status codes
4. **Rate limit requests** to prevent abuse
5. **Log all API calls** for monitoring and debugging
6. **Use HTTPS** in production
7. **Implement proper authentication** for sensitive endpoints
8. **Cache frequently accessed data** to improve performance

## Support

For API support and questions, contact the development team or check the application logs for detailed error information.
