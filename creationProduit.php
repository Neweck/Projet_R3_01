<?php
    session_start();
    if (!isset($_SESSION['login']) || $_SESSION['statut'] !== 'administrateur') {
        header('Location: identification.php');
    }

    require_once 'bdd.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office</title>

</head>
<body>
    <h2>Ajout de fruit(s) dans le stock :</h2>

    <form method="post" action="" enctype="multipart/form-data">
        Libelle : <input type="text" name="LIBELLE" size="10" maxlength="30"><br><br>
        Description : <input type="text" name="DESCRIPTION" size="50" maxlength="255"><br><br>
        Prix : <input type="number" name="PRIX" max="999999999"><br><br>
        <input type="file" name="photo[]" multiple accept="image/png"><br><br>
        <input type="submit" name="ajouterProduit" value="AJOUTER">
    </form>

    <?php

        $nbProduit = mysqli_fetch_row(mysqli_query($link, "SELECT COUNT(*) FROM Produit"))[0];
        $libelle = $_POST['LIBELLE'];


        // $query = "INSERT INTO Produit VALUES ($nbProduit+1, )";
        
    
    ?>



</body>
</html>