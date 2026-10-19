<?php
    session_start();
    require_once 'bdd.php';
    $_SESSION = [];
    session_destroy();

    mysqli_close($link);
    
    header('Location: accueil.php');
?>