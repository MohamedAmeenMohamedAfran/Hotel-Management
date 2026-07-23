<?php
$title = 'Booking Management - Inshaf Hotel';
$page_title = 'Booking Management';
include __DIR__ . '/../layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Booking Management</h2>
    <a href="index.php?controller=booking&action=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Create New Booking
    </a>
</div>

<!-- Filter -->
<div class="card mb-4 fade-in">
    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-filter me-2"></i>
            Filter Bookings
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <input type="hidden" name="controller" value="booking">
            <input type="hidden" name="action" value="list">
            
            <div class="col-md-3">
                <label for="status" class="form-label">
                    <i class="fas fa-info-circle me-1"></i>Status Filter
                </label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Bookings</option>
                    <option value="Pending" <?php echo ($_GET['status'] ?? '') === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Confirmed" <?php echo ($_GET['status'] ?? '') === 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="Active" <?php echo ($_GET['status'] ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
                    <option value="Completed" <?php echo ($_GET['status'] ?? '') === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="Cancelled" <?php echo ($_GET['status'] ?? '') === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter me-1"></i>Filter
                </button>
                <a href="index.php?controller=booking&action=list" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="card fade-in">
    <div class="card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #6610f2 100%); color: white;">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-calendar-check me-2"></i>
            Booking Management
        </h6>
        <small class="opacity-75">Manage hotel bookings and reservations</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>Booking ID</th>
                        <th><i class="fas fa-user me-1"></i>Guest</th>
                        <th><i class="fas fa-bed me-1"></i>Room</th>
                        <th><i class="fas fa-calendar-plus me-1"></i>Check-in</th>
                        <th><i class="fas fa-calendar-minus me-1"></i>Check-out</th>
                        <th><i class="fas fa-info-circle me-1"></i>Status</th>
                        <th><i class="fas fa-credit-card me-1"></i>Payment</th>
                        <th><i class="fas fa-dollar-sign me-1"></i>Amount</th>
                        <th><i class="fas fa-cogs me-1"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="9" class="text-center">No bookings found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>#<?php echo $booking['booking_id']; ?></td>
                                <td>
                                    <div>
                                        <strong><?php echo htmlspecialchars($booking['guest_name']); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($booking['email']); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong><?php echo htmlspecialchars($booking['room_number']); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($booking['room_type']); ?></small>
                                    </div>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($booking['check_in'])); ?></td>
                                <td><?php echo date('M d, Y', strtotime($booking['check_out'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $booking['status'] === 'Active' ? 'success' : 
                                            ($booking['status'] === 'Completed' ? 'info' : 
                                            ($booking['status'] === 'Cancelled' ? 'danger' : 
                                            ($booking['status'] === 'Confirmed' ? 'primary' : 'warning')));
                                    ?> fs-6 px-3 py-2" style="border-radius: 20px;">
                                        <i class="fas fa-<?php 
                                            echo $booking['status'] === 'Active' ? 'check-circle' : 
                                                ($booking['status'] === 'Completed' ? 'check' : 
                                                ($booking['status'] === 'Cancelled' ? 'times-circle' : 
                                                ($booking['status'] === 'Confirmed' ? 'clock' : 'exclamation-triangle')));
                                        ?> me-1"></i>
                                        <?php echo $booking['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $booking['payment_status'] === 'Paid' ? 'success' : 
                                            ($booking['payment_status'] === 'Partial' ? 'warning' : 
                                            ($booking['payment_status'] === 'Refunded' ? 'info' : 'danger'));
                                    ?> fs-6 px-3 py-2" style="border-radius: 20px;">
                                        <i class="fas fa-<?php 
                                            echo $booking['payment_status'] === 'Paid' ? 'check-circle' : 
                                                ($booking['payment_status'] === 'Partial' ? 'exclamation-triangle' : 
                                                ($booking['payment_status'] === 'Refunded' ? 'undo' : 'times-circle'));
                                        ?> me-1"></i>
                                        <?php echo $booking['payment_status']; ?>
                                    </span>
                                </td>
                                <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="index.php?controller=booking&action=edit&id=<?php echo $booking['booking_id']; ?>" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <?php if ($booking['status'] === 'Confirmed'): ?>
                                            <a href="index.php?controller=booking&action=checkin&id=<?php echo $booking['booking_id']; ?>" 
                                               class="btn btn-sm btn-outline-success" title="Check In">
                                                <i class="fas fa-sign-in-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($booking['status'] === 'Active'): ?>
                                            <a href="index.php?controller=booking&action=checkout&id=<?php echo $booking['booking_id']; ?>" 
                                               class="btn btn-sm btn-outline-info" title="Check Out">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if (in_array($booking['status'], ['Pending', 'Confirmed'])): ?>
                                            <a href="index.php?controller=booking&action=cancel&id=<?php echo $booking['booking_id']; ?>" 
                                               class="btn btn-sm btn-outline-danger" title="Cancel"
                                               onclick="return confirmDelete('Are you sure you want to cancel this booking?')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
