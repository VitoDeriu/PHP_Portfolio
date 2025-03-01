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
    
    <h1>Project Form</h1>

    <form action="/project/create" method="POST" enctype="multipart/form-data">

        <label for="title">Titre du projet</label>
        <input type="text" name="title" required>
    
        <label for="description">Description :</label>
        <input type="textarea" name="description" required>
    
        <label for="link">lien externe</label>
        <input type="text" name="link" required>
    
        <label for="image">Image du projet</label>
        <input type="file" name="image" accept=".jpg, .jpeg, .png" required>
    
        <button type="submit">Créer le projet</button>
    </form>
</body>
</html>