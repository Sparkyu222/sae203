<?php

    function getAllClients ($link) {

        try {

        // Formulation de requête
        $requete = "SELECT * FROM client";

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

    function getAllOrders ($link) {

        try {

        // Formulation de requête
        $requete = "SELECT * FROM commande";

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

    function getAllProducts ($link) {

        try {

        // Formulation de requête
        $requete = "SELECT * FROM produit";

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

?>