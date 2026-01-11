<?php

namespace Src\Models;

use PDO;
use Src\Config\Database;

abstract class User extends Model {
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $role;

    public function __construct($username = null, $email = null, $password = null, $role = null) {
        parent::__construct();
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    
    public function setId($id) { $this->id = $id; }

    public function save() {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public static function findByEmail($email) {
        $db = (new Database())->getConnection();
        
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return self::factory($data);
        }
        return null;
    }

    public static function factory($data) {
        $role = $data['role'];
        switch ($role) {
            case 'admin':
                $user = new Admin($data['username'], $data['email'], $data['password']);
                break;
            case 'author':
                $user = new Author($data['username'], $data['email'], $data['password']);
                break;
            default:
                $user = new Reader($data['username'], $data['email'], $data['password']);
                break;
        }
        $user->setId($data['id']);
        return $user;
    }
    
    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }
}
