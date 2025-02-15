<?php

namespace App\Controllers;

//class relative aux projets, CRUD des projet et redirection des query.

class ProjectController{
    public function project(){
        if(isset($_SESSION["user"])){
            require_once __DIR__ . '/../views/project.php';
        }else{
            header('Location: /login');
            exit;
        }
    }
}