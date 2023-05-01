<?php

    function getlogin ($mode, $link, $mail, $password, $token) {

        // $mode = true --> Login basé sur le mail et le mdp
        // $mode = false --> Login basé sur token

        try {

            if ($mode == true) {

                $query = $link->prepare("SELECT * FROM login WHERE mail=:mail AND mdp=:password");

            } else {

                $query = $link->prepare("SELECT * FROM login WHERE token=:token");

            }

        } catch (PDOException $e) {

            return "err01";

        }

        if ($mode == true) {

            $query->bindParam(':mail', $mail);
            $query->bindParam(':password', $password);

        } else {

            $query->bindParam(':token', $token);

        }

        if (!$query->execute()) {

            return "err02";

        }

        $row = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($row) >= 2) {

            return "err03";

        }

        return $row;

    }


    // DEBUG, À SUPPRIMER
    if (isset($_GET['debug'])) {

        if ($_GET['debug'] == true) {

            include("connectDB.php");

            $pdo = connectDB();

            if ($pdo == NULL) {
                
                echo "Impossible de se connecter à la base de données.";
                exit();

            }

            $result = getlogin(true, $pdo, "mail1", "password1", null);

            echo "<pre>";
            print_r($result);
            echo "</pre>";

        }

    }

?>