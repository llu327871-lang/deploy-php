<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .hero-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 4rem 2rem;
            margin: 2rem 0;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-outline-custom {
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        .icon-large {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-cogs me-2"></i>Admin Control Panel
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/login">
                    <i class="fas fa-sign-in-alt me-1"></i>Login
                </a>
                <a class="nav-link" href="/register">
                    <i class="fas fa-user-plus me-1"></i>Register
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section text-center">
            <i class="fas fa-rocket icon-large text-primary"></i>
            <h1 class="display-4 fw-bold mb-3">Welcome to Admin Control Panel</h1>
            <p class="lead text-muted mb-4">
                A powerful and intuitive platform for managing users, monitoring activities, and controlling access to your applications.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="/login" class="btn btn-primary-custom btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Get Started
                </a>
                <a href="/register" class="btn btn-outline-custom btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="feature-card text-center">
                    <i class="fas fa-users icon-large text-success"></i>
                    <h4 class="fw-bold mb-3">User Management</h4>
                    <p class="text-muted">
                        Easily manage user accounts, roles, and permissions. Create, update, and delete users with comprehensive control.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-card text-center">
                    <i class="fas fa-chart-bar icon-large text-info"></i>
                    <h4 class="fw-bold mb-3">Analytics & Reports</h4>
                    <p class="text-muted">
                        Monitor system usage, generate detailed reports, and gain insights into user activities and performance metrics.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-card text-center">
                    <i class="fas fa-shield-alt icon-large text-warning"></i>
                    <h4 class="fw-bold mb-3">Security First</h4>
                    <p class="text-muted">
                        Built with security in mind. CSRF protection, secure authentication, and role-based access control ensure your data stays safe.
                    </p>
                </div>
            </div>
        </div>

        <!-- Additional Features -->
        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="feature-card">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-code text-primary me-3" style="font-size: 2rem;"></i>
                        <h5 class="fw-bold mb-0">Built-in Code Editor</h5>
                    </div>
                    <p class="text-muted">
                        Integrated Monaco Editor with syntax highlighting for multiple programming languages. Perfect for quick code edits and testing.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-card">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-mobile-alt text-success me-3" style="font-size: 2rem;"></i>
                        <h5 class="fw-bold mb-0">Responsive Design</h5>
                    </div>
                    <p class="text-muted">
                        Fully responsive interface that works seamlessly across desktop, tablet, and mobile devices.
                    </p>
                </div>
            </div>
        </div>

        <!-- Demo Accounts -->
        <div class="hero-section">
            <h3 class="fw-bold text-center mb-4">Try Demo Accounts</h3>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="text-center">
                        <h5 class="fw-bold text-primary">Admin Account</h5>
                        <p class="text-muted mb-2">Full access to all features</p>
                        <code class="d-block mb-2">admin@example.com</code>
                        <code class="d-block">password</code>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <h5 class="fw-bold text-success">User Account</h5>
                        <p class="text-muted mb-2">Limited user access</p>
                        <code class="d-block mb-2">user@example.com</code>
                        <code class="d-block">password</code>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/login" class="btn btn-primary-custom">
                    <i class="fas fa-play me-2"></i>Try Demo Now
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>