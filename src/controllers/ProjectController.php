<?php

namespace App\Controllers;

use Exception;
use App\Models\Project;

//class relative aux projets, CRUD des projet et redirection des query.

class ProjectController{

    // Affichage des tous les projets sans fonctionnalités de suppression ou modif
    public function project(){
        if(isset($_SESSION["user"])){ 
            try {
                $project = new Project("projects");
                $projects = $project->find();
                require_once __DIR__ . '/../views/project.php';
             } catch (Exception $e) {
                $_SESSION["errors"]["BDD"] = $e->getMessage();
                header('Location: /', 500);
                exit;
            } 
         }else{
            header('Location: /login');
            exit;
        }
    }

    //Affichage du form des projets et gestion de l'envoi
    public function createProject(){

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset($_SESSION['user'])){
                require_once __DIR__ . '/../views/projectForm.php';
            }else{
                header('location: /login');
            }
        }

        elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])){
            $_SESSION["errors"] = []; //clean des erreurs de session
            
            //Check title
            if(!isset($_POST["title"]) && empty($_POST["title"])){
                $_SESSION["errors"]["title"] ="Veuillez saisir un titre !";
             } else {
                $title = htmlspecialchars($_POST["title"]);
            }

            //Check description
            if(!isset($_POST["description"]) && empty($_POST["description"])){
                $_SESSION["errors"]["description"] ="Veuillez saisir une description !";
             } else {
                $description = htmlspecialchars($_POST["description"]);
            }
            
            //Check link - voir pour le lien pour ne rien mettre si c'est vide 
            if(!isset($_POST["link"]) && empty($_POST["link"])){
                $_SESSION["errors"]["link"] ="Veuillez saisir un lien vers le projet ou son github.";
             } else {
                $link = htmlspecialchars($_POST["link"]);
            }

            //Check image
            if(!isset($_FILES["image"]) && empty($_FILES["image"] && !($_FILES['image']['error'] === UPLOAD_ERR_OK))){
                $_SESSION["errors"]["image"] ="Veuillez choisir une image pour illustrer votre projet.";
             } else {

                // Restriction d'image
                 $allowedExtensions = ['jpg', 'jpeg', 'png'];
                 $allowedMimeTypes = ['image/jpeg', 'image/png'];
                $maxFileSize = 2 * 1024 * 1024; // 2 Mo
                
                //Récupération des donée de l'image pour l'enregistrement
                 $uploadDir = __DIR__ . '/../../public/images/';     //chemin vers le dossier d'upload des images
                 $tempPath = $_FILES["image"]["tmp_name"];           //recup du chemin temporaire
                 $originalName = $_FILES["image"]["name"];           //recup du nom de l'image
                 $fileParts = explode(".", $originalName);           //split du nom en 2
                 $extension = $fileParts[count($fileParts) - 1];     //recup l'extension du fichier
                 $fileName = $fileParts[0];                          //recup seulement le nom du fichier
                 $imgName = $fileName . "-" . date("Y-m-d-H-i-s") . "." . $extension; //création d'un nom unique pour l'image
 
                $destPath = $uploadDir . $imgName;                  //creation du chemin final pour l'image

                //Check du format d'image
                if (!in_array($extension, $allowedExtensions)) {
                    $_SESSION["errors"]["image"] ="Format de fichier non prit en charge !";
                    header('Location: /project/create', 400);
                    exit;
                }

                //Check du MIME type
                 $finfo = finfo_open(FILEINFO_MIME_TYPE);
                 $mimeType = finfo_file($finfo, $tempPath);
                 finfo_close($finfo);
                        
                if (!in_array($mimeType, $allowedMimeTypes)) {
                    $_SESSION["errors"]["image"] ="Type de fichier interdit !";
                    header('Location: /project/create', 400);
                    exit;
                }
            
                //Check de la taille de l'image
                if ($fileSize > $maxFileSize) {
                    $_SESSION["errors"]["image"] ="Le fichier est trop volumineux !";
                    header('Location: /project/create', 400);
                    exit;
                }

                //deplacement du fichier dans le dossier serveur
                if(move_uploaded_file($tempPath, $destPath)) {       
                    $imgPath = 'images/' . $imgName;                //chemin a stocker dans la bdd
                 } else {
                    $_SESSION["errors"]["image"] = "Erreur lors du délacement de l'image !";
                }
            }

            //Recup de l'id user
            $idUser = $_SESSION['user']['id'];

            //Redirect si erreur !
            if(isset($_SESSION["errors"]) && count($_SESSION["errors"]) > 0) {
                header('Location: /project/create', 400);
                exit;
            } 

            //Appel du model 
            try {
                $project = new Project("projects");
                $project->createProject($title, $description, $imgPath, $link, $idUser);
                $_SESSION["success"]["createProject"] = "Projet créé avec succès !";
                header('location: /project');
             } catch (Exception $e) {
                $_SESSION["errors"]["BDD"] = $e->getMessage();
                header('Location: /project/create', 500);
                exit;
            }
        }
    }


    // TODO : Suppression d'un projet, seulement accessible depuis le dashboard admin et la vue depuis le compte admin et depuis mesprojets pour les users.
    public function deleteProject(){
        // !! Attention !! a verifier ce qui suit c'est chatgpt !
        // TODO : faire la gestion d'erreur

        //check la conexion 
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        //check si l'id récupérer du delete est set et est un nombre
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            echo "ID invalide";
            exit;
        }


        $projectId = (int)$_POST['id'];             //transforme en int ? 
        $projectModel = new Project();              //appel du model maintenant ?
        $project = $projectModel->find(['id' => $projectId]); //check si le projet existe
    
        //erreur si le projet n'existe pas 
        if (!$project) {
            echo "Projet introuvable";
            exit;
        }
    
        // Vérifier si l'utilisateur est bien l'auteur ou admin
        if ($project[0]['user_id'] !== $_SESSION['user']['id'] && $_SESSION['user']['role'] !== 'admin') {
            echo "Vous n'avez pas les droits pour supprimer ce projet";
            exit;
        }
    
        // Supprimer l'image si elle existe
        if (!empty($project[0]['image'])) {
            $imagePath = __DIR__ . '/../public/upload/' . $project[0]['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath); //explication du unlink ? 
            }
        }
    
        // Supprimer le projet
        $projectModel->delete($projectId);
        header('Location: /');
        exit;









    }
















/*

    il faut une gestions dans les redirects. 
        dans la page tous les projets on les vois tous
        dans mes projets depuis le profil on peut voir que ses projets et les supprimer, modifier

        les admins on une page dashboard ou ils peuvent voir tous les projets et les supprimer 
        ils peuvent chercher les projets avec leur noms et le créateur des projets




    TODO : Modification des projets (affichage du form de modif et gestion de son envoi) accessible depuis la page profil/mesprojets seulement


    TODO : affichage d'un seul projet en détail avec toute la description, bouton modifier pour les users et supprimer pour admins et users

*/


}