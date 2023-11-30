<?php

namespace App\Controllers;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;

class ArticleController {

    private $articleRepository;
    private $userRepository;
    private $commentRepository;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
        $this->userRepository = new UserRepository();
        $this->commentRepository = new CommentRepository();
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
        $userInfos = $this->userRepository->getUserInfos($_SESSION);
        $articles = $this->articleRepository->getAllArticles();
        $mostCommentedArticles = $this->articleRepository->getMostCommentedArticles();
        $articleFooter = $this->articleRepository->getFooterArticle();
        $lastArticles = $this->articleRepository->getLastArticles();
    
        // Incluez la vue
        require_once 'src/views/articles/index.php';
    }

    public function homeArticleList() {
        // Récupérez les données nécessaires depuis le modèle
        $userInfos = $this->userRepository->getUserInfos($_SESSION);
        $randomArticle = $this->articleRepository->getRandomArticles(1);
        $randomArticles = $this->articleRepository->getRandomArticles(5);
        $nonce = $this->userRepository->getUserNonce($_SESSION);
        $articleFooter = $this->articleRepository->getFooterArticle();

        // Incluez la vue
        require_once 'src/views/home/index.php';
    }

    public function aboutArticleList() {
        // Récupérez les données nécessaires depuis le modèle
        $userInfos = $this->userRepository->getUserInfos($_SESSION);
        $articleFooter = $this->articleRepository->getFooterArticle();

        // Incluez la vue
        require_once 'src/views/home/about.php';
    }

    public function articleDetail() {

        if (isset($_GET['slug'])) {
            $articleSlug = $this->secureInput($_GET['slug']);
            $article = $this->articleRepository->fetchArticleWithSlug($articleSlug);

            $articleAuthor = $this->userRepository->getUserInfosById($article->getAuthorId());
            $article->setUsername($articleAuthor->getUsername());

            $comments = $this->commentRepository->fetchCommentsForArticle($article->getId());

            foreach ($comments as $comment) {
                $commentAuthor = $this->userRepository->getUserInfosById($comment->getAuthorId());
                $comment->setUsername($commentAuthor->getUsername());
            }

            $mostCommentedArticles = $this->articleRepository->getMostCommentedArticles();
            $articleFooter = $this->articleRepository->getFooterArticle();
            $lastArticles = $this->articleRepository->getLastArticles();


            // Incluez la vue
            require_once 'src/views/articles/article.php';
        } else {
            header('Location: ?page=articleList');
        }
    }
    
}