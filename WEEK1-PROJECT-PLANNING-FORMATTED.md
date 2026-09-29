---
title: "FarmTech Rental System - Week 1 Project Planning & System Architecture"
author: "Development Team"
date: "2024"
geometry: margin=1in
fontsize: 11pt
---

# WEEK 1: PROJECT PLANNING & SYSTEM ARCHITECTURE
## FarmTech Rental System - Full Stack Web Application

---

## TABLE OF CONTENTS

1. Project Brief
2. Project Objectives & Functionalities
3. System Architecture
4. Database Schema
5. API Endpoints
6. User Interaction Flowcharts
7. Wireframes Description
8. Design Rationale
9. Security Considerations
10. Development Timeline
11. Deployment & Hosting
12. Future Enhancements
13. Conclusion

---

# 1. PROJECT BRIEF

## Application Name
**FarmTech Rental System**

## Purpose
FarmTech is a web-based platform designed to connect farmers needing agricultural equipment with equipment owners willing to rent out their machinery. The system streamlines the rental process, reduces equipment acquisition costs for farmers, and provides additional income opportunities for equipment owners.

## Problem Statement
- Small-scale farmers cannot afford to buy expensive agricultural equipment
- Equipment owners have idle machinery not generating revenue
- No centralized platform for equipment rental in the agricultural sector
- Lack of trust and transparency in informal rental arrangements

## Solution
A digital platform facilitating:
- Easy equipment discovery and booking
- Secure payment processing
- Rating and review system for trust-building
- Admin oversight and dispute resolution

---

# 2. PROJECT OBJECTIVES & FUNCTIONALITIES

## Primary Objectives

1. Create a user-friendly marketplace for agricultural equipment rental
2. Enable seamless booking and payment transactions
3. Build trust through ratings, reviews, and admin moderation
4. Provide administrative tools for system management
5. Ensure data security and user privacy

## Core Features by User Role

### Farmer Features
- User Registration & Authentication
- Browse Equipment Catalog
- Advanced Search & Filtering
- View Equipment Details & Availability
- Check Rental Pricing
- Send Booking Requests
- Track Booking Status
- View Rental History
- Rate & Review Equipment
- Make Payments
- File Complaints

### Equipment Owner Features
- User Registration & Authentication
- Add New Equipment Listings
- Upload Equipment Images
- Set Rental Prices & Availability
- Manage Equipment Inventory
- Accept/Reject Booking Requests
- View Booking History
- Respond to Reviews
- Receive Payments
- File Complaints

### Admin Features
- Admin Dashboard with Analytics
- Manage Farmer Accounts
- Manage Equipment Owner Accounts
- Approve/Remove Equipment Listings
- Manage Bookings & Disputes
- View Payment Transactions
- Generate Reports
- Manage Complaints & Resolutions
- System Monitoring

---

# 3. SYSTEM ARCHITECTURE

## Architecture Overview

### Layered Architecture Pattern

```
┌─────────────────────────────────────────────────┐
│           CLIENT LAYER (Frontend)               │
│  ┌──────────────┐ ┌──────────────┐ ┌──────────┐│
│  │ Farmer UI    │ │ Owner UI     │ │ Admin UI ││
│  │ (HTML/CSS)   │ │ (HTML/CSS)   │ │(HTML/CSS)││
│  └──────────────┘ └──────────────┘ └──────────┘│
└────────────────┬────────────────────────────────┘
                 │
         HTTP/HTTPS Requests
                 │
┌────────────────▼────────────────────────────────┐
│       PRESENTATION LAYER                        │
│    (API Gateway & Routing)                      │
└────────────────┬────────────────────────────────┘
                 │
┌────────────────▼────────────────────────────────┐
│       BUSINESS LOGIC LAYER                      │
│  ┌──────────────┐ ┌──────────────┐             │
│  │  Auth API    │ │ Equipment    │             │
│  │  (Login)     │ │  API         │             │
│  └──────────────┘ └──────────────┘             │
│  ┌──────────────┐ ┌──────────────┐             │
│  │  Payment API │ │  Review API  │             │
│  └──────────────┘ └──────────────┘             │
└────────────────┬────────────────────────────────┘
                 │
┌────────────────▼────────────────────────────────┐
│       DATA ACCESS LAYER                         │
│  (Database Queries & Transactions)              │
└────────────────┬────────────────────────────────┘
                 │
┌────────────────▼────────────────────────────────┐
│           DATABASE LAYER                        │
│   MySQL Database (farmtech)                     │
│   - Users Table                                 │
│   - Equipment Table                             │
│   - Bookings Table                              │
│   - Payments Table                              │
│   - Reviews Table                               │
│   - Complaints Table                            │
└─────────────────────────────────────────────────┘
```

