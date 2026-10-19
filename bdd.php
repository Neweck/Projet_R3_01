<?php
    $bdd= "egoignan_bd"; 
    $host= "lakartxela.iutbayonne.univ-pau.fr";
    $user= "egoignan_bd"; 
    $pass= "egoignan_bd";

    $link = mysqli_connect($host, $user, $pass, $bdd) or die("Impossible de se connecter à la base de données");
    mysqli_set_charset($link, "utf8mb4");
?>