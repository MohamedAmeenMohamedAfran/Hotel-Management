<?php
$title = 'Edit Room - Inshaf Hotel';
$page_title = 'Edit Room';
include __DIR__ . '/../layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Room: <?php echo htmlspecialchars($room['room_number']); ?></h2>
    <a href="index.php?controller=room&action=list" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Rooms
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Room Information
                </h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="room_number" class="form-label">Room Number *</label>
                            <input type="text" class="form-control" id="room_number" name="room_number" 
                                   value="<?php echo $_POST['room_number'] ?? $room['room_number']; ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="room_type" class="form-label">Room Type *</label>
                            <select class="form-select" id="room_type" name="room_type" required>
                                <option value="">Select Room Type</option>
                                <option value="Standard" <?php echo ($_POST['room_type'] ?? $room['room_type']) === 'Standard' ? 'selected' : ''; ?>>Standard</option>
                                <option value="Deluxe" <?php echo ($_POST['room_type'] ?? $room['room_type']) === 'Deluxe' ? 'selected' : ''; ?>>Deluxe</option>
                                <option value="Suite" <?php echo ($_POST['room_type'] ?? $room['room_type']) === 'Suite' ? 'selected' : ''; ?>>Suite</option>
                                <option value="Executive" <?php echo ($_POST['room_type'] ?? $room['room_type']) === 'Executive' ? 'selected' : ''; ?>>Executive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price per Night *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="<?php echo $_POST['price'] ?? $room['price']; ?>" 
                                       step="0.01" min="0" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="max_occupancy" class="form-label">Max Occupancy *</label>
                            <select class="form-select" id="max_occupancy" name="max_occupancy" required>
                                <option value="">Select Max Occupancy</option>
                                <option value="1" <?php echo ($_POST['max_occupancy'] ?? $room['max_occupancy']) === '1' ? 'selected' : ''; ?>>1 Guest</option>
                                <option value="2" <?php echo ($_POST['max_occupancy'] ?? $room['max_occupancy']) === '2' ? 'selected' : ''; ?>>2 Guests</option>
                                <option value="3" <?php echo ($_POST['max_occupancy'] ?? $room['max_occupancy']) === '3' ? 'selected' : ''; ?>>3 Guests</option>
                                <option value="4" <?php echo ($_POST['max_occupancy'] ?? $room['max_occupancy']) === '4' ? 'selected' : ''; ?>>4 Guests</option>
                                <option value="6" <?php echo ($_POST['max_occupancy'] ?? $room['max_occupancy']) === '6' ? 'selected' : ''; ?>>6+ Guests</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Available" <?php echo ($_POST['status'] ?? $room['status']) === 'Available' ? 'selected' : ''; ?>>Available</option>
                            <option value="Booked" <?php echo ($_POST['status'] ?? $room['status']) === 'Booked' ? 'selected' : ''; ?>>Booked</option>
                            <option value="Maintenance" <?php echo ($_POST['status'] ?? $room['status']) === 'Maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="amenities" class="form-label">Amenities</label>
                        <textarea class="form-control" id="amenities" name="amenities" rows="4" 
                                  placeholder="Enter amenities separated by commas (e.g., WiFi, TV, AC, Bathroom, Mini Bar)"><?php echo $_POST['amenities'] ?? $room['amenities']; ?></textarea>
                        <div class="form-text">Separate amenities with commas for better display.</div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php?controller=room&action=list" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
