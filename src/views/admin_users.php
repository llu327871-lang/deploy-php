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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .table-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
        .btn-success-custom {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .btn-danger-custom {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            border-radius: 25px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        .btn-edit {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border: none;
            border-radius: 25px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.875rem;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
        }
        .badge-admin {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            font-weight: 600;
        }
        .badge-user {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            font-weight: 600;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.75rem;
            margin: 0 2px;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            background: white;
            color: #6c757d;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #667eea;
            color: white;
            border-color: #667eea;
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
        <div class="table-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">
                        <i class="fas fa-users me-2 text-primary"></i>User Management
                    </h2>
                    <p class="text-muted mb-0">Manage all users in the system</p>
                </div>
                <button class="btn btn-success-custom" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="fas fa-plus me-2"></i>Add New User
                </button>
            </div>

            <div class="table-responsive">
                <table id="usersTable" class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>ID</th>
                            <th><i class="fas fa-user me-1"></i>Name</th>
                            <th><i class="fas fa-envelope me-1"></i>Email</th>
                            <th><i class="fas fa-user-tag me-1"></i>Role</th>
                            <th><i class="fas fa-calendar me-1"></i>Created</th>
                            <th><i class="fas fa-cogs me-1"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Users will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Add New User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="createForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="createName" class="form-label fw-semibold">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                                <input type="text" class="form-control form-control-lg" id="createName" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createEmail" class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" class="form-control form-control-lg" id="createEmail" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="createPassword" class="form-label fw-semibold">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <input type="password" class="form-control form-control-lg" id="createPassword" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createRole" class="form-label fw-semibold">
                                    <i class="fas fa-user-tag me-2"></i>Role
                                </label>
                                <select class="form-select form-select-lg" id="createRole" name="role" required>
                                    <option value="user">User</option>
                                    <option value="admin">Administrator</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success-custom">
                            <i class="fas fa-save me-2"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editName" class="form-label fw-semibold">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                                <input type="text" class="form-control form-control-lg" id="editName" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editEmail" class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" class="form-control form-control-lg" id="editEmail" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label fw-semibold">
                                <i class="fas fa-user-tag me-2"></i>Role
                            </label>
                            <select class="form-select form-select-lg" id="editRole" name="role" required>
                                <option value="user">User</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        let users = [];
        let usersTable;

        // Initialize DataTable
        $(document).ready(function() {
            usersTable = $('#usersTable').DataTable({
                ajax: {
                    url: '/users',
                    type: 'GET'
                },
                columns: [
                    { data: 'id', width: '8%' },
                    { data: 'name', width: '20%' },
                    { data: 'email', width: '25%' },
                    {
                        data: 'role',
                        width: '15%',
                        render: function(data) {
                            return data === 'admin'
                                ? '<span class="badge badge-admin"><i class="fas fa-crown me-1"></i>Admin</span>'
                                : '<span class="badge badge-user"><i class="fas fa-user me-1"></i>User</span>';
                        }
                    },
                    {
                        data: 'created_at',
                        width: '17%',
                        render: function(data) {
                            return new Date(data).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                        }
                    },
                    {
                        data: null,
                        width: '15%',
                        orderable: false,
                        render: function(data) {
                            return `
                                <div class="btn-group" role="group">
                                    <button class="btn btn-edit btn-sm" onclick="editUser(${data.id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger-custom btn-sm" onclick="deleteUser(${data.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                pageLength: 10,
                responsive: true,
                language: {
                    search: '<i class="fas fa-search"></i>',
                    searchPlaceholder: 'Search users...',
                    lengthMenu: 'Show _MENU_ users per page',
                    info: 'Showing _START_ to _END_ of _TOTAL_ users',
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>'
                    }
                },
                initComplete: function() {
                    // Add search input styling
                    $('.dataTables_filter input').addClass('form-control form-control-lg');
                    $('.dataTables_filter input').attr('placeholder', 'Search users...');
                    $('.dataTables_filter label').contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();
                    $('.dataTables_filter').prepend('<label class="form-label fw-semibold"><i class="fas fa-search me-2"></i>Search Users:</label>');
                }
            });
        });

        // Create user
        document.getElementById('createForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
            submitBtn.disabled = true;

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
                    $('#createUserModal').modal('hide');
                    this.reset();
                    usersTable.ajax.reload();
                    showToast('User created successfully!', 'success');
                } else {
                    showToast('Error creating user: ' + (data.error || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Network error occurred', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Edit user
        function editUser(id) {
            fetch(`/users/${id}`)
                .then(response => response.json())
                .then(user => {
                    document.getElementById('editId').value = user.id;
                    document.getElementById('editName').value = user.name;
                    document.getElementById('editEmail').value = user.email;
                    document.getElementById('editRole').value = user.role;
                    $('#editUserModal').modal('show');
                })
                .catch(error => {
                    console.error('Error loading user:', error);
                    showToast('Error loading user data', 'error');
                });
        }

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = formData.get('id');
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;

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
                    $('#editUserModal').modal('hide');
                    usersTable.ajax.reload();
                    showToast('User updated successfully!', 'success');
                } else {
                    showToast('Error updating user: ' + (data.error || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Network error occurred', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Delete user
        function deleteUser(id) {
            const user = usersTable.rows().data().toArray().find(u => u.id == id);
            const userName = user ? user.name : 'this user';

            if (confirm(`Are you sure you want to delete "${userName}"? This action cannot be undone.`)) {
                fetch(`/users/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        usersTable.ajax.reload();
                        showToast('User deleted successfully!', 'success');
                    } else {
                        showToast('Error deleting user: ' + (data.error || 'Unknown error'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Network error occurred', 'error');
                });
            }
        }

        // Toast notification function
        function showToast(message, type) {
            const toastContainer = document.getElementById('toastContainer') || createToastContainer();

            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
            return container;
        }

        // Reset forms when modals are closed
        document.getElementById('createUserModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('createForm').reset();
        });

        document.getElementById('editUserModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('editForm').reset();
        });
    </script>
</body>
</html>