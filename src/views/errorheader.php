<?php
//affichage des erreurs
    if (!empty($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo ("<p style='color: red;'>$error</p>");
        }
        unset($_SESSION['errors']); // Supprime les erreurs après affichage
    }

//affichage des créations si réussis
    if (!empty($_SESSION['success'])) {
        foreach ($_SESSION['success'] as $s) {
            echo ("<p style='color: green;'>$s</p>");
        }
        unset($_SESSION['success']); // Supprime après affichage
    }
?>