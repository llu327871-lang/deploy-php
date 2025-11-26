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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 4px;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card h3 {
            margin: 0 0 0.5rem 0;
            color: #333;
        }
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }
        .actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }
        .action-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .action-card h3 {
            margin-top: 0;
            color: #333;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <div>
            <span>Welcome, <?php echo htmlspecialchars($user['name']); ?> (Admin)</span>
            <a href="/logout" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <div class="number" id="total-users">Loading...</div>
            </div>
            <div class="stat-card">
                <h3>Admin Users</h3>
                <div class="number" id="admin-users">Loading...</div>
            </div>
            <div class="stat-card">
                <h3>Regular Users</h3>
                <div class="number" id="regular-users">Loading...</div>
            </div>
        </div>

        <div class="actions">
            <div class="action-card">
                <h3>User Management</h3>
                <p>Manage all users in the system</p>
                <a href="/admin/users" class="btn">Manage Users</a>
                <a href="/admin/users/create" class="btn">Add New User</a>
            </div>

            <div class="action-card">
                <h3>System Settings</h3>
                <p>Configure system-wide settings</p>
                <a href="/admin/settings" class="btn">System Settings</a>
            </div>

            <div class="action-card">
                <h3>Reports</h3>
                <p>View system reports and analytics</p>
                <a href="/admin/reports" class="btn">View Reports</a>
            </div>
        </div>
    </div>

    <script>
        // Load user statistics
        fetch('/api/users/stats')
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-users').textContent = data.total || 0;
                document.getElementById('admin-users').textContent = data.admins || 0;
                document.getElementById('regular-users').textContent = data.users || 0;
            })
            .catch(error => console.error('Error loading stats:', error));
    </script>
</body>
</html>