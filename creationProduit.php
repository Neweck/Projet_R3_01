<?php
    session_start();
    if (!isset($_SESSION['login']) || $_SESSION['statut'] !== 'administrateur') {
        header('Location: identification.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <h2>Ajout de fruit dans le stock :</h2>
</head>
<body>
    <t>Libelle :</t>
    <input type="text" name="LIBELLE" size="10" maxlength="30" ><br><br>

    <t>Description :</t>
    <input type="text" name="DESCRIPTION" size="50" maxlength="255" ><br><br>

    <t>Prix :</t>
    <input type="number" name="PRIX" size="10" max="999999999" ><br><br>

    <input type="file" name="photo[]" multiple accept="image/png"><br><br><br>
    
    <input type="submit" value="AJOUTER">
</body>
</html>