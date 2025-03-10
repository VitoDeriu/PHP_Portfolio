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


    <h1>Projects</h1>

    <?php if (empty($projects)): ?>
        <p>Aucun projet trouvé.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($projects as $project): ?>
                <li>
                    <!-- TODO : Rediriger sur les pages de projet -->
                    <h2><?= htmlspecialchars($project['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                    <img src="/<?= htmlspecialchars($project['image']) ?>" alt="Image du projet" width="200">
                    <a href="<?= htmlspecialchars($project['link']) ?>"><?= htmlspecialchars($project['link']) ?></a>
                    <p>Created By <?= htmlspecialchars($project['pseudo']) ?></p>
                </li>

                <!-- TODO : A mettre seulement dans my project pour que le user voit seulement ses projets pour delete et aussi dans la vue admin -->
                <?php if ($_SESSION['user']['id'] === $project['id_user'] || $_SESSION['user']['role'] === 1) : ?>
                    <form action="/project/delete" method="POST">
                        <input type="hidden" name="id" value="<?= $project['id'] ?>">
                        <input type="hidden" name="user_id" value="<? $project['id_user'] ?>">
                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce projet ?')">Supprimax</button>
                    </form>
                <?php endif; ?> 
                <!-- fin todo -->

            <?php endforeach; ?>
        </ul>
    <?php endif; ?> 

    <p>Pas de Projet ? </p>
    <a href="/project/create">Créer un projet</a>
    
</body>
</html>