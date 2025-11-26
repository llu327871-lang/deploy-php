<?php
Auth::requireAdmin();

$user = Auth::getCurrentUser();

// Handle form submissions
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_site_settings':
                // In a real application, you'd save these to a database
                $message = 'Site settings updated successfully!';
                $messageType = 'success';
                break;

            case 'update_security_settings':
                $message = 'Security settings updated successfully!';
                $messageType = 'success';
                break;

            case 'update_email_settings':
                $message = 'Email settings updated successfully!';
                $messageType = 'success';
                break;

            case 'clear_cache':
                $message = 'Cache cleared successfully!';
                $messageType = 'success';
                break;

            case 'backup_database':
                $message = 'Database backup completed successfully!';
                $messageType = 'success';
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings - Admin Panel</title>
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
        .settings-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .settings-card:hover {
            transform: translateY(-2px);
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
        .setting-item {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
            transition: background-color 0.3s ease;
        }
        .setting-item:hover {
            background-color: #f8f9fa;
        }
        .setting-item:last-child {
            border-bottom: none;
        }
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .icon-large {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="/admin/dashboard">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
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

    <div class="container mt-4">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="settings-card p-3">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-cogs me-2 text-primary"></i>Settings Menu
                    </h5>
                    <div class="nav nav-pills flex-column" role="tablist">
                        <a class="nav-link active" data-bs-toggle="pill" href="#general">
                            <i class="fas fa-globe me-2"></i>General
                        </a>
                        <a class="nav-link" data-bs-toggle="pill" href="#security">
                            <i class="fas fa-shield-alt me-2"></i>Security
                        </a>
                        <a class="nav-link" data-bs-toggle="pill" href="#email">
                            <i class="fas fa-envelope me-2"></i>Email
                        </a>
                        <a class="nav-link" data-bs-toggle="pill" href="#maintenance">
                            <i class="fas fa-tools me-2"></i>Maintenance
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="tab-content">
                    <!-- General Settings -->
                    <div id="general" class="tab-pane fade show active">
                        <div class="settings-card p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="fas fa-globe icon-large text-primary"></i>
                                <div class="ms-3">
                                    <h3 class="fw-bold mb-1">General Settings</h3>
                                    <p class="text-muted mb-0">Configure basic site settings and preferences</p>
                                </div>
                            </div>

                            <form method="POST">
                                <input type="hidden" name="action" value="update_site_settings">

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Site Title</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="site_title" value="Admin Control Panel" placeholder="Enter site title">
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Site Description</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea class="form-control" name="site_description" rows="2" placeholder="Enter site description">A comprehensive user management system</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Default Language</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-select" name="default_language">
                                                <option value="en" selected>English</option>
                                                <option value="es">Spanish</option>
                                                <option value="fr">French</option>
                                                <option value="de">German</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Timezone</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-select" name="timezone">
                                                <option value="UTC" selected>UTC</option>
                                                <option value="America/New_York">Eastern Time</option>
                                                <option value="Europe/London">London</option>
                                                <option value="Asia/Bangkok">Bangkok</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Maintenance Mode</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenanceMode">
                                                <label class="form-check-label" for="maintenanceMode">
                                                    Enable maintenance mode
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-custom">
                                        <i class="fas fa-save me-2"></i>Save General Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div id="security" class="tab-pane fade">
                        <div class="settings-card p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="fas fa-shield-alt icon-large text-success"></i>
                                <div class="ms-3">
                                    <h3 class="fw-bold mb-1">Security Settings</h3>
                                    <p class="text-muted mb-0">Configure security and authentication settings</p>
                                </div>
                            </div>

                            <form method="POST">
                                <input type="hidden" name="action" value="update_security_settings">

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Session Timeout (minutes)</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" class="form-control" name="session_timeout" value="60" min="15" max="480">
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Password Policy</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="require_uppercase" id="requireUppercase" checked>
                                                <label class="form-check-label" for="requireUppercase">
                                                    Require uppercase letters
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="require_numbers" id="requireNumbers" checked>
                                                <label class="form-check-label" for="requireNumbers">
                                                    Require numbers
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="require_special" id="requireSpecial">
                                                <label class="form-check-label" for="requireSpecial">
                                                    Require special characters
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Two-Factor Authentication</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="enable_2fa" id="enable2FA">
                                                <label class="form-check-label" for="enable2FA">
                                                    Enable 2FA for all users
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Login Attempts</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label small">Max attempts</label>
                                                    <input type="number" class="form-control" name="max_login_attempts" value="5" min="3" max="10">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label small">Lockout time (minutes)</label>
                                                    <input type="number" class="form-control" name="lockout_time" value="15" min="5" max="60">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-custom">
                                        <i class="fas fa-save me-2"></i>Save Security Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div id="email" class="tab-pane fade">
                        <div class="settings-card p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="fas fa-envelope icon-large text-info"></i>
                                <div class="ms-3">
                                    <h3 class="fw-bold mb-1">Email Settings</h3>
                                    <p class="text-muted mb-0">Configure email server and notification settings</p>
                                </div>
                            </div>

                            <form method="POST">
                                <input type="hidden" name="action" value="update_email_settings">

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">SMTP Server</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="smtp_server" value="smtp.gmail.com" placeholder="smtp.example.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">SMTP Port</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" class="form-control" name="smtp_port" value="587" placeholder="587">
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">SMTP Username</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="smtp_username" placeholder="your-email@example.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="setting-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold mb-0">Email Notifications</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="notify_new_user" id="notifyNewUser" checked>
                                                <label class="form-check-label" for="notifyNewUser">
                                                    Notify admins of new user registrations
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="notify_login" id="notifyLogin">
                                                <label class="form-check-label" for="notifyLogin">
                                                    Notify on failed login attempts
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-custom">
                                        <i class="fas fa-save me-2"></i>Save Email Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Maintenance Settings -->
                    <div id="maintenance" class="tab-pane fade">
                        <div class="settings-card p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="fas fa-tools icon-large text-warning"></i>
                                <div class="ms-3">
                                    <h3 class="fw-bold mb-1">System Maintenance</h3>
                                    <p class="text-muted mb-0">Perform system maintenance tasks</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-broom fa-3x text-info mb-3"></i>
                                            <h5 class="card-title">Clear Cache</h5>
                                            <p class="card-text text-muted">Clear application cache to improve performance</p>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="action" value="clear_cache">
                                                <button type="submit" class="btn btn-outline-info">
                                                    <i class="fas fa-broom me-2"></i>Clear Cache
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-database fa-3x text-success mb-3"></i>
                                            <h5 class="card-title">Database Backup</h5>
                                            <p class="card-text text-muted">Create a backup of the database</p>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="action" value="backup_database">
                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="fas fa-download me-2"></i>Backup Database
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                                            <h5 class="card-title">System Logs</h5>
                                            <p class="card-text text-muted">View and manage system logs</p>
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="fas fa-file-alt me-2"></i>View Logs
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chart-line fa-3x text-danger mb-3"></i>
                                            <h5 class="card-title">System Health</h5>
                                            <p class="card-text text-muted">Check system performance and health</p>
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-chart-line me-2"></i>Check Health
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>