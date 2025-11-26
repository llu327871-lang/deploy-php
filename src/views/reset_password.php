<?php

$message = '';
$success = false;
$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!Auth::validateCSRFToken($csrfToken)) {
        $message = 'Invalid request';
    } elseif (empty($password) || empty($confirmPassword)) {
        $message = 'All fields are required';
    } elseif ($password !== $confirmPassword) {
        $message = 'Passwords do not match';
    } elseif (!Auth::validatePassword($password)) {
        $message = 'Password must be at least 8 characters long and contain uppercase, lowercase, and number';
    } elseif (Auth::resetPassword($token, $password)) {
        $success = true;
        $message = 'Password reset successful! You can now login with your new password.';
    } else {
        $message = 'Invalid or expired reset token';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Admin Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .reset-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .btn-update {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: 600;
        }
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        .password-strength {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="reset-container p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-lock-open fa-3x text-success mb-3"></i>
                        <h2 class="fw-bold">Reset Password</h2>
                        <p class="text-muted">Enter your new password</p>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                            <i class="fas fa-<?php echo $success ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!$success && $token): ?>
                        <form method="POST" id="resetForm">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(Auth::generateCSRFToken()); ?>">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>New Password
                                </label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password"
                                        placeholder="Enter new password" required minlength="8">
                                <div id="passwordStrength" class="password-strength"></div>
                            </div>

                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Confirm Password
                                </label>
                                <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password"
                                        placeholder="Confirm new password" required>
                                <div id="passwordMatch" class="password-strength"></div>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 btn-update">
                                <i class="fas fa-save me-2"></i>Update Password
                            </button>
                        </form>
                    <?php endif; ?>

                    <div class="text-center mt-4">
                        <p class="mb-0">
                            <a href="/login" class="text-decoration-none fw-semibold">Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.getElementById('passwordStrength');

            if (password.length === 0) {
                strengthIndicator.textContent = '';
                return;
            }

            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;
            if (password.match(/[^a-zA-Z\d]/)) strength++;

            if (strength < 4) {
                strengthIndicator.textContent = 'Password must have 8+ chars, uppercase, lowercase, and number';
                strengthIndicator.className = 'password-strength strength-weak';
            } else if (strength === 4) {
                strengthIndicator.textContent = 'Good password';
                strengthIndicator.className = 'password-strength strength-medium';
            } else {
                strengthIndicator.textContent = 'Strong password';
                strengthIndicator.className = 'password-strength strength-strong';
            }
        });

        // Password confirmation check
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const matchIndicator = document.getElementById('passwordMatch');

            if (confirmPassword.length === 0) {
                matchIndicator.textContent = '';
                return;
            }

            if (password === confirmPassword) {
                matchIndicator.textContent = 'Passwords match';
                matchIndicator.className = 'password-strength strength-strong';
            } else {
                matchIndicator.textContent = 'Passwords do not match';
                matchIndicator.className = 'password-strength strength-weak';
            }
        });
    </script>
</body>
</html>