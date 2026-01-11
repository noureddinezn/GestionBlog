<?php

namespace Src\Models;

class Admin extends User {
    public function __construct($username, $email, $password) {
        parent::__construct($username, $email, $password, 'admin');
    }

    public function manageSite() {
        // Logic
    }
}
