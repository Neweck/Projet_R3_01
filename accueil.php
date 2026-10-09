<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Fruit Market</h1>

    <h2>Liste des produits : </h2>

    <?php
        $bdd= "egoignan_bd"; 
        $host= "lakartxela.iutbayonne.univ-pau.fr";
        $user= "egoignan_bd"; 
        $pass= "egoignan_bd";

        $produitbd = "Produit";
        $imagebd = "Image";

        print "Tentative de connexion sur sitebd<br><br>";
        $link=mysqli_connect($host,$user,$pass,$bdd) or die( "Impossible de se connecter à la base dedonnées");
    ?>
</body>
</html>