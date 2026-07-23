<?php
$check_in = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';
$guests = $_GET['guests'] ?? 1;
$room_type = $_GET['room_type'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$amenities = $_GET['amenities'] ?? [];
// TEMP DEBUG: Echo the current important GET values
if (!empty($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    echo '<pre style="background:#fffbbb;color:#2a2;border:1px solid #ccc;padding:8px;">DEBUG: check_in=' . htmlspecialchars($check_in) . ' | check_out=' . htmlspecialchars($check_out) . ' | guests=' . htmlspecialchars($guests) . '</pre>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Hotel Inshaf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .search-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .search-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .room-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .room-card:hover {
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
        
        .filter-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            position: sticky;
            top: 20px;
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .results-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../public/index.php?controller=guest-portal&action=home">
                <i class="fas fa-hotel"></i> Hotel Inshaf
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../public/index.php?controller=guest-portal&action=home">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <?php if (isset($_SESSION['guest_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../public/index.php?controller=guest-portal&action=dashboard">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['guest_name']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../public/index.php?controller=guest-portal&action=logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../public/index.php?controller=guest-portal&action=login">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Results Header -->
        <div class="results-header fade-in">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="mb-2">
                        <i class="fas fa-search"></i> Available Rooms
                    </h2>
                    <p class="mb-0">
                        <?php if (!empty($check_in) && !empty($check_out)): ?>
                            <i class="fas fa-calendar"></i> 
                            <?php echo date('M d, Y', strtotime($check_in)); ?> - 
                            <?php echo date('M d, Y', strtotime($check_out)); ?> | 
                        <?php endif; ?>
                        <i class="fas fa-users"></i> 
                        <?php echo $guests; ?> Guest<?php echo $guests > 1 ? 's' : ''; ?>
                        <?php if (!empty($room_type)): ?>
                            | <i class="fas fa-bed"></i> <?php echo htmlspecialchars($room_type); ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-lg-4 text-end">
                    <h3 class="mb-0"><?php echo count($availableRooms); ?> Room<?php echo count($availableRooms) !== 1 ? 's' : ''; ?> Found</h3>
                    <small>Sorted by price</small>
                </div>
            </div>
        </div>

        <!-- Date Selection Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="search-card p-4 fade-in">
                    <h5 class="mb-3">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        Select Your Dates
                    </h5>
                    <form action="../public/index.php?controller=guest-portal&action=searchRooms" method="GET">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-check text-primary me-2"></i> Check-in Date
                                </label>
                                <input type="date" class="form-control" name="check_in" 
                                       value="<?php echo !empty($check_in) ? $check_in : date('Y-m-d'); ?>" 
                                       min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-times text-primary me-2"></i> Check-out Date
                                </label>
                                <input type="date" class="form-control" name="check_out" 
                                       value="<?php echo !empty($check_out) ? $check_out : date('Y-m-d', strtotime('+1 day')); ?>" 
                                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-users text-primary me-2"></i> Guests
                                </label>
                                <select class="form-select" name="guests">
                                    <option value="1" <?php echo ($guests == 1) ? 'selected' : ''; ?>>1 Guest</option>
                                    <option value="2" <?php echo ($guests == 2) ? 'selected' : ''; ?>>2 Guests</option>
                                    <option value="3" <?php echo ($guests == 3) ? 'selected' : ''; ?>>3 Guests</option>
                                    <option value="4" <?php echo ($guests == 4) ? 'selected' : ''; ?>>4 Guests</option>
                                    <option value="5" <?php echo ($guests == 5) ? 'selected' : ''; ?>>5+ Guests</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-bed text-primary me-2"></i> Room Type
                                </label>
                                <select class="form-select" name="room_type">
                                    <option value="">All Types</option>
                                    <option value="Standard" <?php echo ($room_type === 'Standard') ? 'selected' : ''; ?>>Standard</option>
                                    <option value="Deluxe" <?php echo ($room_type === 'Deluxe') ? 'selected' : ''; ?>>Deluxe</option>
                                    <option value="Suite" <?php echo ($room_type === 'Suite') ? 'selected' : ''; ?>>Suite</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-gradient w-100">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Results -->
            <div class="col-12">
                <?php if (!empty($availableRooms)): ?>
                    <div class="row g-4">
                        <?php foreach ($availableRooms as $room): ?>
                            <div class="col-12 fade-in">
                                <div class="search-card p-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <div class="position-relative">
                                                <div class="bg-primary d-flex align-items-center justify-content-center" 
                                                     style="height: 200px; background: linear-gradient(45deg, #667eea, #764ba2); border-radius: 15px;">
                                                    <i class="fas fa-bed text-white" style="font-size: 3rem;"></i>
                                                </div>
                                                <?php if (isset($room['is_promotional']) && $room['is_promotional']): ?>
                                                    <div class="promo-badge">
                                                        <i class="fas fa-tag"></i> Special Offer
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-5">
                                            <h5 class="mb-2">
                                                <i class="fas fa-door-open text-primary"></i> 
                                                Room <?php echo htmlspecialchars($room['room_number']); ?>
                                            </h5>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-star text-warning"></i> 
                                                <?php echo htmlspecialchars($room['room_type']); ?> Room
                                            </p>
                                            
                                            <div class="amenities-list mb-3">
                                                <small>
                                                    <i class="fas fa-users text-primary"></i> 
                                                    Up to <?php echo $room['max_occupancy']; ?> guests | 
                                                    <i class="fas fa-map-marker-alt text-primary"></i> 
                                                    <?php echo htmlspecialchars($room['view_type'] ?? 'City View'); ?>
                                                </small><br>
                                                <small class="text-muted">
                                                    <i class="fas fa-list text-primary"></i> 
                                                    <?php echo htmlspecialchars($room['amenities']); ?>
                                                </small>
                                            </div>
                                            
                                            <?php if (isset($room['is_promotional']) && $room['is_promotional'] && !empty($room['promotion_description'])): ?>
                                                <div class="mb-2">
                                                    <small class="badge bg-success">
                                                        <i class="fas fa-gift"></i> <?php echo htmlspecialchars($room['promotion_description']); ?>
                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="col-md-3 text-end">
                                            <div class="mb-3">
                                                <?php if (isset($room['discounted_price']) && $room['discounted_price']): ?>
                                                    <span class="price-highlight">$<?php echo number_format($room['discounted_price'], 2); ?></span>
                                                    <small class="text-muted d-block text-decoration-line-through">$<?php echo number_format($room['price'], 2); ?></small>
                                                    <small class="text-success">Save $<?php echo number_format($room['price'] - $room['discounted_price'], 2); ?> per night!</small>
                                                <?php else: ?>
                                                    <span class="price-highlight">$<?php echo number_format($room['price'], 2); ?></span>
                                                    <small class="text-muted d-block">per night</small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <a href="../public/index.php?controller=guest-portal&action=bookRoom&room_id=<?php echo $room['room_id']; ?>" 
   class="btn btn-gradient btn-lg">
    <i class="fas fa-calendar-plus"></i> Book Now
</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="search-card p-5 text-center fade-in">
                        <i class="fas fa-search fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted mb-3">No Rooms Available</h3>
                        <p class="text-muted mb-4">
                            Sorry, no rooms are available for the selected dates and criteria. 
                            Try adjusting your search parameters or check different dates.
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form action="../public/index.php?controller=guest-portal&action=searchRooms" method="GET">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input type="date" class="form-control" name="check_in" 
                                                   value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-6">
                                            <input type="date" class="form-control" name="check_out" 
                                                   value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-gradient w-100">
                                                <i class="fas fa-search"></i> Try Different Dates
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set minimum checkout date based on check-in
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

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const checkIn = document.querySelector('input[name="check_in"]').value;
            const checkOut = document.querySelector('input[name="check_out"]').value;
            
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
