<?php
    session_start();
    require_once 'bdd.php';

    header('Content-Type: text/html; charset=UTF-8');

    $idAjoute = 0;
    if (isset($_POST['ajouterAuPanier'])) {
        if (!isset($_SESSION['login'])) {
            header('Location: identification.php');
            exit;
        }
        $id = (int) $_POST['ajouterAuPanier'];
        $_SESSION['panier'][$id] = ($_SESSION['panier'][$id] ?? 0) + 1;
        $idAjoute = $id;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>FRUIT MARKET</title>
</head>
<body>

    <h1>Fruit Market</h1>
    <h2>Liste des produits : </h2>

    <?php
        if (isset($_SESSION['login'])) {
            echo htmlspecialchars($_SESSION['login']);
        } else {
            echo "<p>Non connecté</p>";
        }

        $produitBd = "Produit";
        $imageBd = "Image";

        $queryProduit = "SELECT * FROM $produitBd";
        $listeProduit= mysqli_query($link,$queryProduit);

        echo "<div class='grille'>";

        while ($produit = mysqli_fetch_assoc($listeProduit)) {
            $id   = $produit["idProduit"];
            $lib  = $produit["libelle"];
            $desc = $produit["description"];
            $prix = $produit["prix"];

            $queryImage = "SELECT * FROM $imageBd WHERE idProduit = $id";
            $listeImage = mysqli_query($link, $queryImage);

            echo "<div class='produit'>";

            echo "<div class='images'>";
            while ($image = mysqli_fetch_assoc($listeImage)) {
                $chemin = $image["chemin"];
                echo "<img src='vignette.php?img=$chemin'>";
            }
            echo "</div>";

            echo "<h3>$lib</h3>";
            echo "$desc <br>";
            echo "$prix berries <br>";

            echo "<form method='post' action=''>";
            echo "<button type='submit' name='ajouterAuPanier' value='$id'>Ajouter au panier</button>";
            echo "</form>";

            if ($idAjoute == $id) {
                echo "<p>ajouté au panier !</p>";
            }

            echo "</div>";
        }

        echo "</div>";
    ?>

    <a href="identification.php">
        <button>Connexion</button>
    </a>

    <a href="logout.php">
        <button>Déconnexion</button>
    </a>

    <a href="creationProduit.php">
        <button>Back-Office</button>
    </a>

</body>
</html>