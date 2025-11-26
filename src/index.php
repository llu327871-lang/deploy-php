<?php
include __DIR__ . '/db.php';
include __DIR__ . '/Router.php';
include __DIR__ . '/Auth.php';

// Create router instance
$router = new Router();

// Home page - show landing page or redirect based on authentication
$router->get('/', function() {
    if (Auth::isLoggedIn()) {
        $user = Auth::getCurrentUser();
        if ($user['role'] === 'admin') {
            header('Location: /admin/dashboard');
        } else {
            header('Location: /dashboard');
        }
        exit;
    } else {
        include __DIR__ . '/views/landing.php';
    }
});

// Login routes
$router->get('/login', function() {
    if (Auth::isLoggedIn()) {
        header('Location: /');
        exit;
    }
    include __DIR__ . '/views/login.php';
});

$router->post('/login', function() {
    include __DIR__ . '/views/login.php';
});

// Register routes
$router->get('/register', function() {
    if (Auth::isLoggedIn()) {
        header('Location: /');
        exit;
    }
    include __DIR__ . '/views/register.php';
});

$router->post('/register', function() {
    include __DIR__ . '/views/register.php';
});

// Password reset routes
$router->get('/forgot-password', function() {
    if (Auth::isLoggedIn()) {
        header('Location: /');
        exit;
    }
    include __DIR__ . '/views/forgot_password.php';
});

$router->post('/forgot-password', function() {
    include __DIR__ . '/views/forgot_password.php';
});

$router->get('/reset-password', function() {
    if (Auth::isLoggedIn()) {
        header('Location: /');
        exit;
    }
    include __DIR__ . '/views/reset_password.php';
});

$router->post('/reset-password', function() {
    include __DIR__ . '/views/reset_password.php';
});

// Logout route
$router->get('/logout', function() {
    Auth::logout();
    header('Location: /');
    exit;
});

// Dashboard routes
$router->get('/dashboard', function() {
    Auth::requireLogin();
    include __DIR__ . '/views/user_dashboard.php';
});

$router->get('/admin/dashboard', function() {
    Auth::requireAdmin();
    include __DIR__ . '/views/admin_dashboard.php';
});

$router->get('/admin/users', function() {
    Auth::requireAdmin();
    include __DIR__ . '/views/admin_users.php';
});

$router->get('/admin/users/create', function() {
    Auth::requireAdmin();
    header('Location: /admin/users');
    exit;
});

$router->get('/admin/settings', function() {
    Auth::requireAdmin();
    include __DIR__ . '/views/admin_settings.php';
});

$router->post('/admin/settings', function() {
    Auth::requireAdmin();
    include __DIR__ . '/views/admin_settings.php';
});

$router->get('/admin/reports', function() {
    Auth::requireAdmin();
    include __DIR__ . '/views/admin_reports.php';
});

// Profile routes
$router->get('/profile', function() {
    Auth::requireLogin();
    include __DIR__ . '/views/profile.php';
});

$router->post('/profile', function() {
    Auth::requireLogin();
    include __DIR__ . '/views/profile.php';
});

// Features page
$router->get('/features', function() {
    Auth::requireLogin();
    include __DIR__ . '/views/features.php';
});

// Help & Support page
$router->get('/help', function() {
    Auth::requireLogin();
    include __DIR__ . '/views/help.php';
});

// Code Editor
$router->get('/editor', function() {
    Auth::requireLogin();
    include __DIR__ . '/views/editor.php';
});

$router->get('/users', function() {
    Auth::requireAdmin();
    $userModel = new User();
    $users = $userModel->getAll();
    header('Content-Type: application/json');
    echo json_encode($users);
});

$router->get('/api/users/stats', function() {
    Auth::requireAdmin();
    $userModel = new User();
    $users = $userModel->getAll();

    $stats = [
        'total' => count($users),
        'admins' => count(array_filter($users, function($user) { return $user['role'] === 'admin'; })),
        'users' => count(array_filter($users, function($user) { return $user['role'] === 'user'; }))
    ];

    header('Content-Type: application/json');
    echo json_encode($stats);
});

$router->get('/users/{id}', function($id) {
    Auth::requireAdmin();
    $userModel = new User();
    $user = $userModel->getById($id);
    header('Content-Type: application/json');
    if ($user) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
    }
});

$router->post('/users', function() {
    Auth::requireAdmin();

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Name, email, and password are required']);
        return;
    }

    $userModel = new User();
    $role = isset($data['role']) ? $data['role'] : 'user';
    $id = $userModel->create($data['name'], $data['email'], $data['password'], $role);

    if ($id) {
        http_response_code(201);
        echo json_encode(['id' => $id, 'name' => $data['name'], 'email' => $data['email'], 'role' => $role]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create user']);
    }
});

$router->put('/users/{id}', function($id) {
    Auth::requireAdmin();

    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || !isset($data['name']) || !isset($data['email']) || !isset($data['role'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Name, email, and role are required']);
        return;
    }

    $userModel = new User();
    $success = $userModel->update($id, $data['name'], $data['email'], $data['role']);

    if ($success) {
        echo json_encode(['id' => $id, 'name' => $data['name'], 'email' => $data['email'], 'role' => $data['role']]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update user']);
    }
});

$router->delete('/users/{id}', function($id) {
    Auth::requireAdmin();
    $userModel = new User();
    $success = $userModel->delete($id);

    if ($success) {
        echo json_encode(['message' => 'User deleted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete user']);
    }
});

// Dispatch the request
$router->dispatch();
