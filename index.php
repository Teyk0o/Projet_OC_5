<?php
// index.php

// Tableau de routage
$routes = [
    '/' => 'HomeController@index',
    '/article' => 'ArticleController@index',
    '/article/view' => 'ArticleController@view',
    // ... ajoutez d'autres routes ici
];

// Obtenez l'URI actuelle
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Vérifiez si l'URI existe dans le tableau de routage
if (isset($routes[$uri])) {
    list($controller, $method) = explode('@', $routes[$uri]);
    call_user_func_array([new $controller, $method], []);
} else {
    // Gérer les routes non trouvées
    echo "404 Not Found";
}