<?php

namespace App;

require_once 'vendor/autoload.php';

session_start();
$nonce = bin2hex(random_bytes(16));
$_SESSION['nonce'] = $nonce;

// Instanciation des contrôleurs
$articleController = new Controllers\ArticleController();
$commentController = new Controllers\CommentController();
$userController = new Controllers\UserController();

// Récupération de l'action à exécuter depuis l'URL
$action = isset($_GET['action']) ? $_GET['action'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'articleList':
        $articleController->listArticles();
        break;
    case 'about':
        $articleController->aboutArticleList();
        break;
    case 'auth':
        $userController->auth();
        break;
    case 'article':
        $articleController->articleDetail();
        break;
    default:
        $articleController->homeArticleList();
        break;
}

// Routage en fonction de l'action
switch ($action) {
    case 'addArticle':
        $articleController->addArticle();
        break;

    case 'modifyArticle':
        $articleController->modifyArticle();
        break;

    case 'fetchArticle':
        $articleController->fetchArticle();
        break;

    case 'deleteArticle':
        $articleController->deleteArticle();
        break;

    case 'postComment':
        $commentController->postComment();
        break;

    case 'fetchCommentsForArticle':
        if (isset($_GET['articleId'])) {
            $commentController->fetchCommentsForArticle($_GET['articleId']);
        } else {
            echo 'Erreur : aucun identifiant d\'article envoyé pour les commentaires';
        }
        break;

    case 'deleteComment':
        if (isset($_GET['commentId'])) {
            $commentController->deleteComment($_GET['commentId']);
        } else {
            echo 'Erreur : aucun identifiant de commentaire envoyé';
        }
        break;

    case 'login':
        $userController->login();
        break;

    case 'register':
        $userController->register();
        break;

    case 'logout':
        $userController->logout();
        break;

    default:
        break;
}