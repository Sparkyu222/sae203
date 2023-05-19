<?php

    // Si on accède au script via l'url
    if (!defined('INCLUDED')) {

        header('HTTP/1.1 403 Forbidden');
        echo "You don't have access to this page.";
        die();

    }

    require('dbscripts/fetchDB.php');

    // Switch case pour le type d'objet demandé
    switch ($request['object']) {

        // Si le client veux fetch tous les clients
        case "CLIENT" :
            $return['status'] = "SUCCESS";
            $return['message'] = "";
            $return['content'] = ["client" => getAllClients($pdo)];
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();

        // Si le client veux fetch tous les produits
        case "PRODUCT" :
            $return['status'] = "SUCCESS";
            $return['message'] = "";
            $return['content'] = ["product" => getAllProducts($pdo)];
    
            echo json_encode($return, JSON_PRETTY_PRINT);
            exit();



        // Si le client veux fetch une série de commandes ou toutes les commandes
        case "ORDER" :

            // Si le paramètre "specific" n'a pas été spécifié par le client
            if (    !array_key_exists("specific", $request['content'])    || 
                    $request['content']['specific'] == ""                 || 
                    $request['content']['specific'] == null)              
                {

                    $return['status'] = "ERROR";
                    $return['message'] = "Specific paramater is missing.";

                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }
            
            // On regarde si le client veux les commandes d'un client ou toutes les commandes
            switch ($request['content']['specific']) {

                // Si il veux fetch les commandes d'un client
                case true :
                case "true" :
                case 1 :
                    // Si le client n'a pas donné d'ID de client
                    if (    !array_key_exists("client", $request['content'])    || 
                            $request['content']['client'] == ""                 || 
                            $request['content']['client'] == null)              
                        {

                        $return['status'] = "ERROR";
                        $return['message'] = "No client were specified.";
            
                        echo json_encode($return, JSON_PRETTY_PRINT);
                        die();

                    }
                    
                    $result = getOrdersFromClient($pdo, $request['content']['client']);

                    // Si la requête échoue
                    if (!is_array($result)) {

                        $return['status'] = "ERROR";
                        $return['message'] = "Database request failed.";
            
                        echo json_encode($return, JSON_PRETTY_PRINT);
                        die();
                        
                    }

                    $return['status'] = "SUCCESS";
                    $return['message'] = "";
                    $return['content'] = ["order" => $result];
            
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    exit();


                // Sinon, il veux fetch toutes les commandes
                case false :
                case "false" :
                case 0 :
                default :
                    $return['status'] = "SUCCESS";
                    $return['message'] = "";
                    $return['content'] = ["order" => getAllOrders($pdo)];
            
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    exit();

            }


        // Si le client veux fetch le contenue d'une commande
        case "ITEM" :
            // Si le client n'a pas donné d'ID de client
            if (    !array_key_exists("order", $request['content'])    || 
                    $request['content']['order'] == ""                 || 
                    $request['content']['order'] == null)              
                {

                    $return['status'] = "ERROR";
                    $return['message'] = "No order were specified.";
            
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();

                }

                $result = getItemFromOrder($pdo, $request['content']['order']);

                // Si la requête échoue
                if (!is_array($result)) {

                    $return['status'] = "ERROR";
                    $return['message'] = "Database request failed.";
        
                    echo json_encode($return, JSON_PRETTY_PRINT);
                    die();
                    
                }

                $return['status'] = "SUCCESS";
                $return['message'] = "";
                $return['content'] = ["item" => $result];
        
                echo json_encode($return, JSON_PRETTY_PRINT);
                exit();

            break;

        // Si l'objet de la requête n'a pas été reconnue
        default :
            $return['status'] = "ERROR";
            $return['message'] = "Wrong object type request";

            echo json_encode($return, JSON_PRETTY_PRINT);
            die();

    }

?>