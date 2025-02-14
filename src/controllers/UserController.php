<?php

namespace App\Controllers;

//class relative aux informations des utilisateurs.

class UserController{
    public function profil(){
        if(isset($_SESSION["user"])){
            require_once __DIR__ . '/../views/profil.php';
        }else{
            header('Location: /login');
            exit;
        }
    }
}