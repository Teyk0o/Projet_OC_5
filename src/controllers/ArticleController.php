<?php

namespace App\Controllers;

use App\Repository\ArticleRepository;

class ArticleController {

    private $articleRepository;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
    }

    public function addArticle() {
        if (isset($_POST['titre'], $_POST['chapo'], $_POST['contenu'])) {
            $title = $this->secureInput($_POST['titre']);
            $chapo = $this->secureInput($_POST['chapo']);
            $content = $this->secureInput($_POST['contenu']);

            $this->articleRepository->addArticle($title, $chapo, $content);
        } else {
            echo 'Veuillez remplir tous les champs.';
        }
    }

    public function modifyArticle() {

        if (isset($_POST['title'], $_POST['chapo'], $_POST['content'], $_POST['article_id'])) {

            $article = $this->articleRepository->fetchArticle($this->secureInput($_POST['article_id']));
            
            $article->setTitle($this->secureInput($_POST['title']));
            $article->setChapo($this->secureInput($_POST['chapo']));
            $article->setContent($this->secureInput($_POST['content']));

            $this->articleRepository->modifyArticle($article);
        } else {
            echo 'Veuillez remplir tous les champs.';
        }
    }

    public function fetchArticle() {
        if (isset($_POST['article_id'])) {
            $articleId = intval($this->secureInput($_POST['article_id']));
            $this->articleRepository->fetchArticle($articleId);
        } else {
            echo 'ID de l\'article non spécifié.';
        }
    }

    public function deleteArticle() {
        if (isset($_POST['article_id'])) {
            $articleId = $this->secureInput($_POST['article_id']);
            $this->articleRepository->deleteArticle($articleId);
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
        $articles = $this->articleRepository->getAllArticles();
        $mostCommentedArticles = $this->articleRepository->getMostCommentedArticles();
        $articleFooter = $this->articleRepository->getFooterArticle();
    
        // Incluez la vue
        require_once 'src/views/articles/index.php';
    }
    
}