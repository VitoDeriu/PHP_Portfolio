<?php

namespace App\Controllers;

use Exception;
use App\Models\User;

//class relative aux informations de connexion. 

class AuthController{

    public function login(){

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset($_SESSION["user"]["id"])){
                header('Location: /profil');
                exit;
            }else{
                require_once __DIR__ . '/../views/login.php';

            }
        }

        elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_SESSION["errors"] = []; //clean des erreurs de session

            //recup les données du formulaire 
            if(!(isset($_POST["email"]) && !empty($_POST["email"]))){
                $_SESSION["errors"]["email"] ="Veuillez saisir un email !";
            } else {
                $email = htmlspecialchars($_POST["email"]);
            }
                //validation de l'email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION["errors"]["email"] = "le format de l'adresse email n'est pas valide !";
            }

            if(!(isset($_POST["password"]) && !empty($_POST["password"]))){
                $_SESSION["errors"]["password"] ="Veuillez saisir un mot de passe !";
            } else {
                $password = htmlspecialchars($_POST["password"]);
            }

            //check si y'a des erreurs
            if(isset($_SESSION["errors"]) && count($_SESSION["errors"]) > 0) {
                header('Location: /login', 400);
                exit;
            }

            //nettoyage de l'email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            
            //si coché = true, si pas coché = false
            $remember = !empty($_POST["remember"]); 

            try {

                $userModel = new User('users');
                $user = $userModel->findByEmail($email);
                var_dump($user);
                    
                //check si l'email n'existe pas dans la bdd on renvoie une erreur
                if(!$user){ 
                    $_SESSION["errors"]["login"] = "Identifants de connexion invalides (email)";
                    header('Location: /login', 400);
                    exit;

                //verif si les mdp correspondent
                } elseif (!password_verify($password, $user["password"])){
                    $_SESSION["errors"]["login"] = "Identifants de connexion invalides (mdp)" . $user["password"];
                    header('Location: /login', 400);
                    exit;

                //si tout est bon on rempli les info de la session et on renvoi sur le profil
                } else { 
                    $_SESSION["user"]["id"] = $user["id"];
                    $_SESSION["user"]["firstname"] = $user["firstname"];
                    $_SESSION["user"]["lastname"] = $user["lastname"];
                    $_SESSION["user"]["pseudo"] = $user["pseudo"];
                    $_SESSION["user"]["email"] = $user["email"];
                    $_SESSION["user"]["role"] = $user["id_role"];
                    if ($remember){ //on en profite pour valider le rememberme en créant le token
                        $token = bin2hex(random_bytes(32)); 
                        $userModel->updateRememberMe($token, $user["id"]);
                        setcookie("remember_me", $token, strtotime('+ 3 month'),"/", "", true, true);
                    }
                    header('Location: /profil');
                    exit;
                }
            } catch (Exception $e) {
                $_SESSION["errors"]["BDD"] = $e->getMessage();
                header('Location: /login', 500);
                exit;
            }
        }
    }

    public function reconnexionRememberMe(){

        if (!isset($_SESSION["user"]) && isset($_COOKIE["remember_me"])) {
            $token = $_COOKIE["remember_me"];
            $user= new User('users');
            $user = $user->findByToken($token);

            if ($user) {
                $_SESSION["user"] = [
                    "email" => $user["email"],
                    "firstName" => $user["firstName"],
                    "lastName" => $user["lastName"],
                    "pseudo" => $user["pseudo"],
                    "id" => $user["id"],
                    "role" => $user["id_role"]
                ];  
            } else {
                // Si le token est invalide, on supprime le cookie
                setcookie("remember_me", "", strtotime( "-1 day"), "/", "", true, true);
                unset($_COOKIE["remember_me"]); //et on enlève le cookie
            }
        }

    }

    public function register(){

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset($_SESSION['user'])){
                header('Location: /profil');
            }else{
                require_once __DIR__ . '/../views/register.php';
            }
        }
        
        elseif($_SERVER['REQUEST_METHOD'] === 'POST'){

            //recuperation des données du formulaire

            if(!(isset($_POST['firstname']) && !empty($_POST["firstname"]))){
                $_SESSION["errors"]["firstname"] ="Veuillez saisir un prénom valide !";
            } else {
                $firstname = htmlspecialchars($_POST["firstname"]);
            }

            if(!(isset($_POST['lastname']) && !empty($_POST["lastname"]))){
                $_SESSION["errors"]["lastname"] ="Veuillez saisir un nom valide !";
            } else {
                $lastname = htmlspecialchars($_POST["lastname"]);
            }

            if(!(isset($_POST['pseudo']) && !empty($_POST["pseudo"]))){
                $_SESSION["errors"]["pseudo"] ="Veuillez saisir un pseudo valide !";
            } else {
                $pseudo = htmlspecialchars($_POST["pseudo"]);
            }

            if(!(isset($_POST['email']) && !empty($_POST["email"]))){
                $_SESSION["errors"]["email"] ="Veuillez saisir un email !";
            } else {
                $email = htmlspecialchars($_POST["email"]);
            }

            //validation de l'email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION["errors"]["email"] = "le format de l'adresse email n'est pas valide !";
            }

            if(!(isset($_POST["password"]) && !empty($_POST["password"]))){
                $_SESSION["errors"]["password"] ="Veuillez saisir un mot de passe !";
            } else {
                $password = htmlspecialchars($_POST["password"]);
            }

            if(!(isset($_POST["confirm_password"]) && !empty($_POST["confirm_password"]))){
                $_SESSION["errors"]["password"] ="Veuillez confirmer le mot de passe !";
            } else {
                $confirmPassword = htmlspecialchars($_POST["confirm_password"]);
            }
            
            if($confirmPassword !== $password) {
                $_SESSION["errors"]["confirm_password"] ="Les mots de passes doivent être identiques !" . $confirmPassword . " != " . $password;
            } else {
                $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
            }

            if(isset($_SESSION["errors"]) && count($_SESSION["errors"]) > 0) {
                header('Location: /register', 400);
                exit;
            }   
            
            //nettoyage de l'email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            //insertion dans la bdd
            try{
                //check si l'utilisateur existe déjà
                $user = new User("users");
                if($user->findByEmail($email) !== false){
                    $_SESSION["errors"]["exist"] = "L'adresse email est déjà prise.";
                    header('Location: /register', 400);
                } else {
                    $user->createUser($firstname, $lastname, $pseudo, $email, $passwordHashed);
                    $_SESSION["success"]["createUser"] = "Utilisateur créé avec succès !";
                    header("location: /login"); //on renvoi vers la page login dès que l'utilisateur est créer avec un feedback
                }
            } catch(Exception $e) {
                $_SESSION["errors"]["BDD"] = $e->getMessage();
                header('Location: /register', 400);
            }
        }
    }

    public function logout(){ //pour se deconnecter et nettoyer les variables de session.
        session_unset();
        session_destroy();
        setcookie(session_name(), '', strtotime("-1 day"));
        setcookie("remember_me", "", strtotime("-1 day"), "/");
        header('Location: /'); //retour vers / qui va restart une session vide.
        exit;
    }
}
?> 