<?php

namespace App\Repository;

use App\Entities\User;
use App\Resources\DatabaseConnection;

class UserRepository {

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$email, $password]);
        $userData = $stmt->fetch();
    
        if (!$userData) {
            throw new \Exception('Invalid email or password');
        }
    
        return new User($userData);
    }

    public function register($email, $password, $username) {
        $query = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$email, $password, $username]);
    }
}