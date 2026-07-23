<?php
$title = 'Guest Management - Inshaf Hotel';
$page_title = 'Guest Management';
include __DIR__ . '/../layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Guest Management</h2>
    <a href="index.php?controller=guest&action=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Guest
    </a>
</div>

<!-- Search -->
<div class="card mb-4 fade-in">
    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-search me-2"></i>
            Search Guests
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <input type="hidden" name="controller" value="guest">
            <input type="hidden" name="action" value="list">
            
            <div class="col-md-6">
                <label for="search" class="form-label">
                    <i class="fas fa-search me-1"></i>Search Guests
                </label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" 
                       placeholder="Search by name, email, or phone">
            </div>
            
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                <a href="index.php?controller=guest&action=list" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Guests Table -->
<div class="card fade-in">
    <div class="card-header" style="background: linear-gradient(135deg, #17a2b8 0%, #6610f2 100%); color: white;">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-users me-2"></i>
            Guest Management
        </h6>
        <small class="opacity-75">Manage guest information and profiles</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>ID</th>
                        <th><i class="fas fa-user me-1"></i>Name</th>
                        <th><i class="fas fa-envelope me-1"></i>Email</th>
                        <th><i class="fas fa-phone me-1"></i>Phone</th>
                        <th><i class="fas fa-map-marker-alt me-1"></i>Address</th>
                        <th><i class="fas fa-calendar me-1"></i>Created</th>
                        <th><i class="fas fa-cogs me-1"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($guests)): ?>
                        <tr>
                            <td colspan="7" class="text-center">No guests found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($guests as $guest): ?>
                            <tr>
                                <td>#<?php echo $guest['guest_id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($guest['name']); ?></strong>
                                </td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($guest['email']); ?>">
                                        <?php echo htmlspecialchars($guest['email']); ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="tel:<?php echo htmlspecialchars($guest['phone']); ?>">
                                        <?php echo htmlspecialchars($guest['phone']); ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="text-muted" title="<?php echo htmlspecialchars($guest['address']); ?>">
                                        <?php echo strlen($guest['address']) > 30 ? 
                                            substr($guest['address'], 0, 30) . '...' : 
                                            htmlspecialchars($guest['address']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($guest['created_at'])); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="index.php?controller=guest&action=edit&id=<?php echo $guest['guest_id']; ?>" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?controller=guest&action=delete&id=<?php echo $guest['guest_id']; ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           title="Delete" 
                                           onclick="return confirmDelete('Are you sure you want to delete this guest?')">
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
