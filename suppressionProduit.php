<?php
    require_once 'bdd.php';

    if (isset($_POST['supprimerProduit'])) {
        $id = (int) $_POST['ID_SUPPR'];
        
        $requeteSupr = mysqli_prepare($link, "DELETE FROM Produit WHERE idProduit = ?");
        mysqli_stmt_bind_param($requeteSupr, 'i', $id);     // 'i' -> "integer"
        $requeteChemins = mysqli_prepare($link, "SELECT chemin FROM Image WHERE idProduit = ?");
        mysqli_stmt_bind_param($requeteChemins, 'i', $id);
        
        mysqli_stmt_execute($requeteChemins);
        
        $resultatChemins = mysqli_stmt_get_result($requeteChemins);
        $cheminsImages = [];
        
        while ($ligne = mysqli_fetch_assoc($resultatChemins)) {
            $cheminsImages[] = $ligne['chemin'];
        }
        
        mysqli_stmt_close($requeteChemins);
        if (mysqli_stmt_execute($requeteSupr)) {
            if (mysqli_stmt_affected_rows($requeteSupr) > 0) {
                foreach ( $cheminsImages as $chemin) {
                    if (file_exists($chemin)) {
                        unlink($chemin);
                        // echo "<p>Une image du produit $id a été supprimée.</p><br>";
                    }
                    // else echo "<p>Suppression de l'image impossible.</p>";
                }
                // echo "<p>Le produit $id a bien été supprimé.</p><br>";
            }
            // else echo "<p>Aucun produit ne correspond à cet identifiant.</p><br>";
        }
        // else echo "<p>Erreur lors de la suppression du produit !</p><br><br>";
        mysqli_stmt_close($requeteSupr);

        mysqli_close($link);
        header('Location: backOffice.php');
    }