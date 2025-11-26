<?php
Auth::requireLogin();

$user = Auth::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .action-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .profile-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .icon-large {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="#">
                <i class="fas fa-tachometer-alt me-2"></i>User Dashboard
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">
                    <i class="fas fa-user-circle me-2"></i>Welcome, <?php echo htmlspecialchars($user['name']); ?>
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="welcome-card p-4 mb-5">
            <div class="text-center">
                <i class="fas fa-user-circle icon-large text-primary"></i>
                <h2 class="fw-bold mb-3">Welcome to your Dashboard</h2>
                <p class="text-muted lead">You are logged in as a regular user. Here you can manage your account and access available features.</p>
                <span class="profile-badge">
                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($user['role']); ?>
                </span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="action-card p-4 h-100">
                    <div class="text-center">
                        <i class="fas fa-user-edit icon-large text-success"></i>
                        <h4 class="fw-bold mb-3">My Profile</h4>
                        <div class="bg-light p-3 rounded mb-3">
                            <div class="row text-start">
                                <div class="col-4"><strong>Name:</strong></div>
                                <div class="col-8"><?php echo htmlspecialchars($user['name']); ?></div>
                                <div class="col-4"><strong>Email:</strong></div>
                                <div class="col-8"><?php echo htmlspecialchars($user['email']); ?></div>
                                <div class="col-4"><strong>Role:</strong></div>
                                <div class="col-8"><?php echo htmlspecialchars($user['role']); ?></div>
                            </div>
                        </div>
                        <a href="/profile" class="btn btn-custom">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="action-card p-4 h-100">
                    <div class="text-center">
                        <i class="fas fa-cogs icon-large text-info"></i>
                        <h4 class="fw-bold mb-3">Available Features</h4>
                        <p class="text-muted">Access various features available to users</p>
                        <a href="/features" class="btn btn-custom">
                            <i class="fas fa-arrow-right me-2"></i>Browse Features
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="action-card p-4 h-100">
                    <div class="text-center">
                        <i class="fas fa-question-circle icon-large text-warning"></i>
                        <h4 class="fw-bold mb-3">Help & Support</h4>
                        <p class="text-muted">Get help and support for using the system</p>
                        <a href="/help" class="btn btn-custom">
                            <i class="fas fa-life-ring me-2"></i>Get Help
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>