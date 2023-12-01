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
            return false;
        }
    
        return new User($userData);
    }

    public function register($email, $password, $username) {
        // Vérifier si l'email existe déjà
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            return false;
        }

        // Si l'email n'existe pas, insérer le nouvel utilisateur
        $query = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $result = $stmt->execute([$email, $password, $username]);

        if (!$result) {
            throw new \Exception('Error while registering user');
        } else {
            return true;
        }
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