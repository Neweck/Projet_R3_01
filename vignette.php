<?php
    // On récupère l'image et sa taille initiale
    $src = $_GET["img"];
    $image = imagecreatefrompng($src);
    $largeur = imagesx($image);
    $hauteur = imagesy($image);

    // On prend une plus petite taille pour la vignette (la largeur dépend de la photo pour ne pas la déformer)
    $nouvelleHauteur = 200;
    $nouvelleLargeur = (int) ($largeur * $nouvelleHauteur / $hauteur);

    $dst = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur);

    // On crée la vignette
    imagecopyresampled($dst, $image, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $largeur, $hauteur);
    imagepng($dst);
?>