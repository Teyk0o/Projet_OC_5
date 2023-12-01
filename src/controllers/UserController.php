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

    public function login($data) {
        if (isset($data['email'], $data['password'])) {
            $email = $this->secureInput($data['email']);
            $password = $this->secureInput($data['password']);

            $login = $this->userRepository->login($email, $password);

            if ($login) {
                $_SESSION['id'] = $login->getId();
                echo json_encode(['success' => true, 'message' => 'Vous êtes connecté.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Identifiants incorrects.']);
            }

        } else {
            echo json_encode(['success' => false, 'message' => 'Informations de connexion manquantes.']);
        }
    }

    public function register($data) {
        if (isset($data['email'], $data['password'], $data['username'])) {
            $email = $this->secureInput($data['email']);
            $password = $this->secureInput($data['password']);
            $username = $this->secureInput($data['username']);

            $register = $this->userRepository->register($email, $password, $username);

            if ($register) {
                echo json_encode(['success' => true, 'message' => 'Votre compte a bien été créé. Vous devez maintenant vous connecter.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Informations de connexion manquantes.']);
        }
    }

    public function logout() {
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Vous êtes déconnecté.']);
    }

    public function auth() {
        $articleFooter = $this->articleRepository->getFooterArticle();

        // Incluez la vue
        require_once 'src/views/auth/index.php';
    }

    public function admin() {
        $userInfos = $this->userRepository->getUserInfos($_SESSION);

        if ($userInfos->getRole() !== 'admin') {
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
