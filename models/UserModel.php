<?php

namespace Models;

class UserModel {

    private $db;

    public function __construct() {
        // Vous devrez initialiser la connexion à la base de données ici.
        // $this->db = new DatabaseConnection();
    }

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email, $password]);
        return $stmt->fetch();
    }

    public function register($email, $password, $username) {
        $query = "INSERT INTO users (email, password, username) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email, $password, $username]);
    }

    public function logout() {
        // Implémentez la logique de déconnexion ici
    }
}