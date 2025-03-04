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

    <h1>Mes Projets</h1>

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
                    <p>Project id_user : <?= htmlspecialchars($project['id_user']) ?></p>
                </li>

                <?php if ($_SESSION['user']['id'] === $project['id_user'] || $_SESSION['user']['id_role'] === 1) : ?>
                    <form action="/project/delete" method="POST">
                        <input type="hidden" name="id" value="<?= $project['id'] ?>">
                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce projet ?')">Supprimax</button>
                    </form>
                <?php endif; ?>

            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>