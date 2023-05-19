<?php

    // Si on accède au script via url
    if (!defined('INCLUDED')) {

        header('HTTP/1.1 403 Forbidden');
        echo "You don't have access to this page.";
        die();

    }



    /// CLIENTS

    // Ajouter un client
    function AddClientToDB($link, $name, $firstname, $address, $compl_address, $postal, $city, $country) {

        try {
        // Préparation de la requête
        $query = $link->prepare("INSERT INTO client (nom, prenom, adresse, complement_adresse, code_postal, ville, pays) VALUES (:name, :firstname, :address, :compl_address, :postal, :city, :country)");

        // Assignation des paramètres
        $query->bindParam(':name', $name);
        $query->bindParam(':firstname', $firstname);
        $query->bindParam(':address', $address);
        $query->bindParam(':compl_address', $compl_address);
        $query->bindParam(':postal', $postal);
        $query->bindParam(':city', $city);
        $query->bindParam(':country', $country);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }

    // Mettre à jour un client
    function UpdateClientFromDB ($link, $id_client, $name, $firstname, $address, $compl_address, $postal, $city, $country) {

        try {
        // Préparation de la requête
        $query = $link->prepare("UPDATE client SET nom = :name, prenom = :firstname, adresse = :address, complement_adresse = :compl_address, code_postal = :postal, ville = :city, pays = :country WHERE id_client = :id_client");

        // Assignation des paramètres
        $query->bindParam(':name', $name);
        $query->bindParam(':firstname', $firstname);
        $query->bindParam(':address', $address);
        $query->bindParam(':compl_address', $compl_address);
        $query->bindParam(':postal', $postal);
        $query->bindParam(':city', $city);
        $query->bindParam(':id_client', $id_client);
        $query->bindParam(':country', $country);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;


    }

    // Supprimer un client
    function DelClientFromDB($link, $id_client) {

        try {

        // Préparation de la requête
        $query = $link->prepare("DELETE FROM client WHERE id_client=:id_client");

        // Assignation du paramètre
        $query->bindParam(':id_client', $id_client);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }



    /// PRODUITS

    // Ajouter un produit
    function AddProductToDB($link, $product_code, $label, $price) {

        try {

        // Préparation de la requête
        $query = $link->prepare("INSERT INTO produit (code_produit, libelle, prix_unitaire) VALUES (:product_code, :label, :price)");

        // Assignation des paramètres
        $query->bindParam(':product_code', $product_code);
        $query->bindParam(':label', $label);
        $query->bindParam(':price', $price);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }

    // Mettre à jour un produit
    function UpdateProductFromDB ($link, $id_produit, $product_code, $label, $price) {

        try {
            
        // Préparation de la requête
        $query = $link->prepare("UPDATE produit SET code_produit = :product_code, libelle = :label, prix_unitaire = :price WHERE id_produit = :id_produit");

        // Assignation des paramètres
        $query->bindParam(':product_code', $product_code);
        $query->bindParam(':label', $label);
        $query->bindParam(':price', $price);
        $query->bindParam(':id_produit', $id_produit);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }

    // Supprimer un produit
    function DelProductFromDB($link, $id_product) {

        try {

        // Préparation de la requête
        $query = $link->prepare("DELETE FROM produit WHERE id_produit=:id_product");

        // Assignation du paramètre
        $query->bindParam(':id_product', $id_product);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }



    /// COMMANDES

    // Ajouter une commande
    function AddOrderToDB($link, $client, $address) {

        try {

        // Préparation de la requête
        $query = $link->prepare("INSERT INTO commande (from_client, date, adresse_livraison) VALUES (:from_client, :date, :adresse_livraison)");

        // Assignation des paramètres
        $query->bindParam(':from_client', $client);
        $query->bindParam(':date', date("Y-m-d H:i:s"));
        $query->bindParam(':adresse_livraison', $address);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }

    // Mettre à jour une commande
    function UpdateOrderFromDB ($link, $id_commande, $client, $address) {

        try {
        // Préparation de la requête
        $query = $link->prepare("UPDATE commande SET from_client = :from_client, adresse_livraison = :adresse_livraison WHERE id_commande = :id_commande)");

        // Assignation des paramètres
        $query->bindParam(':from_client', $client);
        $query->bindParam(':adresse_livraison ', $address);
        $query->bindParam(':id_commande', $id_commande);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }


    // Supprimer une commande
    function DelOrderFromDB($link, $id_commande) {

        try {
        // Préparation de la requête
        $query = $link->prepare("DELETE FROM commande WHERE id_commande=:id_commande");

        // Assignation du paramètre
        $query->bindParam(':id_commande', $id_commande);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }



    /// CONTENU DE COMMANDE

    // Ajouter un produit à une commande
    function AddItemToOrder($link, $id_commande, $id_produit, $quantity) {

        try{

        // Préparation de la requête
        $query = $link->prepare("INSERT INTO contenu_commande (num_commande, num_produit, quantite) VALUES (:num_commande, :num_produit, :quantite)");

        // Assignation des paramètres
        $query->bindParam(':num_commande', $id_commande);
        $query->bindParam(':num_produit', $id_produit);
        $query->bindParam(':quantite', $quantity);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;


    }

    // Supprimer un produit d'une commande
    function DelItemFromOrder($link, $id_contenue) {

        try {

        // Préparation de la requête
        $query = $link->prepare("DELETE FROM contenu_commande WHERE id_contenue=:id_contenue");

        // Assignation du paramètre
        $query->bindParam(':id_contenue', $id_contenue);

        $query->execute();

        } catch (PDOException $e) {

            return $query->errorInfo()[2];

        }

        return true;

    }

?>