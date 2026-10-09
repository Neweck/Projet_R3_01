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

        $produitBd = "Produit";
        $imageBd = "Image";

        $link=mysqli_connect($host,$user,$pass,$bdd) or die( "Impossible de se connecter à la base dedonnées");

        $queryProduit = "SELECT * FROM $produitBd";
        $listeProduit= mysqli_query($link,$queryProduit);
       
        while ($produit=mysqli_fetch_assoc($listeProduit)) {
            $id=$produit["idProduit"];
            $lib=$produit["libelle"];
            $desc=$produit["description"];  
            $prix=$produit["prix"];  

            $queryImage = "SELECT * FROM $imageBd WHERE idProduit = $id";
            $listeImage= mysqli_query($link,$queryImage);

            while ($image=mysqli_fetch_assoc($listeImage)) {
                $chemin=$image["chemin"];
                echo '<img scr='.'/'.'$chemin>';
            }
            
            print "$lib <br>";
            print "$desc <br><br>";
        }

        mysqli_close($link); 
    ?>
</body>
</html>
