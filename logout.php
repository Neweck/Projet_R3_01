<?php

    session_start();
    require_once 'bdd.php';

    // Déconnexion de la session
    $_SESSION = [];
    session_destroy();

    // Fermeture de la base de données
    mysqli_close($link);
    
    // Redirection vers l'accueil
    header('Location: accueil.php');
?>