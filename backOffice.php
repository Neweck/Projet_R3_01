<?php
    session_start();
    if (!isset($_SESSION['login']) || $_SESSION['statut'] !== 'administrateur') {
        header('Location: identification.html');
    }

    require_once 'bdd.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Back Office</title>
</head>
<body>

    <div id='banniere'>
        <h1>Fruit Market</h1>
        <nav>
            <form action="accueil.php">
                <button class="boutton">Accueil</button>
            </form>
            
            <form action="logout.php">
                <button class="boutton">Déconnexion</button>
            </form>
        </nav>
    </div>

    <h2>Liste des produits</h2>

        <?php
            $produitBd = "Produit";
            $imageBd = "Image";

            $queryProduit = "SELECT * FROM $produitBd";
            $listeProduit= mysqli_query($link,$queryProduit);

            echo "<div class='catalogue'>";

            while ($produit = mysqli_fetch_assoc($listeProduit)) {
                $id   = $produit["idProduit"];
                $lib  = $produit["libelle"];
                $desc = $produit["description"];
                $prix = $produit["prix"];

                $requeteImage = "SELECT * FROM $imageBd WHERE idProduit = $id LIMIT 1";
                $listeImage = mysqli_query($link, $requeteImage);

                echo "<div class='produit'>";

                echo "<div class='images'>";
                while ($image = mysqli_fetch_assoc($listeImage)) {
                    $cheminBD = $image["chemin"];
                    echo "<img src='vignette.php?img=$cheminBD'>";
                }
                echo "</div>";

                echo "<h2>$id</h2>";
                echo "<h3>$lib</h3>";
                echo "$desc<br><br>";
                echo "$prix berries";

                echo "</div>";

            }

            echo "</div>";

            mysqli_close($link);
        ?>
    

    <div class="admin">
        <div>
            <h2>Ajout d'un fruit dans le stock</h2>
            <form method="post" action="creationProduit.php" enctype="multipart/form-data">
                Libelle : <input type="text" name="LIBELLE_AJOUT" size="20" maxlength="30"><br><br>
                Description courte : <input type="text" name="DESCRIPTION" size="40" maxlength="255"><br><br>
                Prix : <input type="number" name="PRIX" max="999999999"><br><br>
                Sélectionner l'image du fruit : <input type="file" name="img1" accept="image/png" require><br><br>
                Sélectionner l'illustration du pouvoir : <input type="file" name="img2" accept="image/png" require><br><br>
                <input class="boutton" type="submit" name="ajouterProduit" value="AJOUTER">
            </form>
        </div>
        
        <div>
            <h2>Suppression de fruit(s) dans le stock</h2>
            <form method="post" action="suppressionProduit.php">
                Numéro du produit : <input type="text" name="ID_SUPPR" size="10" maxlength="30"><br><br>
                <input class="boutton" type="submit" name="supprimerProduit" value="SUPPRIMER">
            </form>
        </div>
    </div>

</body>
</html>