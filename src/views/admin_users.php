<?php
Auth::requireAdmin();

$user = Auth::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
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
        .nav-links {
            display: flex;
            gap: 1rem;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem;
        }
        .nav-links a:hover {
            background-color: #495057;
            border-radius: 4px;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .actions {
            margin-bottom: 1rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            margin-right: 0.5rem;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .role-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .role-admin {
            background-color: #dc3545;
            color: white;
        }
        .role-user {
            background-color: #007bff;
            color: white;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Management</h1>
        <div class="nav-links">
            <a href="/admin/dashboard">Dashboard</a>
            <span>Welcome, <?php echo htmlspecialchars($user['name']); ?> (Admin)</span>
            <a href="/logout">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="actions">
            <button class="btn btn-success" onclick="openCreateModal()">Add New User</button>
        </div>

        <table id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Users will be loaded here -->
            </tbody>
        </table>
    </div>

    <!-- Create User Modal -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCreateModal()">&times;</span>
            <h2>Add New User</h2>
            <form id="createForm">
                <div class="form-group">
                    <label for="createName">Name:</label>
                    <input type="text" id="createName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="createEmail">Email:</label>
                    <input type="email" id="createEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="createPassword">Password:</label>
                    <input type="password" id="createPassword" name="password" required>
                </div>
                <div class="form-group">
                    <label for="createRole">Role:</label>
                    <select id="createRole" name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Create User</button>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit User</h2>
            <form id="editForm">
                <input type="hidden" id="editId" name="id">
                <div class="form-group">
                    <label for="editName">Name:</label>
                    <input type="text" id="editName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="editRole">Role:</label>
                    <select id="editRole" name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn">Update User</button>
            </form>
        </div>
    </div>

    <script>
        let users = [];

        // Load users
        function loadUsers() {
            fetch('/users')
                .then(response => response.json())
                .then(data => {
                    users = data;
                    renderUsers();
                })
                .catch(error => console.error('Error loading users:', error));
        }

        // Render users table
        function renderUsers() {
            const tbody = document.querySelector('#usersTable tbody');
            tbody.innerHTML = '';

            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td><span class="role-badge role-${user.role}">${user.role}</span></td>
                    <td>${new Date(user.created_at).toLocaleDateString()}</td>
                    <td>
                        <button class="btn" onclick="editUser(${user.id})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteUser(${user.id})">Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Create user
        document.getElementById('createForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/users', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: formData.get('name'),
                    email: formData.get('email'),
                    password: formData.get('password'),
                    role: formData.get('role')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    closeCreateModal();
                    loadUsers();
                } else {
                    alert('Error creating user: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Edit user
        function editUser(id) {
            const user = users.find(u => u.id == id);
            if (user) {
                document.getElementById('editId').value = user.id;
                document.getElementById('editName').value = user.name;
                document.getElementById('editEmail').value = user.email;
                document.getElementById('editRole').value = user.role;
                document.getElementById('editModal').style.display = 'block';
            }
        }

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = formData.get('id');

            fetch(`/users/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: formData.get('name'),
                    email: formData.get('email'),
                    role: formData.get('role')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    closeEditModal();
                    loadUsers();
                } else {
                    alert('Error updating user: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Delete user
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch(`/users/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        loadUsers();
                    } else {
                        alert('Error deleting user: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Modal functions
        function openCreateModal() {
            document.getElementById('createModal').style.display = 'block';
        }

        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
            document.getElementById('createForm').reset();
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.getElementById('editForm').reset();
        }

        // Load users on page load
        loadUsers();
    </script>
</body>
</html>