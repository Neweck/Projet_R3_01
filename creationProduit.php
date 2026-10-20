<?php
    session_start();
    if (!isset($_SESSION['login']) || $_SESSION['statut'] !== 'administrateur') {
        header('Location: identification.php');
    }

    require_once 'bdd.php';

    if (isset($_POST['ajouterProduit'])) {
        $libelle = $_POST['LIBELLE'];
        $description = $_POST['DESCRIPTION'];
        $prix = $_POST['PRIX'];

        // echo "Libellé : " . htmlspecialchars($libelle) . "<br>";
        // echo "Description : " . htmlspecialchars($description) . "<br>";
        // echo "Prix : " . htmlspecialchars($prix) . "<br>";

        $requete = mysqli_prepare($link, "INSERT INTO Produit (LIBELLE, DESCRIPTION, PRIX) VALUES (?, ?, ?)");

        // Parametres de la requete preparee 
        mysqli_stmt_bind_param($requete, 'ssd', $libelle, $description, $prix);     // 'ssd' -> "string" , "string" , "decimal";

        mysqli_stmt_execute($requete);
        mysqli_stmt_close($requete);
    }

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
</body>
</html>