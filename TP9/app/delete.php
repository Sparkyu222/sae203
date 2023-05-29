<?php

    // Si on accède au script via l'url
    if (!defined('INCLUDED')) {

        header('HTTP/1.1 403 Forbidden');
        echo "You don't have access to this page.";
        die();

    }

    require('dbscripts/updateDB.php');

    switch ($request['object']) {

        case "CLIENT" :

            if (!array_key_exists("client_id", $request['content']) || empty($request['content']['client_id'])) {

                $return['status'] = "ERROR";
                $return['message'] = "One or more content parameter is missing";
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $result = DelClientFromDB($pdo, $request['content']['client_id']);

            if (!$result) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed deleting client from database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Client have been successfully deleted.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();

        case "PRODUCT" :

            if (!array_key_exists("product_id", $request['content']) || empty($request['content']['product_id'])) {

                $return['status'] = "ERROR";
                $return['message'] = "One or more content parameter is missing";
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $result = DelProductFromDB($pdo, $request['content']['product_id']);

            if (!$result) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed deleting product from database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Product have been successfully deleted.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();


        case "ORDER" :
            if (!array_key_exists("order_id", $request['content']) || empty($request['content']['order_id'])) {

                $return['status'] = "ERROR";
                $return['message'] = "One or more content parameter is missing";
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $result = DelOrderFromDB($pdo, $request['content']['order_id']);

            if (!$result) {

                $return['status'] = "ERROR";
                $return['message'] = "Failed deleting order from database";
                $return['content'] = ["error" => $result];
    
                echo json_encode($return, JSON_PRETTY_PRINT);
                die();

            }

            $return['status'] = "SUCCESS";
            $return['message'] = "Order have been successfully deleted.";
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();


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