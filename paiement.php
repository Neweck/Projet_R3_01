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

    $erreurs = [];
    $paye = false;

    if (count($_SESSION['panier']) == 0 && !isset($_POST['payer'])) {
        header('Location: panier.php');
        exit;
    }

    if (isset($_POST['payer'])) {
        $carte = $_POST['carte'] ?? '';
        $mois  = (int) ($_POST['mois'] ?? 0);
        $annee = (int) ($_POST['annee'] ?? 0);

        if (count($_SESSION['panier']) == 0) {
            $erreurs[] = "Votre panier est vide.";
        }

        if (!preg_match('/^[0-9]{16}$/', $carte)) {
            $erreurs[] = "Le numéro de carte doit contenir exactement 16 chiffres.";
        } else {
            if ($carte[15] !== $carte[0]) {
                $erreurs[] = "Le dernier chiffre doit être identique au premier.";
            }
        }

        $expiration = mktime(0, 0, 0, $mois + 1, 0, $annee);
        $limite = strtotime('+3 months');
        if ($expiration <= $limite) {
            $erreurs[] = "La carte doit être valide plus de 3 mois.";
        }

        if (count($erreurs) == 0) {
            $_SESSION['panier'] = [];
            $paye = true;
        }
    }

    $total = 0;
    foreach ($_SESSION['panier'] as $id => $quantite) {
        $id = (int) $id;
        $res = mysqli_query($link, "SELECT prix FROM Produit WHERE idProduit = $id");
        $produit = mysqli_fetch_assoc($res);
        if ($produit) {
            $total += $produit["prix"] * $quantite;
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Paiement</title>
</head>
<body>

    <h2>Paiement : </h2>

    <?php
        echo $_SESSION['login'];
        echo "<br><br>";

        if ($paye) {
            echo "<p>Vous avez bien payé !</p>";
        } else {
            echo "<p>Total à payer : $total berries</p>";

            foreach ($erreurs as $erreur) {
                echo "<p>" .$erreur. "</p>";
            }
    ?>

    <form method="post" action="">
        Numéro de carte (16 chiffres) :<br>
        <input type="text" name="carte" maxlength="16" size="20"><br><br>

        Date de validité :<br>
        <input type="number" name="mois" min="1" max="12" placeholder="MM">
        
        <input type="number" name="annee" placeholder="AAAA"><br><br>

        <input type="submit" name="payer" value="Payer">
    </form>

    <?php } ?>

    <br>
    <?php 
        echo "<a href='panier.php'> <button>Retour au panier</button> </a>";
        echo "<a href='accueil.php'> <button>Retour aux produits</button> </a>";
    ?>

</body>
</html>
