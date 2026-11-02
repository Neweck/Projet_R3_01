<?php
    require_once 'bdd.php';
    session_start();

    // Gestion des erreurs de création de produit
    $erreurs = [];

    $libelle = $_POST['LIBELLE_AJOUT'];
    $description = $_POST['DESCRIPTION'];
    $prix = $_POST['PRIX'];

    if ($libelle === '') {
        $erreurs[] = "Le libellé est obligatoire.";
    }
    if ($description === '') {
        $erreurs[] = "La description est obligatoire.";
    }
    if ($prix === '' || !is_numeric($prix) || $prix < 0) {
        $erreurs[] = "Le prix est obligatoire et doit être un nombre positif.";
    }
    if (!isset($_FILES['img1']) || $_FILES['img1']['error'] !== UPLOAD_ERR_OK) {
        $erreurs[] = "L'image du fruit est obligatoire.";
    }
    if (!isset($_FILES['img2']) || $_FILES['img2']['error'] !== UPLOAD_ERR_OK) {
        $erreurs[] = "L'illustration du pouvoir est obligatoire.";
    }

    if (count($erreurs) > 0) {
        $_SESSION['erreursAjout'] = $erreurs;
        header('Location: backOffice.php');
        exit;
    }

    // Ajout d'un produit à la liste
    if (isset($_POST['ajouterProduit'])) {

        // Requête d'insertion des produits dans la BDD
        $requeteInsert = mysqli_prepare($link, "INSERT INTO Produit (LIBELLE, DESCRIPTION, PRIX) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($requeteInsert, 'ssd', $libelle, $description, $prix);     // 'ssd' -> "string" , "string" , "decimal";
        
        // Requete de sélection de chaque image pour chaque produit
        $reqImage = mysqli_prepare($link, "INSERT INTO Image (chemin, idProduit) VALUES (?, ?)");
        mysqli_stmt_bind_param($reqImage, 'si', $chemin, $idProduit);   // 'ss' -> string , integer

        // Exécution de l'insertion dans la BDD
        if (isset($_FILES['img1'], $_FILES['img2'])) {
            if (mysqli_stmt_execute($requeteInsert)) {
                $idProduit = mysqli_insert_id($link);


                // Récupération du chemin pour chaque image uploadée
                foreach (['img1', 'img2'] as $image) {
                    $tmp = $_FILES[$image]['tmp_name'];
                    $chemin = 'images/' . $_FILES[$image]['name'];

                    // Ajout des fichiers images dans le dossier correspondant 
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

        // Fermeture des requetes paramétrées
        mysqli_stmt_close($requeteInsert);
        mysqli_stmt_close($reqImage);

        mysqli_close($link);
        header('Location: backOffice.php');
        exit;
    }