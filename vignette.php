<?php
    $src = $_GET["img"];
    $image = imagecreatefrompng($src);
    $largeur = imagesx($image);
    $hauteur = imagesy($image);

    $nouvelleHauteur = 200;
    $nouvelleLargeur = (int) ($largeur * $nouvelleHauteur / $hauteur);

    $dst = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur);

    imagecopyresampled($dst, $image, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $largeur, $hauteur);
    header("Content-type: image/png");
    imagepng($dst);
?>