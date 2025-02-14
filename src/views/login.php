<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include("header.php");
        var_dump($_SESSION);

        //affichage de la création du user si celui-ci réussis
        if (!empty($_SESSION['success'])) {
            foreach ($_SESSION['success'] as $s) {
                echo ("<p style='color: green;'>$s</p>");
            }
            unset($_SESSION['success']); // Supprime après affichage
        }
        
        //affichage des erreurs
        if (!empty($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo ("<p style='color: red;'>$error</p>");
            }
            unset($_SESSION['errors']); // Supprime les erreurs après affichage
        }
    ?>



    <h1>Login</h1>
    <form action="/login" method="POST">

        <label for="email">email</label>
        <input type="text" name="email">

        <label for="password">password</label>
        <input type="password" name="password">

        <label for="remember">se souvenir de moi</label>
        <input type="checkbox" name="remember" checked>

        <button type="submit">Se connecter</button>
    </form>
    <p>Pas de compte ?</p>
    <a href="/register">créer un compte</a>
</body>
</html>