<?php
    $src = $_GET["img"];
    $largeur = imagesx($src);
    $hauteur = imagesy($src);

    $nouvelleLargeur = 200;
    $nouvelleHauteur = (int) ($hauteur * $nouvelleLargeur / $largeur); 

    $dst = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur);

    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $largeur, $hauteur);

    imagepng($dst);
?>