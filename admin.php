<?php

    $identifiantForm = $_POST["ID"];
    $mdpForm = $_POST["MDP"];
    
    $bdd= "egoignan_bd"; 
    $host= "lakartxela.iutbayonne.univ-pau.fr";
    $user= "egoignan_bd"; 
    $pass= "egoignan_bd";
    $produitbd = "Produit";
    $imagebd = "Image";
    // print "Tentative de connexion sur sitebd<br><br>";
    $link=mysqli_connect($host,$user,$pass,$bdd) or die( "Impossible de se connecter à la base de données");

    $identifiantForm = $_POST["ID"];
    $mdpForm = $_POST["MDP"];


    $query = "SELECT COUNT(*) FROM Utilisateur WHERE identifiant = ? AND motDePasse = ?";
    $result = mysqli_query($link, $query);

    // $req = $bdd->prepare('SELECT nom FROM jeux_video WHERE possesseur = ?');
    // $req->execute(array($_GET['possesseur']));



    $donnees = mysqli_fetch_assoc($result);
    $ch1=$donnees["identifiant"];
    $ch2=$donnees["motDePasse"];
    $ch3=$donnees["statut"];
    print "$ch1 $ch2 $ch3<br>";

    // // On définit un login et un mot de passe de base
    // $login_valide = "moi";
    // $pwd_valide = "lemien";
    
    // // on teste si nos variables sont définies
    // if (isset($_POST['login']) && isset($_POST['pwd'])) {
    //     // on vérifie les informations saisies

    // if ($login_valide == $_POST['IDENTIFIANT'] && $pwd_valide == $_POST['MDP']) {
    //     session_start ();
    //     // on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd) (
    //     $_SESSION['login'] = $_POST['login'];
    //     $_SESSION['pwd'] = $_POST['pwd'];
    //     // on redirige notre visiteur vers une page de notre section membre
    //     header ('location: page_membre.php');
    // }
    // else {
    //     echo '<body onLoad="alert(\'Membre non reconnu...\')">';
    //     // puis on le redirige vers la page d'accueil
    //     echo '<meta http-equiv="refresh" content="0;URL=index.htm">';
    // }
    // } else {
    //     echo 'Les variables du formulaire ne sont pas déclarées.';
    // }

?>