<?php

    // Si on accède au script via l'url
    if (!defined('INCLUDED')) {

        header('HTTP/1.1 403 Forbidden');
        echo "You don't have access to this page.";
        die();

    }

    require('dbscripts/updateDB.php');

    // Array qui contient les informations requises lors de la requête du client
    $client_required = ["client_id", "name", "firstname", "address", "compl_address", "postal", "city", "country"];
    $product_required = ["product_id", "product_code", "label", "price"];
    $order_required = ["order_id", "client_id", "address"];

    // Switch case en fonction de l'objet de la requête
    switch ($request['object']) {

        // Si le client veux mettre à jour un client
        case "CLIENT" :
            // Vérification de chaque information si elle est vide ou inexistante
            foreach ($client_required as $key) {

                if ($key == "compl_address" && array_key_exists($key, $request['content'])) continue;

                if (!array_key_exists($key, $request['content']) || empty($request['content'][$key])) {

                    $return['status'] = "ERROR";
                    $return['message'] = "One or more content parameter is missing";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            // Envoie de la requête à la base de données
            $result = UpdateClientFromDB($pdo, $request['content']['client_id'], $request['content']['name'], $request['content']['firstname'], $request['content']['address'], $request['content']['compl_address'], $request['content']['postal'], $request['content']['city'], $request['content']['country']);

            // Si la requête a échouée
            if (!is_bool($result)) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed updating client from database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();
                
            }

            // Si on arrive ici, la requête à aboutie
            $return['status'] = "SUCCESS";
            $return['message'] = "Client updated.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();

        case "PRODUCT" :
            foreach ($product_required as $key) {

                if (!array_key_exists($key, $request['content']) || empty($request['content'][$key])) {

                    $return['status'] = "ERROR";
                    $return['message'] = "One or more content parameter is missing";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            $result = UpdateProductFromDB($pdo, $request['content']['product_id'], $request['content']['product_code'], $request['content']['label'], $request['content']['price']);

            if (!is_bool($result)) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed updating product from database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();
                
            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Product updated.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();


        case "ORDER" :
            foreach ($order_required as $key) {

                if (!array_key_exists($key, $request['content']) || empty($request['content'][$key])) {

                    $return['status'] = "ERROR";
                    $return['message'] = "One or more content parameter is missing";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

            }

            $result = UpdateOrderFromDB($pdo, $request['content']['order_id'], $request['content']['client_id'], $request['content']['address']);

            if (!is_bool($result)) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed updating order from database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Order updated.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();


        default :
            $return['status'] = "ERROR";
            $return['message'] = "Wrong object type request";

            echo json_encode($return, JSON_PRETTY_PRINT);
            die();

    }

?>