<?php

    // Protection d'accès des autres scripts
    define('INCLUDED', true);

    // API qui récupère les actions sur base de données
    // Cette API permet de récupérer (fetch), ajouter (add), mettre à jour (update) et supprimer (delete) des objets contenu dans la base données

    // Inclusion des scripts de logins
    require("../content/include/connectDB.php"); 
    require("../content/include/flogin.php");

    // On définit le contenu de la page dans le header
    header('Content-Type: application/json');

    // Array qui contient la réponse
    $return = [

        "status" => "",
        "message" => "",
        "content" => []

    ];

    if ($_SERVER['REQUEST_METHOD'] !== "POST") {

        $return['status'] = "ERROR";
        $return['message'] = "Wrong request method made.";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    if (!isset($_POST['request'])) {

        $return['status'] = "ERROR";
        $return['message'] = "No request were transmitted.";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    // On convertie les données JSON en array
    $request = json_decode($_POST['request'], true);

    // Si la conversion a échouée
    if ($request === NULL) {

        $return['status'] = "ERROR";
        $return['message'] = "Bad request transmitted.";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    // Si l'un de ce ces éléments n'existe pas dans la requête, aborter.
    if (    !array_key_exists("token", $request)    ||
            !array_key_exists("action", $request)   ||
            !array_key_exists("object", $request)   ||
            !array_key_exists("content", $request) 
    ) {

        $return['status'] = "ERROR";
        $return['message'] = "Bad request given.";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    // Connexion à la base de données
    $pdo = connectDB();

    // Si la connexion à la base de données échoue
    if ($pdo == NULL) {

        $return['status'] = "ERROR";
        $return['message'] = "Unable to connect to the database";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    // Si le token est vide
    if ($request['token'] == "" || $request['token'] == null) {

        $return['status'] = "ERROR";
        $return['message'] = "Token is missing";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    // Vérification du token
    $dblogin = getlogin(false, $pdo, null, null, $_POST['token']);

    // Si le token n'est pas présent dans la base de donnée
    if (!is_array($dblogin)) {

        $return['status'] = "ERROR";
        $return['message'] = "Token is invalid";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    // Si le type d'action n'a pas été renseigné
    if ($request['action'] == "" || $request['action'] == null) {

        $return['status'] = "ERROR";
        $return['message'] = "Action type on database missing";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    // Type d'actions : fetch, add, update, delete
    switch ($request['action']) {

        case "FETCH" :
            require('fetch.php');
            break;

        case "ADD" :
            require('add.php');
            break;

        case "UPDATE" :
            require('update.php');
            break;

        case "DELETE" :
            require('delete.php');
            break;

        default :
            $return['status'] = "ERROR";
            $return['message'] = "Action type on database missing";

            echo json_encode($return, JSON_PRETTY_PRINT);
            die();

    }

?>