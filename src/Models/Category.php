<?php

namespace Src\Models;

use PDO;

class Category extends Model {
    public $id;
    public $name;

    public function __construct($name = null) {
        parent::__construct();
        $this->name = $name;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function save() {
        $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->bindParam(':name', $this->name);
        return $stmt->execute();
    }
}
