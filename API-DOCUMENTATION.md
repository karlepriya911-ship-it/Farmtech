# FarmTech Backend API - Complete Documentation

## API Reference Guide

### Base URL
```
http://localhost/Farmtech/backend/
```

## Table of Contents
1. Authentication APIs
2. Equipment APIs
3. Booking APIs
4. Payment APIs
5. Review APIs
6. Admin APIs
7. Error Codes
8. Response Examples

---

## 1. AUTHENTICATION APIs

### 1.1 User Registration

**Endpoint:** `POST /auth/register.php`

**Request Body:**
```json
{
  "name": "John Farmer",
  "email": "john@example.com",
  "phone": "9876543210",
  "role": "farmer",
  "password": "secure_password"
}
```

**Response (Success - 201):**
```json
{
  "message": "Registration successful",
  "user_id": 1,
  "role": "farmer"
}
```

**Response (Error - 409):**
```json
{
  "error": "Email is already registered"
}
```

**Validation Rules:**
- Name: required, not empty
- Email: required, valid format, must be unique
- Password: required, minimum 6 characters
- Role: 'farmer' or 'owner'

---

### 1.2 User Login

**Endpoint:** `POST /auth/login.php`

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "secure_password"
}
```

**Response (Success - 200):**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Farmer",
    "email": "john@example.com",
    "role": "farmer"
  }
}
```

**Response (Error - 401):**
```json
{
  "error": "Invalid email or password"
}
```

---

### 1.3 User Logout

**Endpoint:** `POST /auth/logout.php`

**Response (Success - 200):**
```json
{
  "message": "Logout successful"
}
```

---

### 1.4 Password Reset

**Endpoint:** `POST /auth/password_reset.php`

**Request Body:**
```json
{
  "email": "john@example.com",
  "new_password": "new_password_123"
}
```

**Response (Success - 200):**
```json
{
  "message": "Password reset successful"
}
```

---

## 2. EQUIPMENT APIs

### 2.1 Get Equipment List

**Endpoint:** `GET /equipment/view_equipment.php`

**Query Parameters:**
```
?search=tractor&category=tractor&location=Punjab&status=approved
```

**Response (Success - 200):**
```json
[
  {
    "id": 1,
    "name": "Tractor Pro 450",
    "category": "tractor",
    "location": "Punjab",
    "price_per_day": 850,
    "description": "High-power tractor...",
    "status": "approved",
    "rating": 4.8
  },
  {
    "id": 2,
    "name": "Rice Transplanter",
    "category": "transplanter",
    "location": "Haryana",
    "price_per_day": 620,
    "description": "Efficient transplanter...",
    "status": "approved",
    "rating": 4.6
  }
]
```

---

### 2.2 Get Equipment Details

**Endpoint:** `GET /equipment/get_details.php`

**Query Parameters:**
```
?id=1
```

**Response (Success - 200):**
```json
{
  "id": 1,
  "name": "Tractor Pro 450",
  "category": "tractor",
  "owner_id": 5,
  "owner_name": "Rajesh Kumar",
  "location": "Punjab",
  "price_per_day": 850,
  "description": "High-power tractor ideal for large farms...",
  "features": ["60 HP engine", "Fuel efficient", "4WD"],
  "status": "approved",
  "availability": 1,
  "rating": 4.8,
  "total_reviews": 24
}
```

---

### 2.3 Add New Equipment

**Endpoint:** `POST /equipment/add_equipment.php`

**Authentication:** Required (Owner role)

**Request Body:**
```json
{
  "owner_id": 5,
  "name": "New Tractor",
  "category": "tractor",
  "description": "Powerful tractor for farming",
  "price_per_day": 900,
  "location": "Punjab",
  "image": "path/to/image.jpg"
}
```

**Response (Success - 201):**
```json
{
  "message": "Equipment added successfully. Awaiting admin approval.",
  "equipment_id": 15
}
```

---

### 2.4 Update Equipment

**Endpoint:** `PUT /equipment/edit_equipment.php`

**Authentication:** Required (Owner)

**Request Body:**
```json
{
  "equipment_id": 1,
  "price_per_day": 950,
  "availability": 1
}
```

**Response (Success - 200):**
```json
{
  "message": "Equipment updated successfully"
}
```

---

### 2.5 Delete Equipment

**Endpoint:** `DELETE /equipment/delete_equipment.php`

**Authentication:** Required (Owner or Admin)

**Query Parameters:**
```
?equipment_id=1
```

**Response (Success - 200):**
```json
{
  "message": "Equipment deleted successfully"
}
```

---

## 3. BOOKING APIs

### 3.1 Create Booking

**Endpoint:** `POST /booking/create_booking.php`

**Authentication:** Required (Farmer)

**Request Body:**
```json
{
  "farmer_id": 2,
  "equipment_id": 1,
  "start_date": "2024-07-15",
  "end_date": "2024-07-20"
}
```

**Response (Success - 201):**
```json
{
  "message": "Booking request submitted successfully",
  "booking_id": 45,
  "total_amount": 4250,
  "days": 5
}
```

**Response (Error - 404):**
```json
{
  "error": "Equipment unavailable"
}
```

---

### 3.2 View User Bookings

**Endpoint:** `GET /booking/view_bookings.php`

**Query Parameters:**
```
?user_id=2&role=farmer
```

**Response (Success - 200):**
```json
[
  {
    "booking_id": 45,
    "equipment_name": "Tractor Pro 450",
    "start_date": "2024-07-15",
    "end_date": "2024-07-20",
    "total_amount": 4250,
    "status": "pending"
  }
]
```

---

### 3.3 Update Booking Status

