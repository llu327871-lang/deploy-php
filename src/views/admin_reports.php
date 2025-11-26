<?php
Auth::requireAdmin();

$user = Auth::getCurrentUser();

// Get statistics for reports
$userModel = new User();
$users = $userModel->getAll();

$totalUsers = count($users);
$adminUsers = count(array_filter($users, function($user) { return $user['role'] === 'admin'; }));
$regularUsers = count(array_filter($users, function($user) { return $user['role'] === 'user'; }));

// Calculate user registration trends (mock data for demo)
$monthlyRegistrations = [
    'Jan' => 5, 'Feb' => 8, 'Mar' => 12, 'Apr' => 15, 'May' => 10, 'Jun' => 18,
    'Jul' => 22, 'Aug' => 25, 'Sep' => 20, 'Oct' => 28, 'Nov' => 32, 'Dec' => 35
];

$recentUsers = array_slice(array_reverse($users), 0, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .report-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .report-card:hover {
            transform: translateY(-2px);
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .btn-export {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .recent-users-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        .recent-users-table td {
            border-color: #e9ecef;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>Reports & Analytics
                </h2>
                <p class="text-muted mb-0">Comprehensive insights into system usage and performance</p>
            </div>
            <div>
                <button class="btn btn-export me-2" onclick="exportReport('pdf')">
                    <i class="fas fa-file-pdf me-2"></i>Export PDF
                </button>
                <button class="btn btn-export" onclick="exportReport('csv')">
                    <i class="fas fa-file-csv me-2"></i>Export CSV
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $totalUsers; ?></div>
                    <div class="stat-label">Total Users</div>
                    <i class="fas fa-users fa-2x mt-2 opacity-75"></i>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $adminUsers; ?></div>
                    <div class="stat-label">Administrators</div>
                    <i class="fas fa-user-shield fa-2x mt-2 opacity-75"></i>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $regularUsers; ?></div>
                    <div class="stat-label">Regular Users</div>
                    <i class="fas fa-user-friends fa-2x mt-2 opacity-75"></i>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-number"><?php echo round($adminUsers / max($totalUsers, 1) * 100, 1); ?>%</div>
                    <div class="stat-label">Admin Ratio</div>
                    <i class="fas fa-percentage fa-2x mt-2 opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="report-card p-4">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-chart-line me-2 text-primary"></i>User Registration Trends
                    </h4>
                    <div class="chart-container">
                        <canvas id="registrationChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="report-card p-4">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-chart-pie me-2 text-success"></i>User Distribution
                    </h4>
                    <div class="chart-container">
                        <canvas id="distributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity and Top Statistics -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="report-card p-4">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-clock me-2 text-info"></i>Recent User Registrations
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-hover recent-users-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentUsers as $recentUser): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($recentUser['name']); ?></td>
                                    <td><?php echo htmlspecialchars($recentUser['email']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $recentUser['role'] === 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                            <?php echo htmlspecialchars($recentUser['role']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($recentUser['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="report-card p-4">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-trophy me-2 text-warning"></i>System Statistics
                    </h4>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 text-primary mb-1"><?php echo $totalUsers; ?></div>
                                <div class="small text-muted">Active Users</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 text-success mb-1"><?php echo count(array_filter($users, function($u) { return strtotime($u['created_at']) > strtotime('-30 days'); })); ?></div>
                                <div class="small text-muted">New This Month</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 text-info mb-1"><?php echo count(array_filter($users, function($u) { return strtotime($u['created_at']) > strtotime('-7 days'); })); ?></div>
                                <div class="small text-muted">New This Week</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 text-warning mb-1"><?php echo round($totalUsers / max((time() - strtotime('2024-01-01')) / (60*60*24), 1), 1); ?></div>
                                <div class="small text-muted">Avg/Day</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Registration Trends Chart
        const registrationCtx = document.getElementById('registrationChart').getContext('2d');
        new Chart(registrationCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_keys($monthlyRegistrations)); ?>,
                datasets: [{
                    label: 'New Registrations',
                    data: <?php echo json_encode(array_values($monthlyRegistrations)); ?>,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // User Distribution Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Administrators', 'Regular Users'],
                datasets: [{
                    data: [<?php echo $adminUsers; ?>, <?php echo $regularUsers; ?>],
                    backgroundColor: ['#dc3545', '#007bff'],
                    borderColor: ['#fff', '#fff'],
                    borderWidth: 3,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.parsed / total) * 100);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Export functions
        function exportReport(format) {
            // Mock export functionality
            if (format === 'pdf') {
                alert('PDF export feature would be implemented here. This would generate a comprehensive PDF report.');
            } else if (format === 'csv') {
                alert('CSV export feature would be implemented here. This would download user data as CSV.');
            }
        }
    </script>
</body>
</html>