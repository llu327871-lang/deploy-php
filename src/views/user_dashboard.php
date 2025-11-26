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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #007bff;
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
        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            text-align: center;
        }
        .welcome-card h2 {
            color: #333;
            margin-top: 0;
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
        .profile-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .profile-info p {
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Dashboard</h1>
        <div>
            <span>Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
            <a href="/logout" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h2>Welcome to your Dashboard</h2>
            <p>You are logged in as a regular user. Here you can manage your account and access available features.</p>
        </div>

        <div class="actions">
            <div class="action-card">
                <h3>My Profile</h3>
                <div class="profile-info">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                </div>
                <a href="/profile" class="btn">Edit Profile</a>
            </div>

            <div class="action-card">
                <h3>Available Features</h3>
                <p>Access various features available to users</p>
                <a href="/features" class="btn">Browse Features</a>
            </div>

            <div class="action-card">
                <h3>Help & Support</h3>
                <p>Get help and support for using the system</p>
                <a href="/help" class="btn">Get Help</a>
            </div>
        </div>
    </div>
</body>
</html>