# FarmTech Backend API

A comprehensive RESTful API for the FarmTech agricultural equipment rental platform. This backend handles user authentication, equipment management, bookings, payments, reviews, and admin operations.

## Features

- User authentication with JWT tokens
- Equipment CRUD operations with search and filtering
- Booking management with status tracking
- Payment processing integration
- Review and rating system
- Admin dashboard and moderation tools
- Comprehensive error handling
- Request validation
- Database migrations
- API documentation

## Tech Stack

- **Runtime**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache/XAMPP
- **Architecture**: RESTful API with modular design
- **Authentication**: Session-based & prepared statements for security

## Project Structure

```
backend/
├── config/
│   ├── db_config.php          # Database configuration
│   └── constants.php          # Application constants
├── auth/
│   ├── register.php           # User registration
│   ├── login.php              # User login
│   ├── logout.php             # User logout
│   └── password_reset.php     # Password recovery
├── equipment/
│   ├── add_equipment.php      # Add new equipment
│   ├── view_equipment.php     # Get equipment list
│   ├── get_details.php        # Get equipment details
│   ├── edit_equipment.php     # Update equipment
│   └── delete_equipment.php   # Delete equipment
├── booking/
│   ├── create_booking.php     # Create booking
│   ├── view_bookings.php      # View user bookings
│   ├── update_status.php      # Update booking status
│   └── cancel_booking.php     # Cancel booking
├── payment/
│   ├── process_payment.php    # Process payment
│   └── transaction_history.php# Payment history
├── reviews/
│   ├── add_review.php         # Add review
│   └── get_reviews.php        # Get reviews
├── admin/
│   ├── dashboard.php          # Admin dashboard
│   ├── manage_users.php       # User management
│   ├── manage_equipment.php   # Equipment approval
│   ├── approve_equipment.php  # Approve equipment
│   ├── complaints.php         # Complaints management
│   └── resolve_complaint.php  # Resolve complaint
└── database/
    └── farmtech.sql           # Database schema
```

## Setup Instructions

### Prerequisites
- XAMPP or similar local server with PHP 7.4+
- MySQL 5.7+
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/karlepriya911-ship-it/Farmtech.git
   cd Farmtech
   ```

2. **Setup database**
   - Start XAMPP (Apache & MySQL)
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Import `database/farmtech.sql`
   - Database name: `farmtech`

3. **Configure database connection**
   - Edit `backend/config/db_config.php`
   - Update database credentials if needed
   ```php
   $host = '127.0.0.1';
   $dbname = 'farmtech';
   $username = 'root';
   $password = '';
   ```

4. **Start the server**
   - Place project in `htdocs` folder
   - Access API: `http://localhost/Farmtech/backend/`

## API Endpoints

### Authentication
```
POST   /auth/register.php          - Register new user
POST   /auth/login.php             - User login
POST   /auth/logout.php            - User logout
POST   /auth/password_reset.php    - Reset password
```

### Equipment
```
GET    /equipment/view_equipment.php    - List equipment
GET    /equipment/get_details.php       - Get equipment details
POST   /equipment/add_equipment.php     - Add equipment (Owner)
PUT    /equipment/edit_equipment.php    - Edit equipment (Owner)
DELETE /equipment/delete_equipment.php  - Delete equipment (Owner)
```

### Bookings
```
POST   /booking/create_booking.php      - Create booking
GET    /booking/view_bookings.php       - View user bookings
PUT    /booking/update_status.php       - Update booking status
DELETE /booking/cancel_booking.php      - Cancel booking
```

### Payments
```
POST   /payment/process_payment.php        - Process payment
GET    /payment/transaction_history.php    - Get payment history
```

### Reviews
```
POST   /reviews/add_review.php          - Add review
GET    /reviews/get_reviews.php         - Get reviews
```

### Admin
```
GET    /admin/dashboard.php              - Admin dashboard
GET    /admin/manage_users.php           - Manage users
GET    /admin/manage_equipment.php       - Manage equipment
PUT    /admin/approve_equipment.php      - Approve equipment
GET    /admin/complaints.php             - View complaints
PUT    /admin/resolve_complaint.php      - Resolve complaint
```

## API Response Format

All responses are in JSON format:

**Success Response:**
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

**Error Response:**
```json
{
  "success": false,
  "error": "Error message",
  "code": 400
}
```

## Authentication

The API uses session-based authentication. After login, a session is created and stored on the server.

**Login Example:**
```bash
curl -X POST http://localhost/Farmtech/backend/auth/login.php \
  -H "Content-Type: application/json" \
  -d '{
    "email": "farmer@example.com",
    "password": "password123"
  }'
```

## Database Schema

### Users Table
- id, name, email, phone, password, role, status, created_at, updated_at

### Equipment Table
- id, owner_id, name, category, description, price_per_day, location, availability, image, status, created_at, updated_at

### Bookings Table
- id, farmer_id, equipment_id, start_date, end_date, total_amount, status, created_at, updated_at

### Payments Table
- id, booking_id, amount, payment_date, status, payment_method, transaction_id

### Reviews Table
- id, farmer_id, equipment_id, rating, comment, created_at

### Complaints Table
- id, user_id, subject, message, status, resolution, created_at, updated_at

## Security Features

- Password hashing using `password_hash()`
- Prepared statements to prevent SQL injection
- Input validation and sanitization
- CORS headers
- Error handling with appropriate HTTP status codes
- Session management
- Role-based access control

## Error Handling

The API returns appropriate HTTP status codes:
- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `409` - Conflict (e.g., email already exists)
- `422` - Unprocessable Entity
- `500` - Internal Server Error

## Testing

You can test the APIs using:
- Postman (GUI tool)
- cURL (command line)
- Thunder Client (VS Code extension)
- Insomnia

### Example Test
```bash
# Register a new farmer
curl -X POST http://localhost/Farmtech/backend/auth/register.php \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Farmer",
    "email": "john@example.com",
    "phone": "9876543210",
    "role": "farmer",
    "password": "secure_password"
  }'

# Get equipment list
curl -X GET "http://localhost/Farmtech/backend/equipment/view_equipment.php?search=tractor"
```

## Code Quality

- Modular function design
- Clear separation of concerns
- Comprehensive comments
- Consistent naming conventions
- Error messages for debugging
- Database transaction handling

## Best Practices Implemented

1. **Security**: Prepared statements, password hashing, input validation
2. **Error Handling**: Try-catch blocks, meaningful error messages
3. **Code Organization**: Modular functions, reusable components
4. **Database Design**: Normalized schema, foreign keys, indexes
5. **API Design**: RESTful principles, consistent response format
6. **Documentation**: Clear comments and API documentation

## Future Enhancements

- JWT token-based authentication
- Rate limiting
- API versioning
- Automated testing suite
- Caching strategies
- Webhook support
- Multi-language support

## Troubleshooting

**Database connection failed**
- Check if MySQL is running
- Verify database credentials in `db_config.php`
- Ensure database exists

**Permission denied errors**
- Check file permissions
- Ensure XAMPP has proper access

**API returns 500 error**
- Check PHP error logs
- Verify database schema
- Review request format

## License

This project is for educational purposes.

## Contact

For issues and questions, create a GitHub issue or contact the development team.
