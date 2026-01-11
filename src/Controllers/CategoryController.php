<?php

namespace Src\Controllers;

use Src\Models\Category;

class CategoryController {
    
    private function ensureAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo "Access Denied: Admins only.";
            exit;
        }
    }

    public function index() {
        $categoryModel = new Category();
        $categories = $categoryModel->all();
        // View not implemented yet, just logic placeholder
    }

    public function create() {
        $this->ensureAdmin();
        // View for creating category
    }

    public function store() {
        $this->ensureAdmin();
        $name = $_POST['name'] ?? '';
        $category = new Category($name);
        if ($category->save()) {
             header('Location: /categories');
        }
    }
}
