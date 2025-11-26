<?php
Auth::requireAdmin();

$user = Auth::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Control Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
        .btn-danger-custom {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        .icon-large {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="#">
                <i class="fas fa-crown me-2"></i>Admin Dashboard
            </a>
            <div class="d-flex align-items-center">
                <span class="badge bg-warning text-dark me-3">
                    <i class="fas fa-shield-alt me-1"></i>Administrator
                </span>
                <span class="text-white me-3">
                    <i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($user['name']); ?>
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="stat-card p-4 text-center">
                    <i class="fas fa-users icon-large text-primary"></i>
                    <h4 class="fw-bold mb-3">Total Users</h4>
                    <div class="stat-number" id="total-users">
                        <div class="loading-spinner"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stat-card p-4 text-center">
                    <i class="fas fa-user-shield icon-large text-success"></i>
                    <h4 class="fw-bold mb-3">Admin Users</h4>
                    <div class="stat-number" id="admin-users">
                        <div class="loading-spinner"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="stat-card p-4 text-center">
                    <i class="fas fa-user-friends icon-large text-info"></i>
                    <h4 class="fw-bold mb-3">Regular Users</h4>
                    <div class="stat-number" id="regular-users">
                        <div class="loading-spinner"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="action-card p-4 h-100">
                    <div class="text-center">
                        <i class="fas fa-users-cog icon-large text-primary"></i>
                        <h4 class="fw-bold mb-3">User Management</h4>
                        <p class="text-muted">Manage all users in the system</p>
                        <div class="d-grid gap-2">
                            <a href="/admin/users" class="btn btn-custom">
                                <i class="fas fa-list me-2"></i>Manage Users
                            </a>
                            <a href="/admin/users/create" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>Add New User
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="action-card p-4 h-100">
                    <div class="text-center">
                        <i class="fas fa-cogs icon-large text-warning"></i>
                        <h4 class="fw-bold mb-3">System Settings</h4>
                        <p class="text-muted">Configure system-wide settings</p>
                        <a href="/admin/settings" class="btn btn-custom">
                            <i class="fas fa-sliders-h me-2"></i>System Settings
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="action-card p-4 h-100">
                    <div class="text-center">
                        <i class="fas fa-chart-bar icon-large text-success"></i>
                        <h4 class="fw-bold mb-3">Reports</h4>
                        <p class="text-muted">View system reports and analytics</p>
                        <a href="/admin/reports" class="btn btn-custom">
                            <i class="fas fa-chart-line me-2"></i>View Reports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load user statistics with loading animation
        fetch('/api/users/stats')
            .then(response => response.json())
            .then(data => {
                // Add smooth counting animation
                function animateValue(id, start, end, duration) {
                    const element = document.getElementById(id);
                    const range = end - start;
                    const minTimer = 50;
                    const stepTime = Math.abs(Math.floor(duration / range));
                    const timer = stepTime < minTimer ? minTimer : stepTime;

                    const startTime = new Date().getTime();
                    const endTime = startTime + duration;

                    function run() {
                        const now = new Date().getTime();
                        const remaining = Math.max((endTime - now) / duration, 0);
                        const value = Math.round(end - (remaining * range));
                        element.innerHTML = value;
                        if (value == end) {
                            clearInterval(timer);
                        }
                    }

                    const timer_id = setInterval(run, timer);
                    run();
                }

                animateValue('total-users', 0, data.total || 0, 1000);
                animateValue('admin-users', 0, data.admins || 0, 1000);
                animateValue('regular-users', 0, data.users || 0, 1000);
            })
            .catch(error => {
                console.error('Error loading stats:', error);
                document.getElementById('total-users').innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
                document.getElementById('admin-users').innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
                document.getElementById('regular-users').innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
            });
    </script>
</body>
</html>