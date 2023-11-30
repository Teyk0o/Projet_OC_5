<?php

namespace App\Controllers;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;

class UserController {

    private $userRepository;
    private $articleRepository;
    private $commentRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->articleRepository = new ArticleRepository();
        $this->commentRepository = new CommentRepository();
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

    public function auth() {
        $articleFooter = $this->articleRepository->getFooterArticle();

        // Incluez la vue
        require_once 'src/views/auth/index.php';
    }

    public function admin() {
        $userInfos = $this->userRepository->getUserInfos($_SESSION);

        if ($userInfos['role'] !== 'admin') {
            header('Location: /');
        }

        $articles = $this->articleRepository->getAllArticles();
        $unapprovedComments = $this->commentRepository->getUnappovedComments();

        foreach ($unapprovedComments as $comment) {
            $commentAuthor = $this->userRepository->getUserInfosById($comment->getAuthorId());
            $comment->setUsername($commentAuthor->getUsername());
        }

        $articleFooter = $this->articleRepository->getFooterArticle();

        // Incluez la vue
        require_once 'src/views/admin/index.php';
    }

    private function secureInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
