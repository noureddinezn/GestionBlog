<?php

namespace Src\Controllers;

use Src\Models\Article;

class ArticleController {
    
    private function ensureAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    private function ensureAuthorOrAdmin() {
        $this->ensureAuth();
        if ($_SESSION['role'] !== 'author' && $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo "Access Denied";
            exit;
        }
    }

    public function index() {
        $articleModel = new Article();
        $articles = $articleModel->all();
        require __DIR__ . '/../views/articles/index.php';
    }

    public function show($id) {
        $articleModel = new Article();
        // Determine ID from GET if not passed (though router usually handles this, our simple router might need help)
        // If the method signature implies ID passed by router:
        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        $article = $articleModel->find($id);
        if (!$article) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
            return;
        }
        require __DIR__ . '/../views/articles/show.php';
    }

    public function create() {
        $this->ensureAuthorOrAdmin();
        require __DIR__ . '/../views/articles/create.php';
    }

    public function store() {
        $this->ensureAuthorOrAdmin();
        
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $author_id = $_SESSION['user_id'];

        $article = new Article($title, $content, $author_id);
        if ($article->save()) {
            header('Location: /articles');
        } else {
            echo "Error";
        }
    }
}
