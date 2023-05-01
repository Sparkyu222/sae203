<?php

    function connectDB () {
        
        // Credentials
        $host = "localhost";
        $dbname = "tp7";
        $user = "php";
        $password = "12345";

        // Tentative de connexion
        try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {

            return NULL;

        }

        return $pdo;

    }

?>