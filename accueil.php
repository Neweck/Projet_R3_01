<?php
    session_start();
    require_once 'bdd.php';

    header('Content-Type: text/html; charset=UTF-8');

    $idAjoute = 0;
    if (isset($_POST['ajouterAuPanier'])) {
        if (!isset($_SESSION['login'])) {
            header('Location: identification.html');
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

    <div id='banniere'>
        <h1>Fruit Market</h1>
        <nav>
            <form action="identification.html">
                <button class="boutton">Connexion</button>
            </form>

            <form action="logout.php">
                <button class="boutton">Déconnexion</button>
            </form>

            <form action="backOffice.php">
                <button class="boutton">Back Office</button>
            </form>

            <form action="panier.php">
                <button class="boutton">Panier</button>
            </form>
        </nav>
    </div>

    <?php
    
        if (isset($_SESSION['login'])) {
            echo "<p>Connecté en temps que : " . htmlspecialchars($_SESSION['login']) . "</p>";
        } 
        
        else {
            echo "<p>Non connecté</p>";
        }

        $produitBd = "Produit";
        $imageBd = "Image";

        // Requête de récupération des informations de chaque produit de la BDD
        $queryProduit = "SELECT * FROM $produitBd";
        $listeProduit= mysqli_query($link,$queryProduit);

        echo "<h2>Liste des produits</h2>";
        echo "<div class='grille'>";

        while ($produit = mysqli_fetch_assoc($listeProduit)) {
            
            // Récupération des informations des produits un par un
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
                echo "<img class='zoomable' src='vignette.php?img=$chemin' data-mini='vignette.php?img=$chemin' data-full='$chemin'>";
            }
            echo "</div>";

            echo "<h3>$lib</h3>";
            echo "<p>$desc</p>";
            echo "<p>$prix berries</p> <br>";

            // Bouton d'ajout au panier
            echo "<form method='post' action=''>";
            echo "<button class='boutton' type='submit' name='ajouterAuPanier' value='$id'>Ajouter au panier</button>";
            echo "</form>";

            if ($idAjoute == $id) {
                echo "<p>ajouté au panier !</p>";
            }

            echo "</div>";
        }

        echo "</div><br>";

        mysqli_close($link);
    ?>

    <div id="apercu">
        <img id="apercuImg" src="" alt="">
    </div>

    <!-- Affiche l'image en entier sur l'écrand -->
    <script>
        apercu = document.getElementById('apercu');
        apercuImg = document.getElementById('apercuImg');

        for (const elem of document.getElementsByClassName('zoomable')) {
            elem.addEventListener('click', (e) => {
                apercuImg.src = elem.dataset.full;  
                apercu.classList.add('visible');
            });
        }

        apercu.addEventListener('click', (e) => {
            apercu.classList.remove('visible')
        });
    </script>
</body>
</html>