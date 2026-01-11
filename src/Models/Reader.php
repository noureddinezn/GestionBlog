<?php

namespace Src\Models;

class Reader extends User {
    public function __construct($username, $email, $password) {
        parent::__construct($username, $email, $password, 'reader');
    }
}
