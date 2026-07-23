-- Inshaf Hotel Database Schema
-- Created for Hotel Reservation System

CREATE DATABASE IF NOT EXISTS inshaf_hotel;
USE inshaf_hotel;

-- Guests table
CREATE TABLE guests (
    guest_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    password_hash VARCHAR(255),
    date_of_birth DATE,
    nationality VARCHAR(50),
    preferences TEXT,
    loyalty_points INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Rooms table
CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) UNIQUE NOT NULL,
    room_type VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    discounted_price DECIMAL(10,2),
    status ENUM('Available', 'Booked', 'Maintenance', 'Housekeeping') DEFAULT 'Available',
    amenities TEXT,
    max_occupancy INT DEFAULT 2,
    floor_number INT DEFAULT 1,
    view_type VARCHAR(50),
    is_promotional BOOLEAN DEFAULT FALSE,
    promotion_description TEXT,
    promotion_start_date DATE,
    promotion_end_date DATE,
    housekeeping_status ENUM('Clean', 'Dirty', 'In Progress') DEFAULT 'Clean',
    last_cleaned TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Admins table
CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('Super Admin', 'Manager', 'Staff') DEFAULT 'Staff',
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bookings table
CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Active', 'Completed', 'Cancelled', 'No Show') DEFAULT 'Pending',
    payment_status ENUM('Pending', 'Paid', 'Partial', 'Refunded', 'Failed') DEFAULT 'Pending',
    total_amount DECIMAL(10,2) NOT NULL,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    final_amount DECIMAL(10,2) NOT NULL,
    booking_source ENUM('Online', 'Phone', 'Walk-in', 'Agent') DEFAULT 'Online',
    special_requests TEXT,
    check_in_time TIMESTAMP NULL,
    check_out_time TIMESTAMP NULL,
    cancellation_reason TEXT,
    cancelled_at TIMESTAMP NULL,
    cancellation_fee DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (guest_id) REFERENCES guests(guest_id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE CASCADE,
    
    INDEX idx_check_dates (check_in, check_out),
    INDEX idx_status (status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_booking_source (booking_source)
);

-- Guest reviews table
CREATE TABLE guest_reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    guest_id INT NOT NULL,
    room_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT,
    service_rating INT CHECK (service_rating >= 1 AND service_rating <= 5),
    cleanliness_rating INT CHECK (cleanliness_rating >= 1 AND cleanliness_rating <= 5),
    value_rating INT CHECK (value_rating >= 1 AND value_rating <= 5),
    is_verified BOOLEAN DEFAULT FALSE,
    is_public BOOLEAN DEFAULT TRUE,
    response_text TEXT,
    responded_by INT,
    responded_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE,
    FOREIGN KEY (guest_id) REFERENCES guests(guest_id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES rooms(room_id) ON DELETE CASCADE,
    FOREIGN KEY (responded_by) REFERENCES admins(admin_id) ON DELETE SET NULL
);

-- Insert sample admin user (password: admin123)
INSERT INTO admins (username, password_hash, role, full_name, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super Admin', 'System Administrator', 'admin@inshafhotel.com');

-- Insert sample rooms
INSERT INTO rooms (room_number, room_type, price, discounted_price, status, amenities, max_occupancy, floor_number, view_type, is_promotional, promotion_description, promotion_start_date, promotion_end_date, housekeeping_status) VALUES
('101', 'Standard', 150.00, NULL, 'Available', 'WiFi, TV, AC, Bathroom', 2, 1, 'Garden View', FALSE, NULL, NULL, NULL, 'Clean'),
('102', 'Standard', 150.00, 120.00, 'Available', 'WiFi, TV, AC, Bathroom', 2, 1, 'Street View', TRUE, 'Weekend Special - 20% Off', '2024-01-01', '2024-12-31', 'Clean'),
('103', 'Deluxe', 250.00, NULL, 'Available', 'WiFi, TV, AC, Bathroom, Mini Bar, Balcony', 3, 1, 'Sea View', FALSE, NULL, NULL, NULL, 'Clean'),
('104', 'Deluxe', 250.00, 200.00, 'Available', 'WiFi, TV, AC, Bathroom, Mini Bar, Balcony', 3, 1, 'Sea View', TRUE, 'Early Bird Special - 20% Off', '2024-01-01', '2024-12-31', 'Clean'),
('201', 'Suite', 400.00, NULL, 'Available', 'WiFi, TV, AC, Bathroom, Mini Bar, Balcony, Living Room', 4, 2, 'Ocean View', FALSE, NULL, NULL, NULL, 'Clean'),
('202', 'Suite', 400.00, 320.00, 'Available', 'WiFi, TV, AC, Bathroom, Mini Bar, Balcony, Living Room', 4, 2, 'Ocean View', TRUE, 'Honeymoon Package - 20% Off', '2024-01-01', '2024-12-31', 'Clean');

-- Insert sample guests
INSERT INTO guests (name, email, phone, address, password_hash, date_of_birth, nationality) VALUES
('John Doe', 'john.doe@email.com', '+1234567890', '123 Main St, City', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1990-05-15', 'American'),
('Jane Smith', 'jane.smith@email.com', '+0987654321', '456 Oak Ave, Town', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1985-08-22', 'British'),
('Ahmed Hassan', 'ahmed.hassan@email.com', '+1122334455', '789 Pine Rd, Village', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1988-11-03', 'Egyptian');
