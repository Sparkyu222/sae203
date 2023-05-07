<?php

    /// CLIENTS

    function AddClientToDB($link, $name, $firstname, $address, $postal, $city) {

        // Préparation de la requête
        $query = $link->prepare("INSERT INTO client (nom, prenom, adresse, code_postal, ville) VALUES (:name, :firstname, :address, :postal, :city)");

        // Assignation des paramètres
        $query->bindParam(':name', $name);
        $query->bindParam(':firtname', $firstname);
        $query->bindParam(':address', $address);
        $query->bindParam(':postal', $postal);
        $query->bindParam(':city', $city);

        if ($query->execute()) {

            return true;

        } else {

            return $query->errorInfo()[2];

        }

    }

    function DelClientFromDB($link, $id_client) {

        // Préparation de la requête
        $query = $link->prepare("DELETE FROM client WHERE id_client=:id_client");

        // Assignation du paramètre
        $query->bindParam(':id_client', $id_client);

        if ($query->execute()) {

            return true;
            
        } else {

            return $query->errorInfo()[2];

        }

    }

    

    /// PRODUITS

    function AddProductToDB($link, $product_code, $label, $price) {

        // Préparation de la requête
        $query = $link->prepare("INSERT INTO produit (code_produit, libelle, prix_unitaire) VALUES (:product_code, :label, :price)");

        // Assignation des paramètres
        $query->bindParam(':product_code', $product_code);
        $query->bindParam(':label', $label);
        $query->bindParam(':price', $price);

        if ($query->execute()) {

            return true;

        } else {

            return $query->errorInfo()[2];

        }

    }

    function DelProductFromDB($link, $id_product) {

        // Préparation de la requête
        $query = $link->prepare("DELETE FROM produit WHERE id_produit=:id_product");

        // Assignation du paramètre
        $query->bindParam(':id_product', $id_product);

        if ($query->execute()) {

            return true;
            
        } else {

            return $query->errorInfo()[2];

        }

    }



    /// COMMANDES

    /*
    function AddOrderToDB($link, $product_code, $label, $price) {

        // Préparation de la requête
        $query = $link->prepare("INSERT INTO produit (code_produit, libelle, prix_unitaire) VALUES (:product_code, :label, :price)");

        // Assignation des paramètres
        $query->bindParam(':product_code', $product_code);
        $query->bindParam(':label', $label);
        $query->bindParam(':price', $price);

        if ($query->execute()) {

            return true;

        } else {

            return $query->errorInfo()[2];

        }

    }
    */

?>