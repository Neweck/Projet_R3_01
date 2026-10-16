<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>FRUIT MARKET</title>
</head>
<body>
    
    <?php

        $bdd= "egoignan_bd"; 
        $host= "lakartxela.iutbayonne.univ-pau.fr";
        $user= "egoignan_bd"; 
        $pass= "egoignan_bd";

        $produitBd = "Produit";
        $imageBd = "Image";

        $link=mysqli_connect($host,$user,$pass,$bdd) or die( "Impossible de se connecter à la base de données");
        mysqli_set_charset($link, "utf8mb4");

        $queryProduit = "SELECT * FROM $produitBd";
        $listeProduit= mysqli_query($link,$queryProduit);
       
        echo "<ul>";

        while ($produit=mysqli_fetch_assoc($listeProduit)) {
            $id=$produit["idProduit"];
            $lib=$produit["libelle"];
            $desc=$produit["description"];  
            $prix=$produit["prix"];  

            $queryImage = "SELECT * FROM $imageBd WHERE idProduit = $id";
            $listeImage= mysqli_query($link,$queryImage);

            echo "<li>";

            while ($image=mysqli_fetch_assoc($listeImage)) {
                $chemin=$image["chemin"];
                echo "<img src=vignette.php?img=$chemin>";
            }
            
            echo "<h3>$lib</h3>";
            echo "$desc <br>";
            echo "$prix berries <br>";
            echo "<input type='submit' id='ajoutpanier' value='Ajouter au panier'>";

            echo "</li>";
            echo "<br><br><br><br>";
        }

        echo "</ul>";

        mysqli_close($link); 
    ?>

    <h1>Fruit Market</h1>

    <h2>Liste des produits : </h2>


    <a href="identification.php">
        <button>Connexion</button>
    </a>

</body>
</html>