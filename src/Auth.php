<?php
include __DIR__ . '/models/User.php';

class Auth {
    private static function logSecurityEvent($event, $details = '') {
        $logFile = __DIR__ . '/../logs/security.log';
        $logDir = dirname($logFile);

        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

        $logEntry = "[$timestamp] [$ip] [$userAgent] $event";
        if ($details) {
            $logEntry .= " - $details";
        }
        $logEntry .= "\n";

        @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    public static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function generateCSRFToken() {
        self::startSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken($token) {
        self::startSession();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    private static function checkRateLimit($email) {
        self::startSession();
        $key = 'login_attempts_' . md5($email);
        $now = time();

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 0, 'first_attempt' => $now];
        }

        $attempts = $_SESSION[$key];

        // Reset counter if more than 15 minutes have passed
        if ($now - $attempts['first_attempt'] > 900) {
            $_SESSION[$key] = ['count' => 0, 'first_attempt' => $now];
            $attempts = $_SESSION[$key];
        }

        // Allow max 5 attempts per 15 minutes
        if ($attempts['count'] >= 5) {
            return false;
        }

        return true;
    }

    private static function recordFailedAttempt($email) {
        self::startSession();
        $key = 'login_attempts_' . md5($email);

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 0, 'first_attempt' => time()];
        }

        $_SESSION[$key]['count']++;
    }

    private static function clearFailedAttempts($email) {
        self::startSession();
        $key = 'login_attempts_' . md5($email);
        unset($_SESSION[$key]);
    }

    public static function login($email, $password, $csrfToken = null) {
        // Validate CSRF token if provided
        if ($csrfToken && !self::validateCSRFToken($csrfToken)) {
            return false;
        }

        // Rate limiting check
        if (!self::checkRateLimit($email)) {
            return false;
        }

        $userModel = new User();
        $user = $userModel->authenticate($email, $password);

        if ($user) {
            self::startSession();
            // Regenerate session ID for security
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['login_time'] = time();

            // Clear failed attempts on successful login
            self::clearFailedAttempts($email);

            self::logSecurityEvent('LOGIN_SUCCESS', "User: {$user['email']}");
            return true;
        } else {
            // Record failed attempt
            self::recordFailedAttempt($email);
            self::logSecurityEvent('LOGIN_FAILED', "Email: $email");
            return false;
        }
    }

    public static function register($name, $email, $password, $csrfToken = null) {
        // Validate CSRF token if provided
        if ($csrfToken && !self::validateCSRFToken($csrfToken)) {
            return ['success' => false, 'message' => 'Invalid security token. Please refresh the page and try again.'];
        }

        // Sanitize and validate inputs
        $name = self::sanitizeInput($name);
        $email = self::sanitizeInput($email);

        if (!self::validateName($name)) {
            return ['success' => false, 'message' => 'Name must be 2-255 characters and contain only letters and spaces.'];
        }
        if (!self::validateEmail($email)) {
            return ['success' => false, 'message' => 'Please enter a valid email address.'];
        }
        if (!self::validatePassword($password)) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters long and contain uppercase, lowercase, and number.'];
        }

        $userModel = new User();

        // Check if user already exists
        if ($userModel->getByEmail($email)) {
            return ['success' => false, 'message' => 'An account with this email already exists.'];
        }

        // Create new user
        $userId = $userModel->create($name, $email, $password, 'user');
        if ($userId !== false) {
            self::logSecurityEvent('USER_REGISTERED', "Email: $email");
            return ['success' => true, 'message' => 'Registration successful! You can now login.'];
        } else {
            return ['success' => false, 'message' => 'Registration failed due to a database error. Please try again later.'];
        }
    }

    private static function sanitizeInput($input) {
        return trim(htmlspecialchars(strip_tags($input)));
    }

    public static function validateName($name) {
        return !empty($name) && strlen($name) >= 2 && strlen($name) <= 255 && preg_match('/^[a-zA-Z\s]+$/', $name);
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 255;
    }

    public static function validatePassword($password) {
        // At least 8 characters, 1 uppercase, 1 lowercase, 1 number
        return strlen($password) >= 8 &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[a-z]/', $password) &&
               preg_match('/[0-9]/', $password);
    }

    public static function requestPasswordReset($email) {
        $userModel = new User();

        // Check if user exists
        if (!$userModel->getByEmail($email)) {
            return true; // Don't reveal if email exists
        }

        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour

        // Store reset token
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        if ($conn->connect_error) {
            return false;
        }

        // Delete existing tokens for this email
        $conn->query("DELETE FROM password_resets WHERE email = '$email'");

        // Insert new token
        $sql = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $token, $expiresAt);

        $result = $stmt->execute();
        $conn->close();

        if ($result) {
            self::logSecurityEvent('PASSWORD_RESET_REQUESTED', "Email: $email");
            // In a real application, send email here
            // For demo purposes, we'll just return the token
            return $token;
        }

        return false;
    }

    public static function resetPassword($token, $newPassword) {
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        if ($conn->connect_error) {
            return false;
        }

        // Get reset request
        $sql = "SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $conn->close();
            return false;
        }

        $reset = $result->fetch_assoc();
        $email = $reset['email'];

        // Update password
        $userModel = new User();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashedPassword, $email);
        $passwordUpdated = $stmt->execute();

        // Delete reset token
        $conn->query("DELETE FROM password_resets WHERE token = '$token'");

        $conn->close();

        if ($passwordUpdated) {
            self::logSecurityEvent('PASSWORD_RESET_COMPLETED', "Email: $email");
        }

        return $passwordUpdated;
    }

    public static function logout() {
        self::startSession();
        $user = self::getCurrentUser();
        session_destroy();
        if ($user) {
            self::logSecurityEvent('LOGOUT', "User: {$user['email']}");
        }
    }

    public static function isLoggedIn() {
        self::startSession();

        // Check if session exists
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        // Check session timeout (24 hours)
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > 86400) {
            self::logout();
            return false;
        }

        return true;
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