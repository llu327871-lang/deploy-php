<?php

$message = '';
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!Auth::validateCSRFToken($csrfToken)) {
        $message = 'Invalid request';
    } elseif (!Auth::validateEmail($email)) {
        $message = 'Please enter a valid email address';
    } else {
        $token = Auth::requestPasswordReset($email);
        if ($token) {
            $success = true;
            $message = 'If an account with that email exists, we have sent a password reset link.';
            // In production, send email with reset link
            // For demo: reset link would be /reset-password?token=$token
        } else {
            $message = 'An error occurred. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Admin Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .forgot-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .btn-reset {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
        }
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }
        .form-control:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="forgot-container p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-key fa-3x text-danger mb-3"></i>
                        <h2 class="fw-bold">Forgot Password</h2>
                        <p class="text-muted">Enter your email to reset your password</p>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                            <i class="fas fa-<?php echo $success ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(Auth::generateCSRFToken()); ?>">
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email"
                                    placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg w-100 btn-reset">
                            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Remember your password?
                            <a href="/login" class="text-decoration-none fw-semibold">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>