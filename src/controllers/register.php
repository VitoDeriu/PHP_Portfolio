<?php

if(isset($_POST['name']) && !empty($_POST["name"])){
    $name = htmlspecialchars($_POST["name"]);
}

if(isset($_POST['email']) && !empty($_POST["email"])){
    $name = htmlspecialchars($_POST["email"]);
}

if(isset($_POST["password"]) && !empty($_POST["password"])) {
    $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);
}

    
?>
