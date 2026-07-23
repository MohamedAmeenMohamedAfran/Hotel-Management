<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏨 Hotel Inshaf - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 80vh;
            display: flex;
            align-items: center;
            color: white;
        }
        
        .search-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 2rem;
            backdrop-filter: blur(10px);
        }
        
        .featured-room-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .featured-room-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .promo-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 2;
        }
        
        .price-highlight {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }
        
        .amenities-list {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 3rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 2px;
        }
        
        .btn-gradient {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: transform 0.3s ease;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            color: white;
        }
        
        .stats-section {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 4rem 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=home">
                🏨 Hotel Inshaf
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#amenities">Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['guest_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=dashboard">
                                <i class="fas fa-user"></i> My Account
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=login">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=register">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 fade-in">
                    <h1 class="display-4 fw-bold mb-4">Welcome to Hotel Inshaf</h1>
                    <p class="lead mb-4">Experience luxury and comfort in the heart of Thambala. Book your perfect stay with us today and enjoy world-class amenities and exceptional service.</p>
                    <div class="d-flex gap-3">
                        <a href="#search" class="btn btn-gradient btn-lg">
                            <i class="fas fa-search"></i> Find Rooms
                        </a>
                        <a href="#rooms" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-eye"></i> View Rooms
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="search-card fade-in">
                        <h3 class="text-center mb-4">
                            <i class="fas fa-calendar-alt text-primary"></i> Book Your Stay
                        </h3>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=searchRooms" method="GET">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-check text-primary"></i> Check-in Date
                                    </label>
                                    <input type="date" class="form-control form-control-lg" name="check_in" 
                                           value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-times text-primary"></i> Check-out Date
                                    </label>
                                    <input type="date" class="form-control form-control-lg" name="check_out" 
                                           value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-users text-primary"></i> Guests
                                    </label>
                                    <select class="form-select form-select-lg" name="guests">
                                        <option value="1">1 Guest</option>
                                        <option value="2" selected>2 Guests</option>
                                        <option value="3">3 Guests</option>
                                        <option value="4">4 Guests</option>
                                        <option value="5">5+ Guests</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-bed text-primary"></i> Room Type
                                    </label>
                                    <select class="form-select form-select-lg" name="room_type">
                                        <option value="">All Types</option>
                                        <option value="Standard">Standard</option>
                                        <option value="Deluxe">Deluxe</option>
                                        <option value="Suite">Suite</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-dollar-sign text-primary"></i> Max Price
                                    </label>
                                    <select class="form-select form-select-lg" name="max_price">
                                        <option value="">No Limit</option>
                                        <option value="150">Under $150</option>
                                        <option value="250">Under $250</option>
                                        <option value="400">Under $400</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-gradient btn-lg w-100">
                                        <i class="fas fa-search"></i> Search Available Rooms
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Rooms Section -->
    <section id="rooms" class="py-5">
        <div class="container">
            <h2 class="text-center section-title fade-in">Featured Rooms & Suites</h2>
            <div class="row g-4">
                <?php if (!empty($featuredRooms)): ?>
                    <?php foreach ($featuredRooms as $room): ?>
                        <div class="col-lg-4 col-md-6 fade-in">
                            <div class="card featured-room-card">
                                <?php if ($room['is_promotional']): ?>
                                    <div class="promo-badge">
                                        <i class="fas fa-tag"></i> Special Offer
                                    </div>
                                <?php endif; ?>
                                
                                <div class="position-relative">
                                    <div class="card-img-top bg-primary d-flex align-items-center justify-content-center" 
                                         style="height: 250px; background: linear-gradient(45deg, #667eea, #764ba2);">
                                        <i class="fas fa-bed text-white" style="font-size: 4rem;"></i>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-door-open text-primary"></i> 
                                        Room <?php echo htmlspecialchars($room['room_number']); ?>
                                    </h5>
                                    <p class="card-text text-muted">
                                        <i class="fas fa-star text-warning"></i> 
                                        <?php echo htmlspecialchars($room['room_type']); ?> Room
                                    </p>
                                    
                                    <div class="amenities-list mb-3">
                                        <small>
                                            <i class="fas fa-users text-primary"></i> 
                                            Up to <?php echo $room['max_occupancy']; ?> guests
                                        </small><br>
                                        <small>
                                            <i class="fas fa-map-marker-alt text-primary"></i> 
                                            <?php echo htmlspecialchars($room['view_type'] ?? 'City View'); ?>
                                        </small>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php if ($room['is_promotional'] && $room['discounted_price']): ?>
                                                <span class="price-highlight">$<?php echo number_format($room['discounted_price'], 2); ?></span>
                                                <small class="text-muted text-decoration-line-through">$<?php echo number_format($room['price'], 2); ?></small>
                                                <br><small class="text-success">Save $<?php echo number_format($room['price'] - $room['discounted_price'], 2); ?> per night!</small>
                                            <?php else: ?>
                                                <span class="price-highlight">$<?php echo number_format($room['price'], 2); ?></span>
                                                <small class="text-muted">per night</small>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=searchRooms&room_type=<?php echo urlencode($room['room_type']); ?>" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </div>
                                    
                                    <?php if ($room['is_promotional'] && !empty($room['promotion_description'])): ?>
                                        <div class="mt-2">
                                            <small class="badge bg-success">
                                                <i class="fas fa-gift"></i> <?php echo htmlspecialchars($room['promotion_description']); ?>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>No featured rooms available</h5>
                            <p>Check out our available rooms below or use the search form above to find your perfect stay.</p>
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=searchRooms" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search All Rooms
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Happy Guests</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">6</div>
                        <div class="stat-label">Luxury Rooms</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Customer Service</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in">
                        <div class="stat-number">4.8★</div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Amenities Section -->
    <section id="amenities" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title fade-in">Hotel Amenities</h2>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 text-center fade-in">
                    <div class="p-4">
                        <i class="fas fa-wifi text-primary" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Free WiFi</h5>
                        <p class="text-muted">High-speed internet throughout the hotel</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center fade-in">
                    <div class="p-4">
                        <i class="fas fa-swimming-pool text-primary" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Swimming Pool</h5>
                        <p class="text-muted">Relax by our beautiful outdoor pool</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center fade-in">
                    <div class="p-4">
                        <i class="fas fa-utensils text-primary" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Restaurant</h5>
                        <p class="text-muted">Fine dining with local and international cuisine</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center fade-in">
                    <div class="p-4">
                        <i class="fas fa-car text-primary" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Free Parking</h5>
                        <p class="text-muted">Complimentary parking for all guests</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-light-gray text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h5><i class="fas fa-hotel text-primary"></i> Hotel Inshaf</h5>
                    <p class="text-muted">Experience luxury and comfort in the heart of Thambala. Your perfect getaway awaits.</p>
                </div>
                <div class="col-lg-4">
                    <h5>Contact Info</h5>
                    <p class="text-muted">
                        <i class="fas fa-map-marker-alt text-primary"></i> 123 Hotel Street, Thambala<br>
                        <i class="fas fa-phone text-primary"></i> +1 (555) 123-4567<br>
                        <i class="fas fa-envelope text-primary"></i> info@hotelinshaf.com
                    </p>
                </div>
                <div class="col-lg-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=home" class="text-muted">Home</a></li>
                        <li><a href="#rooms" class="text-muted">Rooms</a></li>
                        <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=register" class="text-muted">Register</a></li>
                        <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=guest-portal&action=login" class="text-muted">Login</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-muted">
                <p>&copy; 2024 Hotel Inshaf. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Set minimum checkout date
        document.querySelector('input[name="check_in"]').addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const checkOutDate = new Date(checkInDate);
            checkOutDate.setDate(checkOutDate.getDate() + 1);
            
            const checkOutInput = document.querySelector('input[name="check_out"]');
            checkOutInput.min = checkOutDate.toISOString().split('T')[0];
            if (checkOutInput.value <= this.value) {
                checkOutInput.value = checkOutDate.toISOString().split('T')[0];
            }
        });
    </script>
</body>
</html>
