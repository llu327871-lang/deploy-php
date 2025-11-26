<?php
include __DIR__ . '/../db.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getAll() {
        $sql = "SELECT id, name, email, role, created_at FROM users";
        $result = $this->conn->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function getById($id) {
        $sql = "SELECT id, name, email, role, created_at FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($name, $email, $password, $role = 'user') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    public function update($id, $name, $email, $role) {
        $sql = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $role, $id);
        return $stmt->execute();
    }

    public function updateProfile($id, $name, $email, $password = null) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $email, $hashedPassword, $id);
        } else {
            $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $name, $email, $id);
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function authenticate($email, $password) {
        $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Don't return password
            return $user;
        }
        return false;
    }

    public function getByEmail($email) {
        $sql = "SELECT id, name, email, role, created_at FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function __destruct() {
        $this->conn->close();
    }
}