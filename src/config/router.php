<?php

namespace App\Config;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\ProjectController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //Recupère l'URL en entier dans $uri
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
        

    //Routes Auth        
    case '/register':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();                //gestion des inscriptions
        break;
                
    case '/login':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();                   //gestion des logins
        break;
    
    case '/logout':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();                  //gestion du logout et suppr des cookies de session et du remember me 
        break;


    //Routes Users
    case '/profil':
        require_once __DIR__ . '/../controllers/UserController.php';
        $controller = new UserController();
        $controller->profil();
        break;                                  //affichage du profil

    
    //Routes Admin
        // case '/admin/dashboard'              //affichage dashboard
        // case '/admin/users'                  //affichage de tous les users
        // case '/admin/competences'            //affichage de toutes les compétences
        // case '/admin/competences/create'     //affichage du formulaire d'ajout de compétences
        // case '/admin/competences/delete'     //suppression d'une competences (redirect vers /admin/competences)



    //Routes Projects
    case '/project':
        require_once __DIR__ . '/../controllers/ProjectController.php';
        $controller = new ProjectController();
        $controller->project();
        break;                                  //affichage des projets

    case '/project/create':
        require_once __DIR__ . '/../controllers/ProjectController.php';
        $controller = new ProjectController();
        $controller->createProject();
        break;                                  //affichage des projets
        
    case '/project/delete':                   
        require_once __DIR__ . '/../controllers/ProjectController.php';
        $controller = new ProjectController();
        $controller->deleteProject();
        break;                                  //suppression d'un projet et redirection vers la route myproject pour le user et projects pour l'admin

        // case '/project/myprojects'               /affichages des projet du user avec possibilité de suppression et de modification
        // case '/project/update'                   //affichage formulaire de modification de projet et gestion de la modification + redirection vers myprojects
        // case '/project/:id'                      //affichage d'un projets complet avec modif
        
    //Route 404
    default : 
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;

}