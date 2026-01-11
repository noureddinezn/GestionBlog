<?php

namespace Src\Models;

use PDO;

class Article extends Model {
    public $id;
    public $title;
    public $content;
    public $author_id;
    public $created_at;

    public function __construct($title = null, $content = null, $author_id = null) {
        parent::__construct();
        $this->title = $title;
        $this->content = $content;
        $this->author_id = $author_id;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM articles ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function save() {
        if (isset($this->id)) {
            return $this->update();
        }
        return $this->create();
    }

    private function create() {
        $stmt = $this->db->prepare("INSERT INTO articles (title, content, author_id) VALUES (:title, :content, :author_id)");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':author_id', $this->author_id);
        return $stmt->execute();
    }

    private function update() {
        $stmt = $this->db->prepare("UPDATE articles SET title = :title, content = :content WHERE id = :id");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
    
    public function delete() {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
    
    public function isAuthor($user_id) {
        return $this->author_id == $user_id;
    }
}