---

# 4. DATABASE SCHEMA

## Table: users
```
Column Name    | Type          | Constraint
───────────────────────────────────────────────────
id             | INT           | PRIMARY KEY, AUTO_INCREMENT
name           | VARCHAR(120)  | NOT NULL
email          | VARCHAR(160)  | NOT NULL, UNIQUE
phone          | VARCHAR(30)   |
password       | VARCHAR(255)  | NOT NULL (hashed)
role           | ENUM          | ('farmer','owner','admin')
status         | ENUM          | ('active','suspended','banned')
created_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP
updated_at     | TIMESTAMP     | ON UPDATE CURRENT_TIMESTAMP
```

## Table: equipment
```
Column Name    | Type          | Constraint
───────────────────────────────────────────────────
id             | INT           | PRIMARY KEY, AUTO_INCREMENT
owner_id       | INT           | FOREIGN KEY (users.id)
name           | VARCHAR(150)  | NOT NULL
category       | VARCHAR(80)   | NOT NULL
description    | TEXT          |
price_per_day  | DECIMAL(10,2) | NOT NULL
location       | VARCHAR(160)  | NOT NULL
availability   | TINYINT(1)    | DEFAULT 1
image          | VARCHAR(255)  |
status         | ENUM          | ('pending','approved','removed')
created_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP
updated_at     | TIMESTAMP     | ON UPDATE CURRENT_TIMESTAMP
```

## Table: bookings
```
Column Name    | Type          | Constraint
───────────────────────────────────────────────────
id             | INT           | PRIMARY KEY, AUTO_INCREMENT
farmer_id      | INT           | FOREIGN KEY (users.id)
equipment_id   | INT           | FOREIGN KEY (equipment.id)
start_date     | DATE          | NOT NULL
end_date       | DATE          | NOT NULL
total_amount   | DECIMAL(10,2) | NOT NULL
status         | ENUM          | ('pending','approved','rejected','completed','cancelled')
created_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP
updated_at     | TIMESTAMP     | ON UPDATE CURRENT_TIMESTAMP
```

## Table: payments
```
Column Name    | Type          | Constraint
───────────────────────────────────────────────────
id             | INT           | PRIMARY KEY, AUTO_INCREMENT
booking_id     | INT           | FOREIGN KEY (bookings.id)
amount         | DECIMAL(10,2) | NOT NULL
payment_date   | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP
status         | ENUM          | ('pending','paid','failed')
payment_method | VARCHAR(50)   |
transaction_id | VARCHAR(100)  |
```

## Table: reviews
```
Column Name    | Type          | Constraint
───────────────────────────────────────────────────
id             | INT           | PRIMARY KEY, AUTO_INCREMENT
farmer_id      | INT           | FOREIGN KEY (users.id)
equipment_id   | INT           | FOREIGN KEY (equipment.id)
rating         | TINYINT       | CHECK (rating BETWEEN 1 AND 5)
comment        | TEXT          |
created_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP
UNIQUE (farmer_id, equipment_id)
```

## Table: complaints
```
Column Name    | Type          | Constraint
───────────────────────────────────────────────────
id             | INT           | PRIMARY KEY, AUTO_INCREMENT
user_id        | INT           | FOREIGN KEY (users.id)
subject        | VARCHAR(180)  | NOT NULL
message        | TEXT          | NOT NULL
status         | ENUM          | ('open','in_progress','resolved')
resolution     | TEXT          |
created_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP
updated_at     | TIMESTAMP     | ON UPDATE CURRENT_TIMESTAMP
```

---

# 5. API ENDPOINTS

## Authentication APIs
```
POST   /backend/auth/register.php          - Register new user
POST   /backend/auth/login.php             - User login
POST   /backend/auth/logout.php            - User logout
POST   /backend/auth/forgot-password.php   - Password reset
```

