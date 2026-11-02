<?php
    session_start();
    require_once 'bdd.php';

    header('Content-Type: text/html; charset=UTF-8');

    // Demande de s'indentifier (si tu ne l'est pas)
    if (!isset($_SESSION['login'])) {
        header('Location: identification.html');
        exit;
    }

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Listes des erreurs de payement
    $erreurs = [];
    $paye = false;

    // Recharge la page si tu essaies de payer sans rien dans le panier
    if (count($_SESSION['panier']) == 0 && !isset($_POST['payer'])) {
        header('Location: panier.php');
        exit;
    }

    if (isset($_POST['payer'])) {
        // Récupère les informations données dans le formulaire (avec les valeurs par défaut pour que les tests fonctionnent)
        $carte = $_POST['carte'] ?? '';
        $mois  = (int) ($_POST['mois'] ?? 0);
        $annee = (int) ($_POST['annee'] ?? 0);

        // Erreur si le panier est vide
        if (count($_SESSION['panier']) == 0) {
            $erreurs[] = "Votre panier est vide.";
        }

        // Erreur si la carte n'a pas 16 chiffres ou/et que le premier et dernier chiffre ne sont pas les mêmes
        if (!preg_match('/^[0-9]{16}$/', $carte)) {
            $erreurs[] = "Le numéro de carte doit contenir exactement 16 chiffres.";
        } 
        else {
            if ($carte[15] !== $carte[0]) {
                $erreurs[] = "Le dernier chiffre doit être identique au premier.";
            }
        }

        // Erreur si la carte n'est pas valide dans plus de 3 mois
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

    <div id='banniere'>
        <h1>Fruit Market</h1>
        <nav>
            <form action="accueil.php">
                <button class="boutton">Accueil</button>
            </form>

            <form action="panier.php">
                <button class="boutton">Panier</button>
            </form>
        </nav>
    </div>

    <h2>Paiement : </h2>

    <?php
        // Affiche que le payement a bien fonctionné
        if ($paye) {
            echo "<p>Vous avez bien payé !</p>";
        } 
        else {
            // Sinon, affiche la page normalement (et les erreurs éventuelles)
            echo "<p>Total à payer : $total berries</p>";

            foreach ($erreurs as $erreur) {
                echo "<p>" .$erreur. "</p>";
            }

            echo "<form method='post' action=''>";
            echo "Numéro de carte (16 chiffres) :";
            echo "<input type='text' name='carte' maxlength='16' size='20'><br><br>";

            echo "Date de validité : ";
            echo "<input type='number' name='mois' min='1' max='12' placeholder='MM'>";
                
            echo "<input type='number' name='annee' placeholder='AAAA'><br><br>";

            echo "<input class='boutton' type='submit' name='payer' value='Payer'>";
            echo "</form>";
        }
    ?>

</body>
</html>