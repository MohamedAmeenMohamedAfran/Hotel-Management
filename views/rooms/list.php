<?php
$title = 'Room Management - Inshaf Hotel';
$page_title = 'Room Management';
include __DIR__ . '/../layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Room Management</h2>
    <a href="index.php?controller=room&action=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Room
    </a>
</div>

<!-- Search and Filter -->
<div class="card mb-4 fade-in">
    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-search me-2"></i>
            Search & Filter Rooms
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <input type="hidden" name="controller" value="room">
            <input type="hidden" name="action" value="list">
            
            <div class="col-md-4">
                <label for="search" class="form-label">
                    <i class="fas fa-search me-1"></i>Search Rooms
                </label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" 
                       placeholder="Search by room number, type, or amenities">
            </div>
            
            <div class="col-md-3">
                <label for="status" class="form-label">
                    <i class="fas fa-filter me-1"></i>Status Filter
                </label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="Available" <?php echo ($_GET['status'] ?? '') === 'Available' ? 'selected' : ''; ?>>Available</option>
                    <option value="Booked" <?php echo ($_GET['status'] ?? '') === 'Booked' ? 'selected' : ''; ?>>Booked</option>
                    <option value="Maintenance" <?php echo ($_GET['status'] ?? '') === 'Maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                </select>
            </div>
            
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                <a href="index.php?controller=room&action=list" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Rooms Table -->
<div class="card fade-in">
    <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-bed me-2"></i>
            Room Management
        </h6>
        <small class="opacity-75">Manage hotel rooms and their details</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>Room Number</th>
                        <th><i class="fas fa-home me-1"></i>Type</th>
                        <th><i class="fas fa-dollar-sign me-1"></i>Price</th>
                        <th><i class="fas fa-info-circle me-1"></i>Status</th>
                        <th><i class="fas fa-users me-1"></i>Max Occupancy</th>
                        <th><i class="fas fa-star me-1"></i>Amenities</th>
                        <th><i class="fas fa-cogs me-1"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rooms)): ?>
                        <tr>
                            <td colspan="7" class="text-center">No rooms found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rooms as $room): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($room['room_number']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($room['room_type']); ?></td>
                                <td>$<?php echo number_format($room['price'], 2); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $room['status'] === 'Available' ? 'success' : 
                                            ($room['status'] === 'Booked' ? 'danger' : 'warning');
                                    ?> fs-6 px-3 py-2" style="border-radius: 20px;">
                                        <i class="fas fa-<?php 
                                            echo $room['status'] === 'Available' ? 'check-circle' : 
                                                ($room['status'] === 'Booked' ? 'times-circle' : 'exclamation-triangle');
                                        ?> me-1"></i>
                                        <?php echo $room['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo $room['max_occupancy']; ?> guests</td>
                                <td>
                                    <span class="text-muted" title="<?php echo htmlspecialchars($room['amenities']); ?>">
                                        <?php echo strlen($room['amenities']) > 30 ? 
                                            substr($room['amenities'], 0, 30) . '...' : 
                                            htmlspecialchars($room['amenities']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="index.php?controller=room&action=edit&id=<?php echo $room['room_id']; ?>" 
                                           class="btn btn-sm btn-outline-primary" title="Edit Room" style="border-radius: 8px 0 0 8px;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?controller=room&action=delete&id=<?php echo $room['room_id']; ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           title="Delete Room" 
                                           style="border-radius: 0 8px 8px 0;"
                                           onclick="return confirmDelete('Are you sure you want to delete this room?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
