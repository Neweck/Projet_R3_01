<?php
    require_once 'bdd.php';

    if (isset($_POST['ajouterProduit'])) {
        $libelle = $_POST['LIBELLE_AJOUT'];
        $description = $_POST['DESCRIPTION'];
        $prix = $_POST['PRIX'];

        $requeteInsert = mysqli_prepare($link, "INSERT INTO Produit (LIBELLE, DESCRIPTION, PRIX) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($requeteInsert, 'ssd', $libelle, $description, $prix);     // 'ssd' -> "string" , "string" , "decimal";
        
        $reqImage = mysqli_prepare($link, "INSERT INTO Image (chemin, idProduit) VALUES (?, ?)");
        mysqli_stmt_bind_param($reqImage, 'si', $chemin, $idProduit);   // 'ss' -> string , integer
        if (isset($_FILES['img1'], $_FILES['img2'])) {
            if (mysqli_stmt_execute($requeteInsert)) {
                $idProduit = mysqli_insert_id($link);
                foreach (['img1', 'img2'] as $image) {
                    $tmp = $_FILES[$image]['tmp_name'];
                    $chemin = 'images/' . $_FILES[$image]['name'];
                    if (move_uploaded_file($tmp, $chemin)) {
                        mysqli_stmt_execute($reqImage);
                        // echo "<p>Le fichier $chemin a bien été placé dans le dossier images/</p>";
                    }
                }
                // echo "<p>Le produit a bien été ajouté.</p><br><br>";
            }
            // else echo "<p>Erreur lors de l'ajout du produit !</p><br><br>";
        }
        // else echo "<p>Aucune(s) image(s) sélectionnée(s) !</p><br><br>";
        mysqli_stmt_close($requeteInsert);
        mysqli_stmt_close($reqImage);

        mysqli_close($link);
        header('Location: backOffice.php');
    }