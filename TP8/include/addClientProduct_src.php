<?php

    function addClientToDB($link, $nom, $prenom, $adresse, $code_postal, $ville) {

        // Formulation de la requête
        $requete = $link->prepare("INSERT INTO client (nom, prenom, adresse, code_postal, ville) VALUES (:nom, :prenom, :adresse, :code_postal, :ville)");

        // Assignation des paramètres
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
        $requete->bindParam(':adresse', $adresse);
        $requete->bindParam(':code_postal', $code_postal);
        $requete->bindParam(':ville', $ville);

        // Exécuter la requête
        if ($requete->execute()) {

            return true;

        } else {

            return $requete->errorInfo()[2];

        }
        
    }

    function addProductToDB($link, $code, $label, $price) {
            
        // Formulation de la requête
        $requete = $link->prepare("INSERT INTO produit (code_produit, libelle, prix_unitaire) VALUES (:code, :label, :price)");

        // Assignation des paramètres
        $requete->bindParam(':code', $code);
        $requete->bindParam(':label', $label);
        $requete->bindParam(':price', $price);


        // Exécuter la requête
        if ($requete->execute()) {

            return true;

        } else {

            return $requete->errorInfo()[2];

        }
    }

?>