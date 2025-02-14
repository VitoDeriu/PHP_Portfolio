<header>
    <li>
        <ul><a href="/">Home</a></ul>
        <ul><a href="/profil">Profil</a></ul>
        <ul><a href="/project">Project</a></ul>
        <ul><?php
            if(isset($_SESSION["user"])){
                echo("<a href='/logout'>Logout</a>");
            }
        ?></ul>
    </li>
</header>