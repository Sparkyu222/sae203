<?php

    function getClients ($link) {

        try {

        // Formulation de requête
        $requete = "SELECT id_client,nom,prenom FROM client";

        // Exécution de la requête
        $output = $link->query($requete);

        } catch (PDOException $e) {

            return NULL;
            
        }

        $array = array();

        // Récupération de chaque valeur dans un tableau à deux dimensions
        while ($row = $output->fetch(PDO::FETCH_NUM)) {
            array_push($array, $row);
        }

        return $array;

    }

    function getProducts ($link) {

        try {

        // Formulation de requête
        $requete = "SELECT id_produit,libelle FROM produit";

        // Exécution de la requête
        $output = $link->query($requete);

        } catch (PDOException $e) {
            return NULL;
        }

        $array = array();

        // Récupération de chaque valeur dans un tableau à deux dimensions
        while ($row = $output->fetch(PDO::FETCH_NUM)) {
            array_push($array, $row);
        }

        return $array;

    }

    function addOrderToDB($link, $client, $address, $product, $quantity) {

        // Formulation de la requête
        $requete = $link->prepare("INSERT INTO commande (from_client, date, adresse_livraison, num_produit, quantite) VALUES (:client, :date, :address, :product, :quantity)");

        // Assignation des paramètres
        $requete->bindParam(':client', $client);
        $requete->bindParam(':date', date("Y-m-d H-i-s"));
        $requete->bindParam(':address', $address);
        $requete->bindParam(':product', $product);
        $requete->bindParam(':quantity', $quantity);

        // Exécuter la requête
        if ($requete->execute()) {

            return true;

        } else {

            return $requete->errorInfo()[2];

        }

    }

?>