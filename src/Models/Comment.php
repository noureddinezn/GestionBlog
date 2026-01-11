<?php

namespace Src\Models;

use PDO;

class Comment extends Model {
    public $id;
    public $content;
    public $user_id;
    public $article_id;
    public $created_at;

    public function __construct($content = null, $user_id = null, $article_id = null) {
        parent::__construct();
        $this->content = $content;
        $this->user_id = $user_id;
        $this->article_id = $article_id;
    }

    public function save() {
        $stmt = $this->db->prepare("INSERT INTO comments (content, user_id, article_id) VALUES (:content, :user_id, :article_id)");
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':article_id', $this->article_id);
        return $stmt->execute();
    }
    
    public function getByArticle($article_id) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at DESC");
        $stmt->bindParam(':article_id', $article_id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
