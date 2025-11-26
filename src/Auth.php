<?php
include __DIR__ . '/models/User.php';

class Auth {
    public static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login($email, $password) {
        $userModel = new User();
        $user = $userModel->authenticate($email, $password);

        if ($user) {
            self::startSession();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }

    public static function register($name, $email, $password) {
        $userModel = new User();

        // Check if user already exists
        if ($userModel->getByEmail($email)) {
            return false; // User already exists
        }

        // Create new user
        $userId = $userModel->create($name, $email, $password, 'user');
        return $userId !== false;
    }

    public static function logout() {
        self::startSession();
        session_destroy();
    }

    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['user_id']);
    }

    public static function getCurrentUser() {
        if (!self::isLoggedIn()) {
            return null;
        }
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
            'role' => $_SESSION['user_role']
        ];
    }

    public static function isAdmin() {
        $user = self::getCurrentUser();
        return $user && $user['role'] === 'admin';
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        if (!self::isAdmin()) {
            http_response_code(403);
            echo json_encode(['error' => 'Admin access required']);
            exit;
        }
    }
}