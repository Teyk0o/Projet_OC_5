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

// On empêche l'affichage d'une page si c'est un appel AJAX
if (!isset($action) || empty($action)) {
    switch ($page) {
        case 'admin':
            $userController->admin();
            break;
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
}

// Routage en fonction de l'action (appel AJAX)
switch ($action) {

    case 'login':
        $userController->login($_POST);
        break;
        
    case 'register':
        $userController->register($_POST);
        break;    

    case 'logout':
        $userController->logout();
        break;    

    case 'comment':
        $commentController->postComment($_POST);
        break;    

    case 'addArticle':
        $articleController->addArticle($_POST);
        break;   
    
    case 'modifyArticle':
        $articleController->modifyArticle($_POST);
        break;

    case 'fetchArticle':
        $articleController->fetchArticle($_POST);
        break;
        
    case 'deleteArticle':
        $articleController->deleteArticle($_POST);
        break;
        
    case 'approveComment':
        $commentController->approveComment($_POST);
        break;

    case 'disapproveComment':
        $commentController->disapproveComment($_POST);
        break;    

    default:
        break;
}