<?php

namespace Src\Models;

use PDO;

class Like extends Model {
    public $id;
    public $user_id;
    public $article_id;

    public function __construct($user_id = null, $article_id = null) {
        parent::__construct();
        $this->user_id = $user_id;
        $this->article_id = $article_id;
    }

    public function toggle() {
        if ($this->exists()) {
            return $this->remove();
        }
        return $this->add();
    }

    public function exists() {
        $stmt = $this->db->prepare("SELECT id FROM likes WHERE user_id = :user_id AND article_id = :article_id");
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':article_id', $this->article_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    private function add() {
        $stmt = $this->db->prepare("INSERT INTO likes (user_id, article_id) VALUES (:user_id, :article_id)");
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':article_id', $this->article_id);
        return $stmt->execute();
    }

    private function remove() {
        $stmt = $this->db->prepare("DELETE FROM likes WHERE user_id = :user_id AND article_id = :article_id");
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':article_id', $this->article_id);
        return $stmt->execute();
    }
    
    public function countByArticle($article_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM likes WHERE article_id = :article_id");
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
