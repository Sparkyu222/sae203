<?php

    // Si on accède au script via url
    if (!defined('INCLUDED')) {

        header('HTTP/1.1 403 Forbidden');
        echo "You don't have access to this page.";
        die();

    }

    // Récupérer tous les clients
    function getAllClients ($link) {

        try {

        // Formulation de requête
        $requete = "SELECT * FROM client";

        // Exécution de la requête
        $output = $link->query($requete);

        } catch (PDOException $e) {

            return NULL;
            
        }

        // Récupération de chaque valeur dans un tableau à deux dimensions
        $array = $output->fetchAll(PDO::FETCH_ASSOC);

        return $array;

    }

    // Récupérer tous les produits
    function getAllProducts ($link) {

        try {

        // Formulation de requête
        $requete = "SELECT * FROM produit";

        // Exécution de la requête
        $output = $link->query($requete);

        } catch (PDOException $e) {
            return NULL;
        }

        $array = $output->fetchAll(PDO::FETCH_ASSOC);

        return $array;

    }

    // Récupérer toutes les commandes
    function getAllOrders ($link) {

        try {

        // Formulation de requête
        $requete = "SELECT * FROM commande";

        // Exécution de la requête
        $output = $link->query($requete);

        } catch (PDOException $e) {

            return NULL;
            
        }

        // Récupération de chaque valeur dans un tableau à deux dimensions
        $array = $output->fetchAll(PDO::FETCH_ASSOC);

        return $array;

    }

    // Récupérer les produits associés à une commande
    function getItemFromOrder ($link, $id_commande) {

        try {

        // Préparation de la requête
        $query = $link->prepare("SELECT * FROM contenu_commande WHERE num_commande=:num_commande");

        // Assignation des paramètres
        $query->bindParam(':num_commande', $id_commande);

        $query->execute();

        } catch (PDOException $e) {

            return NULL;
            
        }

        // Récupération de chaque valeur dans un tableau à deux dimensions
        $array = $query->fetchAll(PDO::FETCH_ASSOC);

        return $array;

    }

    // Récupérer les commandes d'un client
    function getOrdersFromClient ($link, $id_client) {

        try {
        
        // Préparation de la requête
        $query = $link->prepare("SELECT * FROM commande WHERE from_client = :from_client");

        // Assignation des paramètres
        $query->bindParam(':from_client', $id_client);

        $query->execute();

        } catch (PDOException $e) {

            return NULL;
            
        }

        // Récupération de chaque valeur dans un tableau à deux dimensions
        $array = $query->fetchAll(PDO::FETCH_ASSOC);

        return $array;

    }



?>