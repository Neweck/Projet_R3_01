<?php
    session_start();
    require_once 'bdd.php';

    header('Content-Type: text/html; charset=UTF-8');

    if (!isset($_SESSION['login'])) {
        header('Location: identification.php');
        exit;
    }

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    if (isset($_POST['plus'])) {
        $id = (int) $_POST['plus'];
        if (isset($_SESSION['panier'][$id])) {
            $_SESSION['panier'][$id]++;
        }
        header('Location: panier.php');
        exit;
    }

    if (isset($_POST['moins'])) {
        $id = (int) $_POST['moins'];
        if (isset($_SESSION['panier'][$id])) {
            $_SESSION['panier'][$id]--;
            if ($_SESSION['panier'][$id] <= 0) {
                unset($_SESSION['panier'][$id]);
            }
        }
        header('Location: panier.php');
        exit;
    }

    if (isset($_POST['supprimer'])) {
        $id = (int) $_POST['supprimer'];
        unset($_SESSION['panier'][$id]);
        header('Location: panier.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Panier</title>
</head>
<body>
    <h2>Mon panier : </h2>

    <?php
        echo $_SESSION['login'];
        echo "<br><br>";

        if (count($_SESSION['panier']) == 0) {
            echo "<p>Votre panier est vide.</p>";
        } 
        
        else {
            $total = 0;

            echo "<table border='1' cellpadding='8'>";
            echo "<tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Nom
                    </th>
                    <th>
                        Image
                    </th>
                    <th>
                        Prix
                    </th>
                    <th>
                        Quantité
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>";

            foreach ($_SESSION['panier'] as $id => $quantite) {
                $id = (int) $id;

                $resProduit = mysqli_query($link, "SELECT * FROM Produit WHERE idProduit = $id");
                $produit = mysqli_fetch_assoc($resProduit);

                $resImage = mysqli_query($link, "SELECT chemin FROM Image WHERE idProduit = $id LIMIT 1");
                $image = mysqli_fetch_assoc($resImage);

                $total += $produit["prix"] * $quantite;

                echo "<tr>";
                echo "<th>$id</td>";
                echo "<th>".$produit["libelle"]."</td>";
                echo "<th>";
                if ($image) {
                    echo "<img src='vignette.php?img=".$image["chemin"]."'>";
                }
                echo "</th>";
                echo "<th>".$produit["prix"]."berries</td>";
                echo "<th>$quantite</td>";
                echo "<th>";
                echo "<form method='post' action=''>";
                echo "<button type='submit' name='plus' value='$id'>+1</button> ";
                echo "<button type='submit' name='moins' value='$id'>-1</button> ";
                echo "<button type='submit' name='supprimer' value='$id'>Retirer</button>";
                echo "</form>";
                echo "</th>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<p>Total : $total berries</p>";

        }
    ?>

    <br><br>
    <a href="paiement.php">
        <button>Valider mon panier</button>
    </a>
    <br>
    <a href="accueil.php">
        <button>Retour aux produits</button>
    </a>

</body>
</html>
