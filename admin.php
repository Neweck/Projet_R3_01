<?php
    session_start();

    $bdd= "egoignan_bd"; 
    $host= "lakartxela.iutbayonne.univ-pau.fr";
    $user= "egoignan_bd"; 
    $pass= "egoignan_bd";

    $link = mysqli_connect($host, $user, $pass, $bdd) or die("Impossible de se connecter à la base de données");
    mysqli_set_charset($link, "utf8mb4");

    if (isset($_POST['ID']) && isset($_POST['MDP'])) {
        $id  = $_POST['ID'];
        $mdp = $_POST['MDP'];

        $query = "SELECT * FROM Utilisateur WHERE identifiant = '$id' AND motDePasse = '$mdp'";
        $result = mysqli_query($link, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            session_regenerate_id(true);
            $_SESSION['login']  = $user['identifiant'];
            $_SESSION['statut'] = $user['statut']; 
            if (!isset($_SESSION['panier'])) {
                $_SESSION['panier'] = [];
            }
            header('Location: accueil.php');
        } 
        else {
            echo "invalide";
            echo "<meta http-equiv='refresh' content='0;URL=identification.php'>";
        }
    } 
    else {
        echo "Login ou MDP vides.";
    }

    mysqli_close($link);
?>