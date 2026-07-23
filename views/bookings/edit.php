<?php
$title = 'Edit Booking - Inshaf Hotel';
$page_title = 'Edit Booking';
include __DIR__ . '/../layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Booking #<?php echo $booking['booking_id']; ?></h2>
    <a href="index.php?controller=booking&action=list" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Bookings
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-edit me-2"></i>
                    Booking Information
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" id="bookingForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="guest_id" class="form-label">Guest *</label>
                            <select class="form-select" id="guest_id" name="guest_id" required>
                                <option value="">Select Guest</option>
                                <?php foreach ($guests as $guest): ?>
                                    <option value="<?php echo $guest['guest_id']; ?>" 
                                            <?php echo ($_POST['guest_id'] ?? $booking['guest_id']) == $guest['guest_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($guest['name'] . ' (' . $guest['email'] . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="room_id" class="form-label">Room *</label>
                            <select class="form-select" id="room_id" name="room_id" required>
                                <option value="">Select Room</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?php echo $room['room_id']; ?>" 
                                            data-price="<?php echo $room['price']; ?>"
                                            <?php echo ($_POST['room_id'] ?? $booking['room_id']) == $room['room_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($room['room_number'] . ' - ' . $room['room_type'] . ' ($' . $room['price'] . '/night)'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="check_in" class="form-label">Check-in Date *</label>
                            <input type="date" class="form-control" id="check_in" name="check_in" 
                                   value="<?php echo $_POST['check_in'] ?? $booking['check_in']; ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="check_out" class="form-label">Check-out Date *</label>
                            <input type="date" class="form-control" id="check_out" name="check_out" 
                                   value="<?php echo $_POST['check_out'] ?? $booking['check_out']; ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="payment_status" class="form-label">Payment Status *</label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                <option value="Pending" <?php echo ($_POST['payment_status'] ?? $booking['payment_status']) === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Paid" <?php echo ($_POST['payment_status'] ?? $booking['payment_status']) === 'Paid' ? 'selected' : ''; ?>>Paid</option>
                                <option value="Partial" <?php echo ($_POST['payment_status'] ?? $booking['payment_status']) === 'Partial' ? 'selected' : ''; ?>>Partial</option>
                                <option value="Refunded" <?php echo ($_POST['payment_status'] ?? $booking['payment_status']) === 'Refunded' ? 'selected' : ''; ?>>Refunded</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="special_requests" class="form-label">Special Requests</label>
                        <textarea class="form-control" id="special_requests" name="special_requests" rows="3" 
                                  placeholder="Any special requests or notes for this booking"><?php echo $_POST['special_requests'] ?? $booking['special_requests']; ?></textarea>
                    </div>
                    
                    <!-- Total Amount Display -->
                    <div class="alert alert-info" id="totalAmountAlert">
                        <i class="fas fa-calculator me-2"></i>
                        <strong>Total Amount: $<span id="totalAmount"><?php echo number_format($booking['total_amount'], 2); ?></span></strong>
                        <span id="nightsInfo" class="ms-2"></span>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?controller=booking&action=list" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const roomSelect = document.getElementById('room_id');
    const totalAmountAlert = document.getElementById('totalAmountAlert');
    const totalAmountSpan = document.getElementById('totalAmount');
    const nightsInfoSpan = document.getElementById('nightsInfo');

    function calculateTotal() {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;
        const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
        
        if (checkIn && checkOut && selectedRoom.value) {
            const price = parseFloat(selectedRoom.dataset.price);
            const checkInDate = new Date(checkIn);
            const checkOutDate = new Date(checkOut);
            
            if (checkOutDate > checkInDate) {
                const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
                const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
                const total = price * nights;
                
                totalAmountSpan.textContent = total.toFixed(2);
                nightsInfoSpan.textContent = `(${nights} night${nights > 1 ? 's' : ''} × $${price.toFixed(2)})`;
            }
        }
    }

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    checkInInput.min = today;
    
    checkInInput.addEventListener('change', function() {
        checkOutInput.min = this.value;
        calculateTotal();
    });
    
    checkOutInput.addEventListener('change', calculateTotal);
    roomSelect.addEventListener('change', calculateTotal);
    
    // Calculate on page load
    calculateTotal();
});
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