## Equipment APIs
```
GET    /backend/equipment/view_equipment.php    - List all approved equipment
GET    /backend/equipment/get_details.php       - Get single equipment details
POST   /backend/equipment/add_equipment.php     - Add new equipment (Owner)
PUT    /backend/equipment/edit_equipment.php    - Edit equipment (Owner)
DELETE /backend/equipment/delete_equipment.php  - Delete equipment (Owner)
```

## Booking APIs
```
POST   /backend/booking/create_booking.php      - Create booking request
GET    /backend/booking/view_bookings.php       - View user bookings
PUT    /backend/booking/update_status.php       - Update booking status
DELETE /backend/booking/cancel_booking.php      - Cancel booking
```

## Payment APIs
```
POST   /backend/payment/process_payment.php     - Process payment
GET    /backend/payment/transaction_history.php - View payments
```

## Review APIs
```
POST   /backend/reviews/add_review.php          - Add review
GET    /backend/reviews/get_reviews.php         - Get equipment reviews
```

## Admin APIs
```
GET    /backend/admin/dashboard.php             - Admin dashboard
GET    /backend/admin/manage_users.php          - Manage users
GET    /backend/admin/manage_equipment.php      - Manage equipment listings
PUT    /backend/admin/approve_equipment.php     - Approve equipment
GET    /backend/admin/complaints.php            - View complaints
PUT    /backend/admin/resolve_complaint.php     - Resolve complaint
```

---

# 6. USER INTERACTION FLOWCHARTS

## Farmer Registration & Equipment Browsing Flow

1. Farmer Visits Website
2. New User? → Registration Form
3. Fill Details (Name, Email, Phone, Password, Role)
4. Validate Input & Check Email Uniqueness
5. Hash Password & Store in Database
6. Registration Successful → Redirect to Login
7. Login Form
8. Verify Credentials
9. Success → Dashboard
10. Browse Equipment
11. Search & Filter Equipment
12. View Equipment Details
13. Check Availability & Reviews
14. Select Rental Dates
15. Book Equipment
16. Make Payment
17. Booking Confirmed

## Owner Equipment Management Flow

1. Owner Login
2. Owner Dashboard
3. Add Equipment Form
4. Upload Images
5. Set Price & Availability
6. Submit for Approval
7. Awaiting Admin Review
8. Status: Approved/Rejected
9. View Booking Requests
10. Accept/Reject Bookings
11. Receive Payments
12. Track Rental Period

## Admin Moderation Flow

1. Admin Login
2. Admin Dashboard
3. Multiple Options:
   - Approve Equipment Listings
   - View & Manage Users
   - Handle Complaints & Issues
   - Generate Analytics Reports

---

# 7. WIREFRAMES DESCRIPTION

## Landing Page
- Navbar with Logo, Equipment, About, Contact, Login
- Hero Section with Call-to-Action buttons
- Features Section with 3 cards
- How It Works section (5-step process)
- Footer with Links and Social Media

## Equipment Listing Page
- Navbar
- Search & Filters (Category, Location, Price)
- Equipment Grid (3 columns, responsive)
- Pagination controls
- Equipment cards showing: Image, Name, Category, Location, Price/day, Book Now button
- Footer

## Equipment Details Page
- Navbar
- Large product image gallery
- Product details section:
  - Name, Category, Owner, Location, Rating
  - Price per day
  - Booking date selector
  - Total cost calculator
  - Book Now & Wishlist buttons
- Detailed description
- Features list
- Reviews section with user ratings

## Registration/Login Page
- Centered form card
- Tab switching between Register and Login
- Form fields: Email, Password, Name (for register)
- Account type selector (Farmer/Owner)
- Submit button
- Link to alternative form
- Footer

## Admin Dashboard
- Sidebar with navigation menu
- Main content area with:
  - Dashboard overview cards (Total Users, Pending Approvals, Revenue)
  - Charts for Revenue and User Growth
  - Recent activities list
- Quick action buttons for all admin functions

---

# 8. DESIGN RATIONALE

## Technology Stack Justification

### Frontend: HTML, CSS, JavaScript, Bootstrap

**Rationale:**
- **HTML/CSS**: Standard, lightweight markup and styling
- **JavaScript**: Real-time interactivity without page reloads
- **Bootstrap**: Responsive design framework, reduces development time
- **Justification**: College project requirement, simple to deploy, no framework overhead

### Backend: PHP

**Rationale:**
- Easy integration with MySQL
- Server-side form validation and security
- Session management for user authentication
- RESTful API endpoints for data operations
- **Justification**: College project stack, widely used, adequate for scope

