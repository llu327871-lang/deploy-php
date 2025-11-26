<?php
Auth::requireLogin();

$user = Auth::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - User Dashboard</title>
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
        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .btn-feature {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-feature:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 20px;
            padding: 3rem;
            margin-bottom: 3rem;
        }
        .badge-coming-soon {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="/dashboard">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
            <div class="d-flex align-items-center">
                <span class="badge bg-light text-dark me-3">
                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($user['name']); ?>
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="hero-section text-center">
            <i class="fas fa-rocket feature-icon text-primary"></i>
            <h1 class="fw-bold mb-3">Available Features</h1>
            <p class="lead text-muted mb-0">Explore the powerful features available in your dashboard</p>
        </div>

        <div class="row g-4">
            <!-- Profile Management -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-user-edit feature-icon text-success"></i>
                        <h4 class="fw-bold mb-3">Profile Management</h4>
                        <p class="text-muted mb-4">Update your personal information, change password, and manage your account settings.</p>
                        <a href="/profile" class="btn btn-feature">
                            <i class="fas fa-edit me-2"></i>Manage Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Analytics -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-chart-line feature-icon text-info"></i>
                        <h4 class="fw-bold mb-3">Analytics Dashboard</h4>
                        <p class="text-muted mb-4">View your activity statistics, usage patterns, and performance metrics.</p>
                        <button class="btn btn-feature" disabled>
                            <i class="fas fa-chart-line me-2"></i>Coming Soon
                        </button>
                        <div class="mt-2">
                            <span class="badge badge-coming-soon">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Management -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-folder-open feature-icon text-warning"></i>
                        <h4 class="fw-bold mb-3">File Management</h4>
                        <p class="text-muted mb-4">Upload, organize, and manage your files securely in the cloud.</p>
                        <button class="btn btn-feature" disabled>
                            <i class="fas fa-upload me-2"></i>Coming Soon
                        </button>
                        <div class="mt-2">
                            <span class="badge badge-coming-soon">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Collaboration Tools -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-users feature-icon text-primary"></i>
                        <h4 class="fw-bold mb-3">Team Collaboration</h4>
                        <p class="text-muted mb-4">Work together with your team members, share resources, and communicate effectively.</p>
                        <button class="btn btn-feature" disabled>
                            <i class="fas fa-users me-2"></i>Coming Soon
                        </button>
                        <div class="mt-2">
                            <span class="badge badge-coming-soon">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Code Editor -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-code feature-icon text-secondary"></i>
                        <h4 class="fw-bold mb-3">Code Editor</h4>
                        <p class="text-muted mb-4">Built-in code editor with syntax highlighting and multiple language support.</p>
                        <a href="/editor" class="btn btn-feature">
                            <i class="fas fa-code me-2"></i>Open Editor
                        </a>
                    </div>
                </div>
            </div>

            <!-- API Access -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-plug feature-icon text-danger"></i>
                        <h4 class="fw-bold mb-3">API Access</h4>
                        <p class="text-muted mb-4">Access our REST API to integrate with external applications and services.</p>
                        <button class="btn btn-feature" disabled>
                            <i class="fas fa-plug me-2"></i>Coming Soon
                        </button>
                        <div class="mt-2">
                            <span class="badge badge-coming-soon">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-bell feature-icon text-info"></i>
                        <h4 class="fw-bold mb-3">Notifications</h4>
                        <p class="text-muted mb-4">Stay updated with real-time notifications about important events and activities.</p>
                        <button class="btn btn-feature" disabled>
                            <i class="fas fa-bell me-2"></i>Coming Soon
                        </button>
                        <div class="mt-2">
                            <span class="badge badge-coming-soon">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Center -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-shield-alt feature-icon text-success"></i>
                        <h4 class="fw-bold mb-3">Security Center</h4>
                        <p class="text-muted mb-4">Monitor your account security, view login history, and manage security settings.</p>
                        <button class="btn btn-feature" disabled>
                            <i class="fas fa-shield-alt me-2"></i>Coming Soon
                        </button>
                        <div class="mt-2">
                            <span class="badge badge-coming-soon">Coming Soon</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help & Support -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4">
                    <div class="text-center">
                        <i class="fas fa-question-circle feature-icon text-warning"></i>
                        <h4 class="fw-bold mb-3">Help & Support</h4>
                        <p class="text-muted mb-4">Get help with using the platform, access documentation, and contact support.</p>
                        <a href="/help" class="btn btn-feature">
                            <i class="fas fa-question-circle me-2"></i>Get Help
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-5">
            <div class="hero-section">
                <h3 class="fw-bold mb-3">Need More Features?</h3>
                <p class="text-muted mb-4">We're constantly adding new features based on user feedback. Let us know what you'd like to see next!</p>
                <a href="/help" class="btn btn-feature btn-lg">
                    <i class="fas fa-envelope me-2"></i>Contact Support
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>