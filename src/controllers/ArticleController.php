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

    public function addArticle($data) {
        if (isset($data['titre'], $data['chapo'], $data['contenu'])) {
            $title = $this->secureInput($data['titre']);
            $chapo = $this->secureInput($data['chapo']);
            $content = $this->secureInput($data['contenu']);
            $authorId = $this->secureInput($_SESSION['id']);

            $slug = $this->articleRepository->generateSlug($title);

            $query = $this->articleRepository->addArticle($title, $chapo, $content, $slug, $authorId);

            if ($query) {
                echo json_encode(['success' => true, 'message' => 'Article ajouté avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'article.']);
            }
        } else {
            echo 'Veuillez remplir tous les champs.';
        }
    }

    public function modifyArticle($data) {

        if (isset($data['title'], $data['chapo'], $data['content'], $data['article_id'])) {

            $article = $this->articleRepository->fetchArticle($this->secureInput($data['article_id']));
            
            $article->setTitle($this->secureInput($data['title']));
            $article->setChapo($this->secureInput($data['chapo']));
            $article->setContent($this->secureInput($data['content']));

            $result = $this->articleRepository->modifyArticle($article);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Article modifié avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification de l\'article.']);
            }

        } else {
            echo 'Veuillez remplir tous les champs.';
        }
    }

    public function fetchArticle($data) {
        if (isset($data['article_id'])) {
            $articleId = intval($this->secureInput($data['article_id']));
            $article = $this->articleRepository->fetchArticle($articleId);

            if ($article) {
                $articleArray = $article->toArray();
                echo json_encode(['success' => true, 'article' => $articleArray]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Article introuvable.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID de l\'article manquant.']);
        }
    }

    public function deleteArticle($data) {
        if (isset($data['article_id'])) {
            $articleId = $this->secureInput($data['article_id']);
            $query = $this->articleRepository->deleteArticle($articleId);

            if ($query) {
                echo json_encode(['success' => true, 'message' => 'Article supprimé avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de l\'article.']);
            }
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
            $userInfos = $this->userRepository->getUserInfos($_SESSION);

            // Incluez la vue
            require_once 'src/views/articles/article.php';
        } else {
            header('Location: ?page=articleList');
        }
    }
    
}