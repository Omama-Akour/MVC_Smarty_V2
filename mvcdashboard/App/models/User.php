<?php
namespace App\models;

use App\models\Database;

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUserByEmail($email) {
        $email = $this->db->escapeString($email); // Sanitize input to prevent SQL injection
        $qry = "SELECT * FROM `users` WHERE email = '$email' LIMIT 1";
        $exec = $this->db->Query($qry);
        return mysqli_fetch_object($exec);
    }
    public function getUserByUsername($username) {
        $username = $this->db->escapeString($username); // Sanitize input to prevent SQL injection
        $qry = "SELECT * FROM `users` WHERE username = '$username' LIMIT 1";
        $exec = $this->db->Query($qry);
        return mysqli_fetch_object($exec);
    }

    public function updateUserActivity($userId, $isActive) {
        $qry = "UPDATE `users` SET `active` = $isActive WHERE id = $userId";
        return $this->db->Query($qry);
    }
    public function login($email, $password) {
        $hashedPassword = sha1($password);
        $user = $this->getUserByEmail($email);
        
        if ($user && $user->password == $hashedPassword && $user->active == 1) {
            // Update user's last activity or any other necessary tasks
            $this->updateUserActivity($user->id, 1);
            $_SESSION['user_id'] = $user->id;
            $_SESSION['name'] = $user->username; // Store the user's name
            $_SESSION['email'] = $user->email;
            $_SESSION['logged_in'] = true;
    
            return $user;
        } else {
            return false; // Invalid credentials or inactive account
        }
    }
    
 
    public function logout($userId) {
        // Update user's activity status when logging out
        $this->updateUserActivity($userId, 0);
        return true;
    }

    public function register($username, $email, $password) {
        $username = $this->db->escapeString($username);
        $email = $this->db->escapeString($email);
        $hashedPassword = sha1($password);
    
        // Check if the username already exists
        $existingUser = $this->getUserByUsername($username);
        if ($existingUser) {
            return false; // Username already exists, registration failed
        }
    
        // Check if the email already exists
        $existingEmail = $this->getUserByEmail($email);
        if ($existingEmail) {
            return false; // Email already exists, registration failed
        }
    
        // Insert the new user
        $qry = "INSERT INTO `users` (`username`, `email`, `password`, `active`) VALUES (?, ?, ?, 1)";
        $stmt = $this->db->prepare($qry);
    
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        $stmt->execute();
    
        // Check if the query executed successfully
        if ($stmt->affected_rows > 0) {
            return true; // Registration successful
        } else {
            return false; // Registration failed
        }
    }
    
    public function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    public function getUserNameFromId($userId) {
        // Sanitize input to prevent SQL injection
        $userId = $this->db->escapeString($userId);
    
        // Query the database to get the user's name based on user ID
        $qry = "SELECT name FROM `users` WHERE id = '$userId' LIMIT 1";
        $exec = $this->db->Query($qry);
        $user = mysqli_fetch_object($exec);
    
        // Check if user exists
        if ($user) {
            return $user->name;
        } else {
            return false; // User not found
        }
    }
    
}

?>
