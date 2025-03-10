<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php"); ?>
    <title>Portfolio</title>
</head>
<body>
    <?php
        include("header.php");
    ?>
    <h1>Register</h1>
    <form action="/register" method="POST">

        <label for="firstname">firstname</label>
        <input type="text" name="firstname">
        
        <label for="lastname">lastname</label>
        <input type="text" name="lastname">

        <label for="pseudo">pseudo</label>
        <input type="text" name="pseudo">

        <label for="email">email</label>
        <input type="text" name="email">
        
        <label for="password">password</label>
        <input type="password" name="password">
        
        <label for="confirm_password">confirm password</label>
        <input type="password" name="confirm_password">
        
        <button type="submit">S'enregistrer</button>
    </form>
    <p>Déjà un compte ?</p>
    <a href="/login">Se connecter</a>
</body>
</html>