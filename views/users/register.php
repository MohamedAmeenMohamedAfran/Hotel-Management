<?php
// REMOVE: session_start() - already started in public/index.php
// REMOVE: require_once '../models/GuestModel.php'; - handled by controller

// REMOVE: $guestModel = new GuestModel(); - handled by controller
// REMOVE: $error = ''; - handled by controller

// Keep only the HTML/PHP view code that uses variables passed from controller
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Hotel Inshaf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .register-card { background: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 2rem; }
        .btn-register { background: linear-gradient(45deg, #667eea, #764ba2); border: none; padding: 12px 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="register-card">
                    <h2 class="text-center mb-4">🏨 User Registration</h2>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $_POST['name'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone *</label>
                                <input type="tel" class="form-control" name="phone" value="<?php echo $_POST['phone'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth" value="<?php echo $_POST['date_of_birth'] ?? ''; ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="3"><?php echo $_POST['address'] ?? ''; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password *</label>
                                <input type="password" class="form-control" name="password" required minlength="6">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nationality</label>
                                <select class="form-select" name="nationality">
                                    <option value="">Select Nationality</option>
                                    <option value="Sri Lankan">Sri Lankan</option>
                                    <option value="Indian">Indian</option>
                                    <option value="American">American</option>
                                    <option value="British">British</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-register">Create Account</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">
                        <a href="../public/index.php?controller=guest-portal&action=login">Already have an account? Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
