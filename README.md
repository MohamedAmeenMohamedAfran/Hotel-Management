# 🏨 Inshaf Hotel Management System

[![PHP Version](https://img.shields.io/badge/PHP-7.4+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A comprehensive, modern hotel management system built with PHP, MySQL, and Bootstrap. Perfect for managing hotel operations including room management, guest management, booking system, and administrative functions.

## 📋 Table of Contents

- [Features](#-features)
- [Screenshots](#-screenshots)
- [Installation](#-installation)
- [Quick Start](#-quick-start)
- [Project Structure](#-project-structure)
- [Architecture Overview](#-architecture-overview)
- [API Documentation](#-api-documentation)
- [Contributing](#-contributing)
- [Support](#-support)

## ✨ Features

### 🏠 **Room Management**
- Complete CRUD operations for rooms
- Room types (Standard, Deluxe, Suite, Executive)
- Real-time availability tracking
- Price management and occupancy limits
- Maintenance status tracking

### 👥 **Guest Management**
- Comprehensive guest profiles
- Contact information management
- Guest history and preferences
- Search and filter capabilities

### 📅 **Booking System**
- Full booking lifecycle management
- Real-time availability checking
- Automatic pricing calculations
- Check-in/Check-out management
- Payment status tracking
- Special requests handling

### 📊 **Analytics Dashboard**
- Real-time occupancy statistics
- Revenue tracking
- Interactive charts and graphs
- Recent booking activities
- Performance metrics

### 🔐 **Security Features**
- Secure admin authentication
- Password hashing with PHP's `password_hash()`
- Session management
- SQL injection prevention with PDO
- XSS protection

### 📱 **Modern UI/UX**
- Responsive Bootstrap 5 design
- Mobile-friendly interface
- Interactive charts with Chart.js
- Smooth animations and transitions
- Professional color scheme

## 🖼️ Screenshots

### Dashboard Overview
```
┌─────────────────────────────────────────────────────────────┐
│ 🏨 Inshaf Hotel - Management System                        │
├─────────────────────────────────────────────────────────────┤
│ 📊 Dashboard                                                │
│                                                             │
│ ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐           │
│ │ 🏠 Total│ │ ✅ Avail│ │ 🔴 Booked│ │ 👥 Guests│           │
│ │ Rooms   │ │ Rooms   │ │ Rooms   │ │         │           │
│ │   4     │ │   2     │ │   1     │ │   3     │           │
│ └─────────┘ └─────────┘ └─────────┘ └─────────┘           │
│                                                             │
│ ┌─────────────────────────────────┐ ┌─────────────────────┐ │
│ │ 📈 Occupancy Trend Chart       │ │ 🥧 Room Status      │ │
│ │                                │ │ Distribution        │ │
│ │     ┌─┐                        │ │                     │ │
│ │ 100 │ │ ┌─┐                    │ │ 🟢 Available: 50%   │ │
│ │  80 │ │ │ │ ┌─┐                │ │ 🔴 Booked: 25%      │ │
│ │  60 │ │ │ │ │ │                │ │ 🟡 Maintenance: 25% │ │
│ │  40 └─┘ └─┘ └─┘                │ │                     │ │
│ │  20                            │ │                     │ │
│ │   0 Jan Feb Mar Apr            │ │                     │ │
│ └─────────────────────────────────┘ └─────────────────────┘ │
└─────────────────────────────────────────────────────────────┘
```

### Room Management
```
┌─────────────────────────────────────────────────────────────┐
│ 🏠 Room Management                                          │
│                                                             │
│ 🔍 Search & Filter Rooms                                    │
│ ┌─────────────────────────────────────────────────────────┐ │
│ │ Search: [________________] Status: [All ▼] [🔍] [✕]    │ │
│ └─────────────────────────────────────────────────────────┘ │
│                                                             │
│ 📋 Room Management                                          │
│ ┌────┬─────┬─────────┬─────────┬─────────┬──────────────┬────┐ │
│ │ #  │Type │ Price   │ Status  │ Occupancy│ Amenities    │Actions│ │
│ ├────┼─────┼─────────┼─────────┼─────────┼──────────────┼────┤ │
│ │101 │Std  │ $150.00 │ ✅ Avail│ 2 guests │WiFi, TV, AC │ ✏️ 🗑️ │ │
│ │102 │Std  │ $150.00 │ 🔴 Booked│ 2 guests │WiFi, TV, AC │ ✏️ 🗑️ │ │
│ │201 │Deluxe│$250.00 │ ✅ Avail│ 3 guests │WiFi, TV, AC │ ✏️ 🗑️ │ │
│ └────┴─────┴─────────┴─────────┴─────────┴──────────────┴────┘ │
│                                                             │
│ [+ Add New Room]                                            │
└─────────────────────────────────────────────────────────────┘
```

## 🚀 Installation

### Prerequisites
- **XAMPP** (Apache + MySQL + PHP)
- **Web Browser** (Chrome, Firefox, Safari, Edge)
- **Code Editor** (VS Code recommended)

### Step-by-Step Installation

1. **Download and Install XAMPP**
   ```bash
   # Download from: https://www.apachefriends.org/
   # Install and start Apache + MySQL services
   ```

2. **Setup Project Files**
   ```bash
   # Navigate to XAMPP htdocs directory
   cd C:\xampp\htdocs\  # Windows
   cd /Applications/XAMPP/htdocs/  # macOS
   
   # Create project directory
   mkdir inshaf-hotel
   cd inshaf-hotel
   
   # Copy all project files here
   ```

3. **Setup Database**
   ```bash
   # Open browser and navigate to:
   http://localhost/inshaf-hotel/simple_setup.php
   
   # Click "Run Database Setup"
   # Wait for "Setup Complete!" message
   ```

4. **Access the System**
   ```bash
   # Main application
   http://localhost/inshaf-hotel/public/index.php
   
   # Simple login page
   http://localhost/inshaf-hotel/simple_login.php
   ```

5. **Login Credentials**
   ```
   Username: admin
   Password: admin123
   ```

## ⚡ Quick Start

### For New Developers
1. **Read the Quick Start Guide**: [`QUICK_START_GUIDE.md`](QUICK_START_GUIDE.md)
2. **Follow the 15-minute setup** guide
3. **Make your first change** by modifying text in a view file
4. **Explore the codebase** using the file structure guide

### For Experienced Developers
1. **Read the Developer Documentation**: [`DEVELOPER_DOCUMENTATION.md`](DEVELOPER_DOCUMENTATION.md)
2. **Review the architecture** and MVC implementation
3. **Check the database schema** and relationships
4. **Start contributing** by adding new features

## 📁 Project Structure

```
inshaf-hotel/
├── 📁 config/                    # Configuration files
│   └── db.php                   # Database connection settings
├── 📁 controllers/              # MVC Controllers (Business Logic)
│   ├── AdminController.php      # Admin operations & authentication
│   ├── BookingController.php    # Booking management & lifecycle
│   ├── GuestController.php      # Guest management & profiles
│   └── RoomController.php       # Room management & availability
├── 📁 database/                 # Database structure & migrations
│   └── schema.sql              # Complete database schema
├── 📁 models/                   # MVC Models (Data Layer)
│   ├── BaseModel.php           # Base model with common operations
│   ├── AdminModel.php          # Admin data operations
│   ├── BookingModel.php        # Booking data & calculations
│   ├── GuestModel.php          # Guest data operations
│   └── RoomModel.php           # Room data & availability
├── 📁 public/                   # Public entry point
│   └── index.php               # Main application router
├── 📁 views/                    # MVC Views (Presentation Layer)
│   ├── 📁 admin/
│   │   ├── dashboard.php       # Admin dashboard with analytics
│   │   └── login.php           # Admin login interface
│   ├── 📁 bookings/
│   │   ├── add.php             # Create new booking form
│   │   ├── edit.php            # Edit existing booking
│   │   └── list.php            # Booking management table
│   ├── 📁 guests/
│   │   ├── add.php             # Add new guest form
│   │   ├── edit.php            # Edit guest information
│   │   └── list.php            # Guest management table
│   ├── 📁 layout/
│   │   ├── header.php          # Common header & navigation
│   │   └── footer.php          # Common footer & scripts
│   └── 📁 rooms/
│       ├── add.php             # Add new room form
│       ├── edit.php            # Edit room information
│       └── list.php            # Room management table
├── index.php                    # Root redirect to login
├── simple_login.php            # Simple login interface
├── simple_setup.php            # Database setup script
├── test_connection.php         # Database connection testing
├── README.md                   # This file
├── QUICK_START_GUIDE.md        # Beginner-friendly guide
└── DEVELOPER_DOCUMENTATION.md  # Comprehensive developer guide
```

## 🏗️ Architecture Overview

### MVC Pattern Implementation

```
┌─────────────────────────────────────────────────────────────┐
│                    USER REQUEST                             │
└─────────────────────┬───────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                public/index.php                            │
│              (Router & Entry Point)                        │
└─────────────────────┬───────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                CONTROLLER LAYER                             │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐          │
│  │ AdminCtrl   │ │ RoomCtrl    │ │ BookingCtrl │          │
│  │             │ │             │ │             │          │
│  └─────────────┘ └─────────────┘ └─────────────┘          │
└─────────────────────┬───────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                 MODEL LAYER                                 │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐          │
│  │ AdminModel  │ │ RoomModel   │ │ BookingModel│          │
│  │             │ │             │ │             │          │
│  └─────────────┘ └─────────────┘ └─────────────┘          │
└─────────────────────┬───────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                DATABASE LAYER                               │
│  ┌─────────────────────────────────────────────────────────┐│
│  │                 MySQL Database                          ││
│  │  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐      ││
│  │  │ admins  │ │ guests  │ │ rooms   │ │bookings │      ││
│  │  └─────────┘ └─────────┘ └─────────┘ └─────────┘      ││
│  └─────────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                 VIEW LAYER                                  │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐          │
│  │ Dashboard   │ │ Room List   │ │ Booking Form│          │
│  │             │ │             │ │             │          │
│  └─────────────┘ └─────────────┘ └─────────────┘          │
└─────────────────────────────────────────────────────────────┘
                      │
┌─────────────────────▼───────────────────────────────────────┐
│                HTML RESPONSE                                │
└─────────────────────────────────────────────────────────────┘
```

### Request Flow
1. **User Request** → Browser sends HTTP request
2. **Router** → `public/index.php` determines controller/action
3. **Controller** → Processes request, calls appropriate model
4. **Model** → Performs database operations
5. **Controller** → Gets data, prepares for view
6. **View** → Renders HTML with data
7. **Response** → HTML sent back to browser

### Database Relationships
```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│   guests    │    │  bookings   │    │    rooms    │
│             │    │             │    │             │
│ guest_id ───┼────┼──► guest_id │    │             │
│ name        │    │ room_id ────┼────┼──► room_id  │
│ email       │    │ check_in    │    │ room_number │
│ phone       │    │ check_out   │    │ room_type   │
│ address     │    │ status      │    │ price       │
│ created_at  │    │ amount      │    │ status      │
└─────────────┘    └─────────────┘    └─────────────┘
```

## 📊 Database Schema

### Core Tables

#### `admins` - Administrator Accounts
| Column | Type | Description |
|--------|------|-------------|
| admin_id | INT | Primary key |
| username | VARCHAR(50) | Unique login username |
| password_hash | VARCHAR(255) | Hashed password |
| role | ENUM | Admin role (Super Admin, Manager, Staff) |
| full_name | VARCHAR(100) | Admin full name |
| email | VARCHAR(100) | Admin email address |
| created_at | TIMESTAMP | Account creation time |

#### `guests` - Guest Information
| Column | Type | Description |
|--------|------|-------------|
| guest_id | INT | Primary key |
| name | VARCHAR(100) | Guest full name |
| email | VARCHAR(100) | Unique email address |
| phone | VARCHAR(20) | Contact phone number |
| address | TEXT | Guest address |
| created_at | TIMESTAMP | Registration time |

#### `rooms` - Room Management
| Column | Type | Description |
|--------|------|-------------|
| room_id | INT | Primary key |
| room_number | VARCHAR(10) | Unique room identifier |
| room_type | VARCHAR(50) | Room category |
| price | DECIMAL(10,2) | Price per night |
| status | ENUM | Current status (Available, Booked, Maintenance) |
| amenities | TEXT | Room amenities |
| max_occupancy | INT | Maximum guests allowed |
| created_at | TIMESTAMP | Room creation time |

#### `bookings` - Reservation Management
| Column | Type | Description |
|--------|------|-------------|
| booking_id | INT | Primary key |
| guest_id | INT | Foreign key to guests |
| room_id | INT | Foreign key to rooms |
| check_in | DATE | Check-in date |
| check_out | DATE | Check-out date |
| status | ENUM | Booking status (Pending, Confirmed, Active, Completed, Cancelled) |
| payment_status | ENUM | Payment status (Pending, Paid, Partial, Refunded) |
| total_amount | DECIMAL(10,2) | Total booking amount |
| special_requests | TEXT | Guest special requests |
| created_at | TIMESTAMP | Booking creation time |

## 🛠️ Development Guide

### Adding New Features

#### 1. Create Model
```php
// models/NewFeatureModel.php
class NewFeatureModel extends BaseModel {
    protected $table = 'new_feature';
    
    public function getCustomData() {
        // Custom data retrieval logic
    }
}
```

#### 2. Create Controller
```php
// controllers/NewFeatureController.php
class NewFeatureController {
    private $newFeatureModel;
    
    public function list() {
        $data = $this->newFeatureModel->getCustomData();
        include '../views/newfeature/list.php';
    }
}
```

#### 3. Create View
```php
// views/newfeature/list.php
<?php include __DIR__ . '/../layout/header.php'; ?>
<!-- Your HTML content -->
<?php include __DIR__ . '/../layout/footer.php'; ?>
```

#### 4. Update Router
```php
// Add to public/index.php
case 'newfeature':
    include_once __DIR__ . '/../controllers/NewFeatureController.php';
    $controller = new NewFeatureController();
    break;
```

### Code Standards

#### PHP Coding Standards
- Use PSR-12 coding style
- Always use prepared statements for database queries
- Validate and sanitize all user inputs
- Use meaningful variable and function names

#### Security Best Practices
- Hash passwords with `password_hash()`
- Use CSRF tokens for forms
- Escape output with `htmlspecialchars()`
- Validate file uploads

#### Database Best Practices
- Use foreign keys for data integrity
- Create indexes for frequently queried columns
- Use transactions for multiple related operations
- Regular database backups

## 🧪 Testing

### Manual Testing Checklist

#### Authentication
- [ ] Admin login works with correct credentials
- [ ] Admin login fails with incorrect credentials
- [ ] Session persists after login
- [ ] Logout destroys session

#### Room Management
- [ ] Add new room with valid data
- [ ] Edit existing room information
- [ ] Delete room (with confirmation)
- [ ] Search and filter rooms

#### Guest Management
- [ ] Add new guest with valid information
- [ ] Edit guest details
- [ ] Delete guest (with confirmation)
- [ ] Search guests by name/email/phone

#### Booking System
- [ ] Create booking with valid dates
- [ ] Check room availability
- [ ] Calculate total amount correctly
- [ ] Check-in and check-out processes
- [ ] Cancel bookings

#### Dashboard
- [ ] Statistics display correctly
- [ ] Charts render properly
- [ ] Recent bookings show up
- [ ] Responsive design works

### Automated Testing (Future Enhancement)
```bash
# Run PHPUnit tests (when implemented)
composer install
vendor/bin/phpunit tests/
```

## 🚀 Deployment

### Production Deployment Checklist

#### Server Requirements
- [ ] PHP 7.4+ with required extensions
- [ ] MySQL 5.7+ or MariaDB 10.3+
- [ ] Apache 2.4+ or Nginx 1.18+
- [ ] SSL certificate for HTTPS

#### Security Configuration
- [ ] Change default admin credentials
- [ ] Set strong database passwords
- [ ] Configure firewall rules
- [ ] Enable HTTPS only
- [ ] Set proper file permissions

#### Performance Optimization
- [ ] Enable PHP OPcache
- [ ] Configure MySQL query cache
- [ ] Set up CDN for static assets
- [ ] Enable Gzip compression

### Environment Configuration

#### Production Settings
```php
// config/db.php (Production)
class Database {
    private $host = 'your-production-host';
    private $db_name = 'inshaf_hotel_prod';
    private $username = 'secure_username';
    private $password = 'strong_password';
}
```

#### Error Handling
```php
// Disable error display in production
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
```

## 🤝 Contributing

We welcome contributions! Here's how you can help:

### How to Contribute
1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature/amazing-feature`
3. **Commit your changes**: `git commit -m 'Add amazing feature'`
4. **Push to the branch**: `git push origin feature/amazing-feature`
5. **Open a Pull Request**

### Contribution Guidelines
- Follow the existing code style
- Add comments for complex logic
- Test your changes thoroughly
- Update documentation if needed
- Ensure all tests pass

### Areas for Contribution
- **New Features**: Add functionality like reports, notifications
- **UI/UX Improvements**: Enhance the user interface
- **Performance**: Optimize database queries and caching
- **Security**: Improve authentication and authorization
- **Testing**: Add unit tests and integration tests
- **Documentation**: Improve guides and API docs

## 📞 Support

### Getting Help
- **Documentation**: Check `DEVELOPER_DOCUMENTATION.md`
- **Quick Start**: Follow `QUICK_START_GUIDE.md`
- **Issues**: Create an issue on GitHub
- **Discussions**: Use GitHub Discussions for questions

### Common Issues

#### Database Connection Error
```
Error: Access denied for user 'root'@'localhost'
Solution: Check MySQL credentials in config/db.php
```

#### Include Path Error
```
Error: Failed to open stream: No such file or directory
Solution: Use __DIR__ for absolute paths in include statements
```

#### Session Issues
```
Error: Undefined index: admin_id
Solution: Ensure session_start() is called before accessing session variables
```

### Contact Information
- **Project Repository**: [GitHub Repository URL]
- **Documentation**: [Documentation URL]
- **Issues**: [GitHub Issues URL]

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Bootstrap** for the responsive UI framework
- **Chart.js** for interactive charts and graphs
- **FontAwesome** for beautiful icons
- **PHP Community** for excellent documentation and resources
- **MySQL** for reliable database management

## 🎯 Roadmap

### Version 2.0 (Planned)
- [ ] Multi-hotel support
- [ ] Advanced reporting system
- [ ] Email notifications
- [ ] Mobile app integration
- [ ] API endpoints for third-party integrations

### Version 3.0 (Future)
- [ ] Real-time notifications
- [ ] Advanced analytics
- [ ] Machine learning for demand prediction
- [ ] Multi-language support
- [ ] Advanced user roles and permissions

---

## 📊 Project Statistics

- **Total Files**: 25+
- **Lines of Code**: 3,000+
- **Database Tables**: 4
- **API Endpoints**: 15+
- **Supported Browsers**: All modern browsers
- **Mobile Support**: Full responsive design

---

**Made with ❤️ for the hospitality industry**

*This project demonstrates modern PHP development practices and can serve as a learning resource for developers interested in web application development.*
