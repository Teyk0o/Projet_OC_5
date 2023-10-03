<?php

namespace Controllers;

use Models\UserModel;

class UserController {

    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if (isset($_POST['email'], $_POST['password'])) {
            $email = $this->secureInput($_POST['email']);
            $password = $this->secureInput($_POST['password']);

            $this->userModel->login($email, $password);
        } else {
            echo 'Informations d\'authentification manquantes.';
        }
    }

    public function register() {
        if (isset($_POST['email'], $_POST['password'], $_POST['username'])) {
            $email = $this->secureInput($_POST['email']);
            $password = $this->secureInput($_POST['password']);
            $username = $this->secureInput($_POST['username']);

            $this->userModel->register($email, $password, $username);
        } else {
            echo 'Informations d\'inscription manquantes.';
        }
    }

    public function logout() {
        $this->userModel->logout();
    }

    private function secureInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
