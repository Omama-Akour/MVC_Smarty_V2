<?php

namespace App\controllers;

use App\models\User; // Import the User model
use Smarty;

class UserController {
    private $userModel;
    private $smarty;

    public function __construct() {
        session_start();
        $this->userModel = new User(); // Use the imported User model
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(BASE_PATH . DIRECTORY_SEPARATOR . 'templates');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? ''; 
            $email = $_POST['email'] ?? ''; 
            $password = $_POST['password'] ?? '';
            $passwordConfirmed = $_POST['password_confirmation'] ?? '';

            // Validate input
            if (empty($username) || empty($email) || empty($password) || $password !== $passwordConfirmed) {
                $this->smarty->assign('error', 'All fields are required and password must match confirmation');
                $this->smarty->display('register.tpl');
                return;
            }

            // Create user
            $user = $this->userModel->register($username, $email, $password);
            if ($user) {
                // Redirect to login page after successful registration
                header('Location: /mvcdashboard/login');
                exit();
            } else {
                // Display error message if registration fails
                $this->smarty->assign('error', 'Registration failed');
                $this->smarty->display('register.tpl');
            }
        } else {
            // Display registration form
            $this->smarty->display('register.tpl');
        }
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? ''; 
            $password = $_POST['password'] ?? '';
            $user = $this->userModel->login($email, $password);
            if ($user) {   
                // Start session and store user data
                
                $_SESSION['user_id'] = $user->id;
                $_SESSION['name'] = $user->username; // Store the user's name
                // $_SESSION['level'] = $user->level; // Assuming 'level' is a user attribute
                $_SESSION['logged_in'] = true;
// print_r( $_SESSION);
// exit;
                // Assign session variables to Smarty template variables
                // $this->assignSessionVariables();

                // Redirect to dashboard or any other page
                header('Location: /mvcdashboard/dashboard');
                exit();
            } else {
                // Display login form with error message
                $this->smarty->assign('error', 'Invalid email or password');
             
                $this->smarty->display('login.tpl');
            }
        } else {
            // Display login form
            $this->smarty->display('login.tpl');
        }  
    }

    // Add a method to assign session variables to Smarty template variables
    // private function assignSessionVariables() {
    //     if (isset($_SESSION['name'])) {
    //         $this->smarty->assign('name', $_SESSION['name']);
    //     } else {
    //         $this->smarty->assign('name', 'Guest');
    //     }

    //     if (isset($_SESSION['level'])) {
    //         $this->smarty->assign('level', $_SESSION['level']);
    //     } else {
    //         $this->smarty->assign('level', '');
    //     }
    // }
    
    public function assignSessionVariables($name) {
        // Check if user ID is set in the session
        if (isset($_SESSION['user_id'])) {
            // Retrieve user ID from session
            $userId = $_SESSION['user_id'];
            
            // Use the User model to fetch the user's name based on the user ID
            $userName = $this->userModel->getUserNameFromId($userId);
    
            // Check if the user's name is fetched successfully
            if ($userName) {
                // Assign the user's name to the Smarty template variable
                $this->smarty->assign('name', $userName);
            } else {
                // If the user's name cannot be fetched, assign a default value ('Guest')
                $this->smarty->assign('name', 'Guest');
            }
        } else {
            // If user ID is not set in the session, assign a default value ('Guest')
            $this->smarty->assign('name', $name);         }
    }
    
    

    public function logout() {
        // Destroy session and redirect to homepage
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('Location: /mvcdashboard/login');
        exit();
    }
    
    
}
?>
