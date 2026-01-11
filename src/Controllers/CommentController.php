<?php

namespace Src\Controllers;

use Src\Models\Comment;

class CommentController {
    public function store() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $content = $_POST['content'] ?? '';
        $article_id = $_POST['article_id'] ?? '';
        $user_id = $_SESSION['user_id'];

        $comment = new Comment($content, $user_id, $article_id);
        $comment->save();

        header("Location: /articles?id=$article_id");
    }
}
