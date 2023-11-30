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

    public function getUserInfos($session) {
        if (isset($session) && isset($session['id'])) {
            $query = "SELECT * FROM users WHERE id = ?";
            $stmt = DatabaseConnection::getPDO()->prepare($query);
            $stmt->execute([$session['id']]);
            $userData = $stmt->fetch();
        
            if (!$userData) {
                throw new \Exception('User not found');
            }
        
            return new User($userData);
        }
    }

    public function getUserInfosById($id) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$id]);
        $userData = $stmt->fetch();
    
        if (!$userData) {
            throw new \Exception('User not found');
        }
    
        return new User($userData);
    }

    public function getUserNonce($session) {
        if (isset($session)) {
            return $session['nonce'];
        } else {
            throw new \Exception('No session found');
        }
    }
}