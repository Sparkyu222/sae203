<?php

    // Si on accède au script via l'url
    if (!defined('INCLUDED')) {

        header('HTTP/1.1 403 Forbidden');
        echo "You don't have access to this page.";
        die();

    }

    require('dbscripts/updateDB.php');

    // Switch case pour savoir l'objet de la requête
    switch ($request['object']) {

        // Si le client veut supprimer un client
        case "CLIENT" :
            // Si l'array "client" n'a pas été renseigné dans "content"
            if (!array_key_exists("client", $request['content']) || empty($request['content']['client'])) {

                $return['status'] = "ERROR";
                $return['message'] = "One or more content parameter is missing";
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            // Si l'un de ces éléments n'existe pas dans la requête, aborter.
            foreach($request['content']['client'] as $client) {

                if (!array_key_exists("client_id", $client) || empty($client["client_id"])) {

                    $return['status'] = "ERROR";
                    $return['message'] = "One or more content parameter is missing";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                } 

            }

            // Suppression de chaque client
            foreach($request['content']['client'] as $client) {

                $result = DelClientFromDB($pdo, $client['client_id']);

                if (!is_bool($result)) {

                    $return['status'] = "ERROR";
                    $return['message'] = "Failed deleting content of order from database";
                    $return['content'] = ["error" => $result];
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            // Notifier le client de la suppression du client
            $return['status'] = "SUCCESS";
            $return['message'] = "Client have been successfully deleted.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();

        // Si le client veut supprimer un produit
        case "PRODUCT" :
            // Si l'array "product_id" n'a pas été renseigné dans "content"
            if (!array_key_exists("product_id", $request['content']) || empty($request['content']['product_id'])) {

                $return['status'] = "ERROR";
                $return['message'] = "One or more content parameter is missing";
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            // Supression du produit de la base de données
            $result = DelProductFromDB($pdo, $request['content']['product_id']);

            // Si la requête n'a pas aboutie
            if (!$result) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed deleting product from database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            // Notifier le client dde la suppression du produit
            $return['status'] = "SUCCESS";
            $return['message'] = "Product have been successfully deleted.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();

        // Si le client veut supprimer une commande
        case "ORDER" :
            // Si l'array "order_id" n'a pas été renseigné dans "content"
            if (!array_key_exists("order_id", $request['content']) || empty($request['content']['order_id'])) {

                $return['status'] = "ERROR";
                $return['message'] = "One or more content parameter is missing";
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            // Suppression de la commande de la base de données
            $result = DelOrderFromDB($pdo, $request['content']['order_id']);

            // Si la requête n'a pas aboutie
            if (!$result) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed deleting order from database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            // Notifier le client de la suppression de la commande
            $return['status'] = "SUCCESS";
            $return['message'] = "Order have been successfully deleted.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();


        // Si le client veut supprimer le contenu d'une commande
        case "ITEM" :
            // Si l'array "item" n'a pas été renseigné dans "content"
            if (!array_key_exists("item", $request['content']) || empty($request['content']['item'])) {

                $return['status'] = "ERROR";
                $return['message'] = "One or more content parameter is missing";
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            // Si l'un de ce ces éléments n'existe pas dans la requête, aborter.
            foreach($request['content']['item'] as $item) {

                if (!array_key_exists("item_id", $item) || empty($item["item_id"])) {

                    $return['status'] = "ERROR";
                    $return['message'] = "One or more content parameter is missing";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                } 

            }

            // Suppression de chaque items
            foreach($request['content']['item'] as $item) {

                $result = DelItemFromOrder($pdo, $item['item_id']);

                if (!is_bool($result)) {

                    $return['status'] = "ERROR";
                    $return['message'] = "Failed deleting content of order from database";
                    $return['content'] = ["error" => $result];
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Order content have been successfully deleted.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();

        default :
            $return['status'] = "ERROR";
            $return['message'] = "Wrong object type request";

            echo json_encode($return, JSON_PRETTY_PRINT);
            die();

    }

?>