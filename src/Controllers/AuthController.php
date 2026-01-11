<?php

namespace Src\Controllers;

use Src\Models\User;
use Src\Models\Reader;

class AuthController {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::findByEmail($email);

            if ($user && $user->verifyPassword($password)) {
                // Set session
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['role'] = $user->getRole();
                $_SESSION['username'] = $user->getUsername();
                
                header('Location: /');
                exit;
            } else {
                $error = "Invalid credentials";
                require __DIR__ . '/../views/auth/login.php';
            }
        } else {
            require __DIR__ . '/../views/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // As Reader by default
            $user = new Reader($username, $email, $password);
            
            if ($user->save()) {
                header('Location: /login');
                exit;
            } else {
                $error = "Registration failed";
                require __DIR__ . '/../views/auth/register.php';
            }
        } else {
            require __DIR__ . '/../views/auth/register.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}
