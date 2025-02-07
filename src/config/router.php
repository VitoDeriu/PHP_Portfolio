<?php

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //Recupère l'URL en entier dans requestUri
$requestUri = rtrim($requestUri, '/'); //va supprimer un '/' a la fin de l'url si y'en a un
if ($requestUri === '') { //si y'a rien après avoir supprimer le dernier '/' on renvoi vers la page d'acceuil en en rajoutant un.
    $requestUri = '/';
}

// On va définir les différentes routes disponibles dans un tableau associatif [ key(route) => value(fichier) ]
$routes = [
    '/' => 'home.php',
    '/register' => 'register.php',
    '/login' => 'login.php'
]; 

//check si la route existe on envoie la bonne view correspondante dans le tableau $routes
if (array_key_exists($requestUri, $routes)) {
    require __DIR__ . '/../views/' . $routes[$requestUri];
} else { //si non on renvoi une erreur 404 
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
}



