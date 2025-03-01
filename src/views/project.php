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


    <h1>Projects</h1>

    <?php if (empty($projects)): ?>
        <p>Aucun projet trouvé.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($projects as $project): ?>
                <li>
                    <h2><?= htmlspecialchars($project['title']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                    <?php if (!empty($project['image'])): ?>
                        <img src="/<?= htmlspecialchars($project['image']) ?>" alt="Image du projet" width="200">
                    <?php endif; ?>

                    <a href="<?= htmlspecialchars($project['link']) ?>"><?= htmlspecialchars($project['link']) ?></a>

                    <p>Created By <?= htmlspecialchars($project['pseudo']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>





    <?php
        //TODO: lister tous les projets et les rediriger avec des query

        
    ?>
    <p>Pas de Projet ? </p>
    <a href="/project/create">Créer un projet</a>
    
</body>
</html>