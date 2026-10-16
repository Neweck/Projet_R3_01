<?php
    header('Content-Type: text/html; charset=UTF-8');
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
    <t>Id :</t>
    <INPUT TYPE="NUMBER" NAME="ID" SIZE="3" MAXLENGTH="11" ><BR>

    <t>Libelle :</t>
    <INPUT TYPE="TEXT" NAME="LIBELLE" SIZE="10" MAXLENGTH="30" ><BR>

    <t>Description :</t>
    <INPUT TYPE="TEXT" NAME="DESCRIPTION" SIZE="50" MAXLENGTH="255" ><BR>

    <t>Prix :</t>
    <INPUT TYPE="NUMBER" NAME="PRIX" SIZE="10" MAXLENGTH="10" ><BR>
    <INPUT TYPE="SUBMIT" VALUE="AJOUTER">
</body>
</html>