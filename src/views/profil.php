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
    <h1>Profil Page</h1>
    <?php
        if (!empty($_SESSION['user'])) {
            foreach ($_SESSION['user'] as $info) {
                echo ("<p>$info</p>");
            }
        }
    ?>
</body>
</html>