# FarmTech Rental System

A comprehensive web-based platform for renting agricultural equipment between farmers and equipment owners.

## 🌾 Overview

FarmTech is a college project that simplifies agricultural equipment rental management. Farmers can browse, search, and book equipment, while equipment owners can list and manage their inventory. Admins oversee the entire system.

## 👥 User Roles

### Farmer
- Register and login
- View available equipment
- Search and filter equipment
- Check rental prices and availability
- Send rental/booking requests
- Track booking status
- View rental history
- Rate and review equipment

### Equipment Owner
- Register and login
- Add and manage equipment
- Upload equipment images
- Set rental prices and availability
- Accept/reject rental requests
- View booking history

### Admin
- Manage farmers and equipment owners
- Approve/remove equipment listings
- Manage bookings and complaints
- View users and transactions
- Access dashboard with statistics

## 🛠️ Technologies

- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Backend:** PHP
- **Database:** MySQL
- **Development Environment:** VS Code / XAMPP
- **Version Control:** Git & GitHub

## 📦 Project Structure

```
Farmtech/
├── frontend/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   ├── index.html
│   ├── login.html
│   ├── register.html
│   ├── equipment.html
│   ├── equipment-details.html
│   ├── dashboard-farmer.html
│   ├── dashboard-owner.html
│   └── admin-dashboard.html
│
├── backend/
│   ├── config/
│   │   └── db_config.php
│   ├── auth/
│   │   ├── login.php
│   │   ├── register.php
│   │   └── logout.php
│   ├── equipment/
│   │   ├── add_equipment.php
│   │   ├── view_equipment.php
│   │   └── edit_equipment.php
│   ├── booking/
│   │   ├── create_booking.php
│   │   ├── view_bookings.php
│   │   └── update_booking_status.php
│   ├── payment/
│   │   └── process_payment.php
│   ├── reviews/
│   │   └── add_review.php
│   └── admin/
│       ├── manage_users.php
│       ├── manage_equipment.php
│       └── dashboard.php
│
├── database/
│   └── farmtech.sql
│
├── assets/
│   ├── images/
│   └── icons/
│
└── .gitignore
```

## 🗄️ Database Tables

- `users` - User accounts and authentication
- `farmers` - Farmer-specific information
- `equipment_owners` - Owner-specific information
- `equipment` - Equipment listings
- `bookings` - Rental bookings
- `payments` - Payment records
- `reviews` - Equipment ratings and reviews
- `complaints` - User complaints
- `admin` - Admin accounts

## 📋 Requirements

### Software
- VS Code
- XAMPP (or similar PHP server)
- MySQL / phpMyAdmin
- Git
- Modern web browser

### Hardware
- 4 GB RAM minimum
- 10 GB free storage
- Internet connection

## 🚀 Getting Started

1. **Clone the repository**
   ```bash
   git clone https://github.com/karlepriya911-ship-it/Farmtech.git
   cd Farmtech
   ```

2. **Set up XAMPP**
   - Start Apache and MySQL services
   - Place project in `htdocs` folder

3. **Create Database**
   - Import `database/farmtech.sql` into MySQL using phpMyAdmin

4. **Configure Database Connection**
   - Update `backend/config/db_config.php` with your database credentials

5. **Run Application**
   - Access via `http://localhost/Farmtech/frontend/index.html`

## 📝 Features Implemented

- User authentication (Farmer, Owner, Admin)
- Equipment listing and search
- Booking management
- Payment processing
- Review and rating system
- Admin dashboard
- User management

## 👨‍💻 Contributors

- [karlepriya911-ship-it](https://github.com/karlepriya911-ship-it)

## 📄 License

This project is created for educational purposes.

## 📞 Support

For issues or suggestions, please create an issue in the repository.

---

**Happy Farming! 🌾**
