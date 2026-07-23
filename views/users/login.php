<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Hotel Inshaf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { background: rgba(255, 255, 255, 0.95); border-radius: 20px; padding: 2rem; }
        .btn-login { background: linear-gradient(45deg, #667eea, #764ba2); border: none; padding: 12px 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <h2 class="text-center mb-4">🏨 User Login</h2>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-login w-100">Login</button>
                    </form>
                    <p class="text-center mt-3">
                        <a href="../public/index.php?controller=guest-portal&action=register">Don't have an account? Register</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
