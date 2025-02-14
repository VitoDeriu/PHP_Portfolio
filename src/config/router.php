<?php

namespace App\Config;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\UserController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //Recupère l'URL en entier dans requestUri
$uri = rtrim($uri, '/'); //va supprimer un '/' a la fin de l'url si y'en a un
if ($uri === '') { //si y'a rien après avoir supprimer le dernier '/' on renvoi vers la page d'acceuil en en rajoutant un.
    $uri = '/';
}

switch($uri){
    case '/' :
        require_once __DIR__ . '/../controllers/HomeController.php';
        $controller = new HomeController();     //appel la classe HomeController
        $controller->home();                   //appel la fonction index qui va afficher la page index
        break;

    case '/login':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();                   //gestion des logins
        break;

    case '/register':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();                //gestion des inscriptions
        break;

    case '/profil':
        require_once __DIR__ . '/../controllers/UserController.php';
        $controller = new UserController();
        $controller->profil();
        break;                                  //affichage du profil

    case '/logout':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    default : 
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;

}