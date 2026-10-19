<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>
    <h3>S'identifier</h3>
    <p>Veuillez vous identifier avant de pouvoir accéder au panier</p>
    
    <FORM ENCTYPE="multipart/form-data" METHOD="POST" ACTION="admin.php">
        <t>Identifiant : </t><br>
        <INPUT TYPE="TEXT" NAME="ID"><BR><BR>
        <t>Mot de passe : </t><br>
        <INPUT TYPE="PASSWORD" NAME="MDP"><BR><BR>
        <INPUT TYPE="SUBMIT" VALUE="Valider">
    </FORM>

</body>
</html>