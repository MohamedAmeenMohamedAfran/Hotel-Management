<?php

require_once '../models/BookingModel.php';
require_once '../models/GuestModel.php';

if (!isset($_SESSION['guest_id'])) {
    header('Location: login.php');
    exit;
}

$bookingModel = new BookingModel();
$guestModel = new GuestModel();

$guest_id = $_SESSION['guest_id'];
$guest = $guestModel->getById($guest_id);
$upcomingBookings = $bookingModel->getUpcomingBookings($guest_id);
$bookingHistory = $bookingModel->getBookingHistory($guest_id);

// Quick search form data
$searchData = [
    'check_in' => $_GET['check_in'] ?? date('Y-m-d', strtotime('+1 day')),
    'check_out' => $_GET['check_out'] ?? date('Y-m-d', strtotime('+2 days')),
    'guests' => $_GET['guests'] ?? 2,
    'room_type' => $_GET['room_type'] ?? '',
    'max_price' => $_GET['max_price'] ?? ''
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Hotel Inshaf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .dashboard-card { background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); padding: 2rem; }
        .btn-gradient { background: linear-gradient(45deg, #667eea, #764ba2); border: none; color: white; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../public/index.php?controller=guest-portal&action=dashboard">
                <i class="fas fa-hotel"></i> Hotel Inshaf
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../public/index.php?controller=guest-portal&action=searchRooms">
                            <i class="fas fa-search"></i> Find Rooms
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['guest_name']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../public/index.php?controller=guest-portal&action=dashboard">
                                <i class="fas fa-tachometer-alt"></i> My Dashboard
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../public/index.php?controller=guest-portal&action=logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Welcome Message -->
        <div class="dashboard-card mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><i class="fas fa-sun text-warning"></i> Welcome back, <?php echo htmlspecialchars($guest['name']); ?>!</h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-envelope text-primary"></i> <?php echo htmlspecialchars($guest['email']); ?> | 
                        <i class="fas fa-phone text-success"></i> <?php echo htmlspecialchars($guest['phone']); ?>
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <h4><i class="fas fa-star text-warning"></i> <?php echo $guest['loyalty_points'] ?? 0; ?> Points</h4>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="dashboard-card text-center">
                    <i class="fas fa-calendar-check fa-2x text-primary mb-3"></i>
                    <h4><?php echo count($upcomingBookings); ?></h4>
                    <p class="mb-0">Upcoming Bookings</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="dashboard-card text-center">
                    <i class="fas fa-history fa-2x text-info mb-3"></i>
                    <h4><?php echo count($bookingHistory); ?></h4>
                    <p class="mb-0">Past Stays</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="dashboard-card text-center">
                    <i class="fas fa-gift fa-2x text-success mb-3"></i>
                    <h4><?php echo $guest['loyalty_points'] ?? 0; ?></h4>
                    <p class="mb-0">Loyalty Points</p>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="dashboard-card">
            <h5 class="mb-3">
                <i class="fas fa-calendar-alt text-primary"></i> Recent Bookings
            </h5>
            
            <?php if (!empty($upcomingBookings)): ?>
                <?php foreach (array_slice($upcomingBookings, 0, 3) as $booking): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                        <div>
                            <h6 class="mb-1">
                                <i class="fas fa-bed text-primary"></i> 
                                Room <?php echo htmlspecialchars($booking['room_number']); ?>
                            </h6>
                            <p class="text-muted mb-0">
                                <?php echo date('M d, Y', strtotime($booking['check_in'])); ?> - 
                                <?php echo date('M d, Y', strtotime($booking['check_out'])); ?>
                            </p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success"><?php echo htmlspecialchars($booking['status']); ?></span>
                            <div class="mt-2">
                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No upcoming bookings</p>
                    <a href="../public/index.php?controller=guest-portal&action=searchRooms" class="btn btn-gradient">
                        <i class="fas fa-search"></i> Book Your First Stay
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
