<?php

    // API qui récupère les actions sur base de données
    // Cette API permet de récupérer (fetch), ajouter (add) ou supprimer (delete) des objets contenu dans la base données

    // Inclusion des scripts de logins
    include("../content/include/connectDB.php");
    include("../content/include/flogin.php");

    // On définit le contenu de la page dans le header
    header('Content-Type: application/json');

    // Array qui contient la réponse
    $return = [

        "status" => "",
        "message" => "",
        "content" => []

    ];

    // Connexion à la base de données
    $pdo = connectDB();

    // Si la connexion à la base de données échoue
    if ($pdo == NULL) {

        $return['status'] = "ERROR";
        $return['message'] = "Unable to connect to the database";

        echo json_encode($return, JSON_PRETTY_PRINT);
        die();

    }

    // Si aucun token n'as pas été passé en POST
    if (!isset($_POST['token'])) {

        $return['status'] = "ERROR";
        $return['message'] = "Token is missing";

        echo json_encode($return, JSON_PRETTY_PRINT);
        exit();

    }

    // Vérification du token
    $dblogin = getlogin(false, $pdo, null, null, $_POST['token']);

    // Si le token n'est pas présent dans la base de donnée
    if (!is_array($dblogin)) {

        $return['status'] = "ERROR";
        $return['message'] = "Token is invalid";

        echo json_encode($return, JSON_PRETTY_PRINT);
        exit();

    }

    // Si le type d'action n'a pas été renseigné
    if (!isset($_POST['action']) || $_POST['action'] = "") {

        $return['status'] = "ERROR";
        $return['message'] = "Action type on database missing";

        echo json_encode($return, JSON_PRETTY_PRINT);
        exit();

    }

    // Type d'actions : fetch, add, delete
    /*
    switch ($_POST['action']) {

        case "add" :
            

    }
    */

?>