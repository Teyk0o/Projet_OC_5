<?php

namespace Controllers;

use Models\ArticleModel;

class ArticleController {

    private $articleModel;

    public function __construct() {
        $this->articleModel = new ArticleModel();
    }

    public function addArticle() {
        if (isset($_POST['titre'], $_POST['chapo'], $_POST['contenu'])) {
            $title = $this->secureInput($_POST['titre']);
            $chapo = $this->secureInput($_POST['chapo']);
            $content = $this->secureInput($_POST['contenu']);

            $this->articleModel->addArticle($title, $chapo, $content);
        } else {
            echo 'Veuillez remplir tous les champs.';
        }
    }

    public function modifyArticle() {
        if (isset($_POST['title'], $_POST['chapo'], $_POST['content'], $_POST['article_id'])) {
            $title = $this->secureInput($_POST['title']);
            $chapo = $this->secureInput($_POST['chapo']);
            $content = $this->secureInput($_POST['content']);
            $articleId = $this->secureInput($_POST['article_id']);

            $this->articleModel->modifyArticle($title, $chapo, $content, $articleId);
        } else {
            echo 'Veuillez remplir tous les champs.';
        }
    }

    public function fetchArticle() {
        if (isset($_POST['article_id'])) {
            $articleId = intval($this->secureInput($_POST['article_id']));
            $this->articleModel->fetchArticle($articleId);
        } else {
            echo 'ID de l\'article non spécifié.';
        }
    }

    public function deleteArticle() {
        if (isset($_POST['article_id'])) {
            $articleId = $this->secureInput($_POST['article_id']);
            $this->articleModel->deleteArticle($articleId);
        } else {
            echo 'ID de l\'article manquant.';
        }
    }

    private function secureInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function listArticles() {
        // Récupérez les données nécessaires depuis le modèle
        $articles = $this->articleModel->getAllArticles();
    
        // Incluez la vue
        require_once 'views/articles/index.php';
    }
    
}