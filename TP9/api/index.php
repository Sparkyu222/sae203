<?php

    include("../content/include/connectDB.php");
    include("../content/include/flogin.php");

    header('Content-Type: application/json');

    $return = [

        "status" => "",
        "message" => "",
        "content" => []

    ];

    $pdo = connectDB();

    // Si la connexion à la base de données échoue
    if ($pdo == NULL) {

        $return['status'] = "ERROR";
        $return['message'] = "Unable to connect to the database";

        echo json_encode($return, JSON_PRETTY_PRINT);
        exit();

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



?>