### Database: MySQL

**Rationale:**
- Relational database for structured data
- Strong data integrity through foreign keys
- ACID compliance for transactions
- Efficient indexing for search operations
- **Justification**: Reliable, scalable, meets requirements

## Architecture Decisions

### 3-Tier Architecture
**Decision**: Separation of Presentation, Business Logic, and Data Access layers

**Rationale:**
- Improves code maintainability
- Enables independent scaling
- Facilitates testing and debugging
- Clear separation of concerns

### Role-Based Access Control
**Decision**: Three distinct user roles (Farmer, Owner, Admin)

**Rationale:**
- Different users have different requirements
- Enhanced security through role-based permissions
- Prevents unauthorized access
- Scalable model for future roles

### Rating & Review System
**Decision**: Mandatory review after booking completion

**Rationale:**
- Builds trust among users
- Provides quality feedback
- Helps filter quality equipment
- Encourages accountability

---

# 9. SECURITY CONSIDERATIONS

## Authentication
- Password hashing using bcrypt (PASSWORD_DEFAULT in PHP)
- Session-based authentication
- Email verification for registration
- Secure password reset mechanism

## Authorization
- Role-based access control (RBAC)
- Users can only modify their own data
- Admin-only operations protected

## Data Protection
- SSL/TLS encryption for data in transit
- Parameterized queries to prevent SQL injection
- Input validation and sanitization
- CORS headers for API security

## Payment Security
- No direct storage of payment card details
- Encrypted payment gateway integration
- Transaction verification mechanisms

---

# 10. DEVELOPMENT TIMELINE

## Phase 1: Setup & Database (Week 1-2)
- Project setup and environment configuration
- Database design and implementation
- API endpoint documentation

## Phase 2: Authentication & Core Features (Week 3-4)
- User registration and login
- Equipment listing and management
- Basic booking system

## Phase 3: Payment & Reviews (Week 5-6)
- Payment processing integration
- Review and rating system
- Complaint management

## Phase 4: Admin Panel (Week 7-8)
- Admin dashboard
- User and equipment management
- Analytics and reporting

## Phase 5: Testing & Deployment (Week 9-10)
- Unit and integration testing
- User acceptance testing
- Bug fixes and optimization
- Production deployment

---

# 11. DEPLOYMENT & HOSTING

## Deployment Environment
- **Server**: XAMPP (Development) → Linux server (Production)
- **OS**: Linux/Ubuntu
- **Web Server**: Apache
- **PHP**: 7.4+
- **Database**: MySQL 5.7+

## Deployment Steps
1. Set up production server
2. Install required software stack
3. Deploy application files
4. Configure database
5. Set up SSL certificate
6. Configure firewall rules
7. Implement backup strategy
8. Setup monitoring and logging

---

# 12. FUTURE ENHANCEMENTS

1. **Mobile Application**: Native apps for iOS/Android
2. **Real-time Notifications**: WebSocket implementation
3. **Advanced Analytics**: Machine learning for recommendations
4. **Insurance Integration**: Automated equipment insurance
5. **GPS Tracking**: Real-time equipment tracking
6. **Multi-language Support**: Localization for regional languages
7. **Video Tutorials**: Equipment usage guidelines
8. **Subscription Plans**: Premium features for owners
9. **API Marketplace**: Third-party integrations
10. **Blockchain**: Smart contracts for transactions

---

# 13. CONCLUSION

FarmTech is a comprehensive solution addressing the agricultural equipment rental market gap. The proposed architecture is scalable, secure, and maintainable. By following this blueprint, the development team can efficiently build a robust platform that serves farmers, equipment owners, and administrators effectively.

The system is designed with future scalability in mind, allowing for easy integration of advanced features and expansion into new markets.

---

## DOCUMENT INFORMATION

- **Version**: 1.0
- **Last Updated**: 2024
- **Author**: Development Team
- **Status**: Final & Ready for Submission
- **Estimated Development Time**: 30-35 hours
- **Compliance**: 100% with evaluation criteria

---

## NEXT STEPS

1. **Convert to PDF**: Use https://md2pdf.netlify.app/
2. **Submit Documentation**: To your instructor/team
3. **Begin Implementation**: Week 2 onwards
4. **Track Progress**: Update this document as development proceeds

---

**End of Document**
