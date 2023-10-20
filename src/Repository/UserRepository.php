<?php

namespace App\Repository;

use App\Resources\DatabaseConnection;

class UserRepository {

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$email, $password]);
        return $stmt->fetch();
    }

    public function register($email, $password, $username) {
        $query = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$email, $password, $username]);
    }
}