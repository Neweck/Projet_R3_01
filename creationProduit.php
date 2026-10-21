<?php
    session_start();
    if (!isset($_SESSION['login']) || $_SESSION['statut'] !== 'administrateur') {
        header('Location: identification.php');
    }

    require_once 'bdd.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office</title>

</head>
<body>

        <?php
            $produitBd = "Produit";
            $imageBd = "Image";

            $queryProduit = "SELECT * FROM $produitBd";
            $listeProduit= mysqli_query($link,$queryProduit);

            while ($produit = mysqli_fetch_assoc($listeProduit)) {
                $id   = $produit["idProduit"];
                $lib  = $produit["libelle"];
                $desc = $produit["description"];
                $prix = $produit["prix"];

                $queryImage = "SELECT * FROM $imageBd WHERE idProduit = $id LIMIT 1";
                $listeImage = mysqli_query($link, $queryImage);

                echo "<div class='produit'>";

                echo "<div class='images'>";
                while ($image = mysqli_fetch_assoc($listeImage)) {
                    $chemin = $image["chemin"];
                    echo "<img src='vignette.php?img=$chemin'>";
                }
                echo "</div>";

                echo "<h2>$id</h2>";
                echo "<h3>$lib</h3>";
                echo "$desc <br><br>";
                echo "<b>$prix</b> berries <br>";

                echo "</div>";
            }

        ?>
    
    <div>
        <h2>Ajout d'un fruit dans le stock :</h2>
        <form method="post" action="" enctype="multipart/form-data">
            Libelle : <input type="text" name="LIBELLE_AJOUT" size="10" maxlength="30"><br><br>
            Description : <input type="text" name="DESCRIPTION" size="50" maxlength="255"><br><br>
            Prix : <input type="number" name="PRIX" max="999999999"><br><br>
            <input type="file" name="photo[]" multiple accept="image/png"><br><br>
            <input type="submit" name="ajouterProduit" value="AJOUTER">
        </form>
    </div>

    <div>
        <h2>Suppression de fruit(s) dans le stock :</h2>
        <form method="post" action="" enctype="multipart/form-data">
            Libelle : <input type="text" name="LIBELLE_SUPPR" size="10" maxlength="30"><br><br>
            <input type="submit" name="supprimerProduit" value="SUPPRIMER">
        </form>
    </div>

    <?php 
        if (isset($_POST['ajouterProduit'])) {
            $libelle = $_POST['LIBELLE_AJOUT'];
            $description = $_POST['DESCRIPTION'];
            $prix = $_POST['PRIX'];

            // echo "Libellé : " . htmlspecialchars($libelle) . "<br>";
            // echo "Description : " . htmlspecialchars($description) . "<br>";
            // echo "Prix : " . htmlspecialchars($prix) . "<br>";

            $requete = mysqli_prepare($link, "INSERT INTO Produit (LIBELLE, DESCRIPTION, PRIX) VALUES (?, ?, ?)");

            // Parametres de la requete preparee 
            mysqli_stmt_bind_param($requete, 'ssd', $libelle, $description, $prix);     // 'ssd' -> "string" , "string" , "decimal";

            if (mysqli_stmt_execute($requete)) {
                echo "<p style='color:green;'>Le produit a bien été ajouté.</p><br><br>";
            } 
            
            else {
                echo "<p style='color:red;'>Erreur lors de l'ajout du produit !</p><br><br>";
            }
            
            mysqli_stmt_close($requete);
        }

    ?>
</body>
</html>