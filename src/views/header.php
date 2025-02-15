<header>
    <li>
        <a href="/">Home</a>
        <a href="/profil">Profil</a>
        <a href="/project">Project</a>
        <?php
            if(isset($_SESSION["user"])){
                echo("<a href='/logout'>Logout</a>");
            }
        ?>
    </li>
</header>