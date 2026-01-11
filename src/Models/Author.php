<?php

namespace Src\Models;

class Author extends User {
    public function __construct($username, $email, $password) {
        parent::__construct($username, $email, $password, 'author');
    }

    public function createPost() {
        // Logic
    }
}