**Endpoint:** `PUT /booking/update_status.php`

**Authentication:** Required (Owner or Admin)

**Request Body:**
```json
{
  "booking_id": 45,
  "status": "approved"
}
```

**Response (Success - 200):**
```json
{
  "message": "Booking status updated successfully"
}
```

**Status Options:** pending, approved, rejected, completed, cancelled

---

### 3.4 Cancel Booking

**Endpoint:** `DELETE /booking/cancel_booking.php`

**Query Parameters:**
```
?booking_id=45
```

**Response (Success - 200):**
```json
{
  "message": "Booking cancelled successfully"
}
```

---

## 4. PAYMENT APIs

### 4.1 Process Payment

**Endpoint:** `POST /payment/process_payment.php`

**Authentication:** Required (Farmer)

**Request Body:**
```json
{
  "booking_id": 45,
  "amount": 4250,
  "payment_method": "credit_card",
  "transaction_id": "TXN123456"
}
```

**Response (Success - 201):**
```json
{
  "message": "Payment processed successfully",
  "transaction_id": "TXN123456",
  "status": "paid"
}
```

---

### 4.2 Transaction History

**Endpoint:** `GET /payment/transaction_history.php`

**Query Parameters:**
```
?user_id=2
```

**Response (Success - 200):**
```json
[
  {
    "transaction_id": "TXN123456",
    "booking_id": 45,
    "amount": 4250,
    "payment_date": "2024-07-15",
    "status": "paid",
    "equipment_name": "Tractor Pro 450"
  }
]
```

---

## 5. REVIEW APIs

### 5.1 Add Review

**Endpoint:** `POST /reviews/add_review.php`

**Authentication:** Required (Farmer)

**Request Body:**
```json
{
  "farmer_id": 2,
  "equipment_id": 1,
  "rating": 5,
  "comment": "Excellent equipment! Very reliable."
}
```

**Response (Success - 201):**
```json
{
  "message": "Review added successfully"
}
```

**Validation Rules:**
- Rating: 1-5 (integer)
- Comment: optional, max 500 characters
- One review per farmer per equipment

---

### 5.2 Get Reviews

**Endpoint:** `GET /reviews/get_reviews.php`

**Query Parameters:**
```
?equipment_id=1
```

**Response (Success - 200):**
```json
[
  {
    "farmer_name": "John Farmer",
    "rating": 5,
    "comment": "Excellent equipment!",
    "created_at": "2024-07-25"
  },
  {
    "farmer_name": "Jane Farmer",
    "rating": 4,
    "comment": "Good condition",
    "created_at": "2024-07-20"
  }
]
```

---

## 6. ADMIN APIs

### 6.1 Admin Dashboard

**Endpoint:** `GET /admin/dashboard.php`

**Authentication:** Required (Admin role)

**Response (Success - 200):**
```json
{
  "total_users": 250,
  "total_equipment": 85,
  "pending_approvals": 12,
  "monthly_revenue": 125000,
  "active_bookings": 34,
  "total_payments": 500000
}
```

---

### 6.2 Manage Users

**Endpoint:** `GET /admin/manage_users.php`

**Authentication:** Required (Admin)

**Response (Success - 200):**
```json
[
  {
    "id": 1,
    "name": "John Farmer",
    "email": "john@example.com",
    "role": "farmer",
    "status": "active",
    "created_at": "2024-01-15"
  }
]
```

---

### 6.3 Approve Equipment

**Endpoint:** `PUT /admin/approve_equipment.php`

**Authentication:** Required (Admin)

**Request Body:**
```json
{
  "equipment_id": 15,
  "status": "approved"
}
```

**Response (Success - 200):**
```json
{
  "message": "Equipment approved successfully"
}
```

---

### 6.4 View Complaints

**Endpoint:** `GET /admin/complaints.php`

**Authentication:** Required (Admin)

**Response (Success - 200):**
```json
[
  {
    "id": 1,
    "user_name": "John Farmer",
    "subject": "Equipment not working",
    "message": "The tractor broke down...",
    "status": "open",
    "created_at": "2024-07-20"
  }
]
```

---

### 6.5 Resolve Complaint

**Endpoint:** `PUT /admin/resolve_complaint.php`

**Authentication:** Required (Admin)

**Request Body:**
```json
{
  "complaint_id": 1,
  "status": "resolved",
  "resolution": "Refund issued for equipment damage."
}
```

**Response (Success - 200):**
```json
{
  "message": "Complaint resolved successfully"
}
```

---

## 7. ERROR CODES

| Code | Message | Description |
|------|---------|-------------|
| 200 | OK | Request successful |
| 201 | Created | Resource created successfully |
| 400 | Bad Request | Invalid request format |
| 401 | Unauthorized | Authentication required |
| 403 | Forbidden | Insufficient permissions |
| 404 | Not Found | Resource not found |
| 409 | Conflict | Resource already exists |
| 422 | Unprocessable Entity | Validation error |
| 500 | Server Error | Internal server error |

---

## 8. COMMON RESPONSE PATTERNS

### Success Pattern
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { }
}
```

### Error Pattern
```json
{
  "success": false,
  "error": "Error description",
  "code": 400
}
```

### Validation Error Pattern
```json
{
  "error": "Validation failed",
  "errors": {
    "email": "Email is required",
    "password": "Password must be at least 6 characters"
  }
}
```

---

## Testing Tips

1. **Use Postman** for API testing
2. **Set headers** to `Content-Type: application/json`
3. **Include authentication** when required
4. **Check status codes** for response validation
5. **Log responses** for debugging

---

**API Version:** 1.0
**Last Updated:** 2024
**Status:** Production Ready
