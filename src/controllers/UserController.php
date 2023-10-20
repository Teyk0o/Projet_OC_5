<?php

namespace App\Controllers;

use App\Repository\UserRepository;

class UserController {

    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function login() {
        if (isset($_POST['email'], $_POST['password'])) {
            $email = $this->secureInput($_POST['email']);
            $password = $this->secureInput($_POST['password']);

            $this->userRepository->login($email, $password);
        } else {
            echo 'Informations d\'authentification manquantes.';
        }
    }

    public function register() {
        if (isset($_POST['email'], $_POST['password'], $_POST['username'])) {
            $email = $this->secureInput($_POST['email']);
            $password = $this->secureInput($_POST['password']);
            $username = $this->secureInput($_POST['username']);

            $this->userRepository->register($email, $password, $username);
        } else {
            echo 'Informations d\'inscription manquantes.';
        }
    }

    public function logout() {
        // Déco
    }

    private function secureInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
