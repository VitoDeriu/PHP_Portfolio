<header>
    <li>
        <a href="/">Home</a>

        <a href="/project">Project</a>
        <?php
            if(isset($_SESSION["user"])){
                if($_SESSION["user"]["role"] == 'admin'){
                    echo("
                        <a href='/Dashboard'>Dashboard</a>
                    ");
                }
                echo("
                    <a href='/profil'>Profil</a>
                    <a href='/logout'>Logout</a>
                ");
            } else {
                echo("
                    <a href='/register'>S'inscrire</a>
                    <a href='/login'>Se Connecter</a>
                ");
            }
        ?>
    </li>
</header>
<?php
    include_once("errorheader.php")
?>