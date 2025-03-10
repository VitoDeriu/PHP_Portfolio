<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php"); ?>
    <title>Document</title>
</head>
<body>
    <?php
        include("header.php");
    ?>
    <h1>HOME</h1>
    <?php
        if(isset($_SESSION["user"])){
            if($_SESSION["user"]["role"] == 'admin'){
                echo("
                    <a href='/Dashboard'>Dashboard</a>
                ");
            }
            echo("
                <li>
                    <a href='/profil'>Profil</a>
                    <a href='/logout'>Logout</a>
                    <a href='/project'>Project</a>
                </li>
            ");
        } else {
            echo("
                <li>
                    <a href='/register'>S'inscrire</a>
                    <a href='/login'>Se Connecter</a>
                </li>
            ");
        }
    ?>



</body>
</html>