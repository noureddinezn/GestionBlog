<?php

namespace Src\Models;

use Src\Config\Database;
use PDO;

abstract class Model {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
}
