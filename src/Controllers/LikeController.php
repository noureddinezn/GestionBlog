<?php

namespace Src\Controllers;

use Src\Models\Like;

class LikeController {
    public function toggle() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $article_id = $_POST['article_id'] ?? '';
        $user_id = $_SESSION['user_id'];

        $like = new Like($user_id, $article_id);
        $like->toggle();

        header("Location: /articles?id=$article_id");
    }
}
