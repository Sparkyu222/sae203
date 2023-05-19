<?php

    // Si on accède au script via l'url
    if (!defined('INCLUDED')) {

        header('HTTP/1.1 403 Forbidden');
        echo "You don't have access to this page.";
        die();

    }

    require('dbscripts/updateDB.php');

    $client_required = ["name", "firstname", "address", "compl_address", "postal", "city", "country"];
    $product_required = ["product_code", "label", "price"];
    $order_required = ["client", "address"];
    $item_required = ["order_id", "product_id", "quantity"];

    switch ($request['object']) {

        // Si le client veux ajouter un client
        case "CLIENT" :
            // Si l'un de ce ces éléments n'existe pas dans la requête, aborter.
            foreach ($client_required as $key) {

                // Le complément d'adresse peut être vide, on doit créer une exception si elle est présente
                if ($key == "compl_address" && array_key_exists($key, $request['content'])) continue;

                // Si l'élément n'existe pas ou qu'il est vide
                if (!array_key_exists($key, $request['content']) || empty($request['content'][$key])) {

                    $return['status'] = "ERROR";
                    $return['message'] = "One or more content parameter is missing";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            $result = addClientToDB($pdo, $request['content']['name'], $request['content']['firstname'], $request['content']['address'], $request['content']['compl_address'], $request['content']['postal'], $request['content']['city'], $request['content']['country']);

            if (!is_bool($result)) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed adding client to database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Client added.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();

        // Si le client veux ajouter un produit
        case "PRODUCT" :
            // Si l'un de ce ces éléments n'existe pas dans la requête, aborter.
            foreach ($product_required as $key) {

                if (!array_key_exists($key, $request['content']) || empty($request['content'][$key])) {

                    $return['status'] = "ERROR";
                    $return['message'] = "One or more content parameter is missing";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            $result = addProductToDB($pdo, $request['content']['product_code'], $request['content']['label'], $request['content']['price']);

            if (!is_bool($result)) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed adding product to database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Product have been successfully added.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();


        // Si le client veux ajouter une commande
        case "ORDER" :
            // Si l'un de ce ces éléments n'existe pas dans la requête, aborter.
            foreach ($order_required as $key) {

                if (!array_key_exists($key, $request['content']) || empty($request['content'][$key])) {

                    $return['status'] = "ERROR";
                    $return['message'] = "One or more content parameter is missing";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            $result = addOrderToDB($pdo, $request['content']['client'], $request['content']['address']);

            if (!is_bool($result)) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed adding order to database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Order have been successfully added.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();


        // Si le client veux ajouter du contenu à une commande
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

                foreach($item_required as $key) {

                    if (!array_key_exists($key, $item) || empty($item[$key])) {

                        $return['status'] = "ERROR";
                        $return['message'] = "One or more content parameter is missing";
            
                        echo json_encode($return, JSON_PRETTY_PRINT);
                        die();

                    } 

                }

            }

            foreach($request['content']['item'] as $item) {

                $result = AddItemToOrder($pdo, $item['order_id'], $item['product_id'], $item['quantity']);

                if (!is_bool($result)) {

                    $return['status'] = "ERROR";
                    $return['message'] = "Failed adding content of order to database";
                    $return['content'] = ["error" => $result];
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Order content have been successfully added.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();



        // Si l'objet de la requête n'a pas été reconnue
        default :
            $return['status'] = "ERROR";
            $return['message'] = "Wrong object type request";

            echo json_encode($return, JSON_PRETTY_PRINT);
            die();

    }

?>