<?php
    session_start();
    if (!isset($_SESSION['login']) || $_SESSION['statut'] !== 'administrateur') {
        header('Location: identification.php');
    }

    require_once 'bdd.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Back Office</title>

</head>
<body>

        <?php
            $produitBd = "Produit";
            $imageBd = "Image";

            $queryProduit = "SELECT * FROM $produitBd";
            $listeProduit= mysqli_query($link,$queryProduit);

            echo "<div class='catalogue'>";

            while ($produit = mysqli_fetch_assoc($listeProduit)) {
                $id   = $produit["idProduit"];
                $lib  = $produit["libelle"];
                $desc = $produit["description"];
                $prix = $produit["prix"];

                $queryImage = "SELECT * FROM $imageBd WHERE idProduit = $id LIMIT 1";
                $listeImage = mysqli_query($link, $queryImage);

                echo "<div class='produit'>";

                echo "<div class='images'>";
                while ($image = mysqli_fetch_assoc($listeImage)) {
                    $cheminBD = $image["chemin"];
                    echo "<img src='vignette.php?img=$cheminBD'>";
                }
                echo "</div>";

                echo "<h2>$id</h2>";
                echo "<h3>$lib</h3>";
                echo "$desc <br><br>";
                echo "<b>$prix</b> berries <br>";

                echo "</div>";

            }

            echo "</div>";


            if (isset($_POST['ajouterProduit'])) {
                $libelle = $_POST['LIBELLE_AJOUT'];
                $description = $_POST['DESCRIPTION'];
                $prix = $_POST['PRIX'];

                $requeteInsert = mysqli_prepare($link, "INSERT INTO $produitBd (LIBELLE, DESCRIPTION, PRIX) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($requeteInsert, 'ssd', $libelle, $description, $prix);     // 'ssd' -> "string" , "string" , "decimal";
                
                $reqImage = mysqli_prepare($link, "INSERT INTO $imageBd (chemin, idProduit) VALUES (?, ?)");
                mysqli_stmt_bind_param($reqImage, 'si', $chemin, $idProduit);   // 'ss' -> string , integer

                if (!empty($_FILES['photo']['name'][0])) {
                    if (mysqli_stmt_execute($requeteInsert)) {
                        $idProduit = mysqli_insert_id($link);

                        foreach ($_FILES['photo']['tmp_name'] as $i => $tmp) {
                            $fic = $_FILES['photo']['name'][$i];
                            $chemin = 'images/' . $fic;

                            if (move_uploaded_file($tmp, $chemin)) {
                                mysqli_stmt_execute($reqImage);
                            }
                        }
                        echo "<p>Le produit a bien été ajouté.</p><br><br>";
                    }

                    else echo "<p>Erreur lors de l'ajout du produit !</p><br><br>";

                }

                else echo "<p>Aucune(s) image(s) sélectionnée(s) !</p><br><br>";
                mysqli_stmt_close($requeteInsert);
                mysqli_stmt_close($reqImage);
            }


            if (isset($_POST['supprimerProduit'])) {
                $id = (int) $_POST['ID_SUPPR'];

                $requete = mysqli_prepare($link, "DELETE FROM Produit WHERE idProduit = ?");

                mysqli_stmt_bind_param($requete, 'i', $id);     // 'i' -> "integer"

                if (mysqli_stmt_execute($requete)) {
                    if (mysqli_stmt_affected_rows($requete) > 0) {
                        echo "<p id='formSupprProduit'>Le produit a bien été supprimé.</p><br><br>";
                    }

                    else echo "<p id='formAjoutProduit'>Aucun produit ne correspond à cet identifiant.</p><br><br>";
                }

                else echo "<p>Erreur lors de la suppression du produit !</p><br><br>";

                mysqli_stmt_close($requete);
            }

        ?>
    

    <div class="admin">
        <div id="formAjoutProduit">
            <h2>Ajout d'un fruit dans le stock :</h2>
            <form method="post" action="" enctype="multipart/form-data">
                Libelle : <input type="text" name="LIBELLE_AJOUT" size="20" maxlength="30"><br><br>
                Description : <input type="text" name="DESCRIPTION" size="40" maxlength="255"><br><br>
                Prix : <input type="number" name="PRIX" max="999999999"><br><br>
                <input type="file" name="photo[]" multiple accept="image/png"><br><br>
                <input type="submit" name="ajouterProduit" value="AJOUTER">
            </form>
        </div>
        
        <div id="formSupprProduit">
            <h2>Suppression de fruit(s) dans le stock :</h2>
            <form method="post" action="">
                Numéro : <input type="text" name="ID_SUPPR" size="10" maxlength="30"><br><br>
                <input type="submit" name="supprimerProduit" value="SUPPRIMER">
            </form>
        </div>
    </div>
</body>
</html>