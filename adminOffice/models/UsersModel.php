<?php

namespace Models;

class UsersModel extends Database {

    public function getAllUsers() {
        $req = "SELECT * FROM users ORDER BY id DESC";
        return $this ->findAll($req);
    }
    
    public function getUserByEmail($email) {
       
        return $this ->getOneByEmail("users", $email);
    }
}