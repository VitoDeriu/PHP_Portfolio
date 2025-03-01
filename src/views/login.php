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