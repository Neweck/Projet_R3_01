<?php
    session_start();
    require_once 'bdd.php';

    if (isset($_POST['ID']) && isset($_POST['MDP'])) {

        // Récupération de l'identifiant et du mot de passe inscrit dans le formulaire
        $id  = $_POST['ID'];
        $mdp = $_POST['MDP'];

        // Requête de récupération de l'identifiant/mot de passe de la BDD
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
            echo "<meta http-equiv='refresh' content='0;URL=identification.html'>";
        }
    } 
    else {
        echo "Login ou MDP vides.";
    }

    mysqli_close($link);

?>