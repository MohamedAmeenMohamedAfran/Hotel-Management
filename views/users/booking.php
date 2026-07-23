<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set default dates if not provided
$check_in = $check_in ?? date('Y-m-d');
$check_out = $check_out ?? date('Y-m-d', strtotime('+1 day'));

// Check if we have the required variables, if not redirect to search
if (!isset($room)) {
    header('Location: ../../public/index.php?controller=guest-portal&action=searchRooms');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - Hotel Inshaf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .booking-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            transition: transform 0.3s ease;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
        }
        
        .room-info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
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
        
        .price-highlight {
            font-size: 2rem;
            font-weight: bold;
            color: #28a745;
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../../public/index.php?controller=guest-portal&action=home">
                <i class="fas fa-hotel"></i> Hotel Inshaf
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../../public/index.php?controller=guest-portal&action=home">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../public/index.php?controller=guest-portal&action=dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['guest_name'] ?? 'Guest'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../../public/index.php?controller=guest-portal&action=logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-4">
                    <!-- Room Information -->
                    <div class="col-md-6">
                        <div class="room-info-card fade-in">
                            <h3 class="mb-3">
                                <i class="fas fa-bed me-2"></i>
                                Room <?php echo htmlspecialchars($room['room_number'] ?? 'N/A'); ?>
                            </h3>
                            <p class="mb-2">
                                <i class="fas fa-star text-warning me-2"></i>
                                <?php echo htmlspecialchars($room['room_type'] ?? 'Standard'); ?> Room
                            </p>
                            
                            <div class="mb-3">
                                <small>
                                    <i class="fas fa-users me-2"></i>
                                    Up to <?php echo $room['max_occupancy'] ?? 2; ?> guests<br>
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <?php echo htmlspecialchars($room['view_type'] ?? 'City View'); ?><br>
                                    <i class="fas fa-list me-2"></i>
                                    <?php echo htmlspecialchars($room['amenities'] ?? 'Basic amenities'); ?>
                                </small>
                            </div>
                            
                            <div class="price-highlight">
                                <?php if (isset($room['discounted_price']) && $room['discounted_price']): ?>
                                    $<?php echo number_format($room['discounted_price'] ?? 0, 2); ?>
                                    <small class="text-light d-block text-decoration-line-through">$<?php echo number_format($room['price'] ?? 0, 2); ?></small>
                                <?php else: ?>
                                    $<?php echo number_format($room['price'] ?? 0, 2); ?>
                                <?php endif; ?>
                                <small class="text-light d-block">per night</small>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div class="col-md-6">
                        <div class="booking-card p-4 fade-in">
                            <h4 class="mb-4">
                                <i class="fas fa-calendar-plus text-primary me-2"></i>
                                Complete Your Booking
                            </h4>

                            <!-- Booking Summary -->
                            <div class="mb-4 p-3" style="background-color: #f8f9fa; border-radius: 10px;">
                                <h6 class="mb-2">Booking Summary</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Check-in:</small><br>
                                        <strong><?php echo date('M d, Y', strtotime($check_in ?? date('Y-m-d'))); ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Check-out:</small><br>
                                        <strong><?php echo date('M d, Y', strtotime($check_out ?? date('Y-m-d', strtotime('+1 day')))); ?></strong>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span>Total Nights:</span>
                                    <strong><?php echo (strtotime($check_out ?? date('Y-m-d', strtotime('+1 day'))) - strtotime($check_in ?? date('Y-m-d'))) / (60 * 60 * 24); ?> nights</strong>
                                </div>
                            </div>

                            <form method="POST" id="bookingForm">
                                <!-- Date Selection -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="check_in" class="form-label fw-semibold">
                                            <i class="fas fa-calendar-check text-primary me-2"></i> Check-in Date
                                        </label>
                                        <input type="date" class="form-control" id="check_in" name="check_in" 
                                               value="<?php echo htmlspecialchars($check_in); ?>" 
                                               min="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="check_out" class="form-label fw-semibold">
                                            <i class="fas fa-calendar-times text-primary me-2"></i> Check-out Date
                                        </label>
                                        <input type="date" class="form-control" id="check_out" name="check_out" 
                                               value="<?php echo htmlspecialchars($check_out); ?>" 
                                               min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="special_requests" class="form-label fw-semibold">
                                        <i class="fas fa-comment-alt text-primary me-2"></i>
                                        Special Requests
                                    </label>
                                    <textarea class="form-control" id="special_requests" name="special_requests" 
                                              rows="4" placeholder="Any special requests or preferences..."></textarea>
                                </div>

                                <!-- Pricing Summary -->
                                <div class="mb-4 p-3" style="background-color: #e8f5e8; border-radius: 10px;">
                                    <h6 class="mb-3 text-success">Pricing Summary</h6>
                                    <?php
                                    $check_in_calc = $_POST['check_in'] ?? $check_in ?? date('Y-m-d');
                                    $check_out_calc = $_POST['check_out'] ?? $check_out ?? date('Y-m-d', strtotime('+1 day'));
                                    $nights = max(1, (strtotime($check_out_calc) - strtotime($check_in_calc)) / (60 * 60 * 24));
                                    $room_price = isset($room['discounted_price']) && $room['discounted_price'] ? $room['discounted_price'] : ($room['price'] ?? 0);
                                    $total_amount = $room_price * $nights;
                                    $discount_amount = isset($room['discounted_price']) && $room['discounted_price'] ? 
                                        (($room['price'] ?? 0) - $room['discounted_price']) * $nights : 0;
                                    $final_amount = max(0, $total_amount - $discount_amount);
                                    ?>
                                    
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Room Rate (<?php echo $nights; ?> nights):</span>
                                        <span>$<?php echo number_format($total_amount, 2); ?></span>
                                    </div>
                                    
                                    <?php if ($discount_amount > 0): ?>
                                        <div class="d-flex justify-content-between mb-1 text-success">
                                            <span>Discount:</span>
                                            <span>-$<?php echo number_format($discount_amount, 2); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total Amount:</strong>
                                        <strong class="text-success">$<?php echo number_format($final_amount, 2); ?></strong>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-gradient btn-lg">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Confirm Booking
                                    </button>
                                    <a href="../../public/index.php?controller=guest-portal&action=searchRooms&check_in=<?php echo urlencode($check_in); ?>&check_out=<?php echo urlencode($check_out); ?>" 
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Back to Search
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set minimum checkout date based on check-in
        document.getElementById('check_in').addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const checkOutDate = new Date(checkInDate);
            checkOutDate.setDate(checkOutDate.getDate() + 1);
            
            const checkOutInput = document.getElementById('check_out');
            checkOutInput.min = checkOutDate.toISOString().split('T')[0];
            if (checkOutInput.value <= this.value) {
                checkOutInput.value = checkOutDate.toISOString().split('T')[0];
            }
        });

        // Form validation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            
            if (!checkIn || !checkOut) {
                e.preventDefault();
                alert('Please select both check-in and check-out dates.');
                return;
            }
            
            if (new Date(checkOut) <= new Date(checkIn)) {
                e.preventDefault();
                alert('Check-out date must be after check-in date.');
                return;
            }
        });
    </script>
</body>
</html>