<?php

    // Protection d'accès des autres scripts
    define('INCLUDED', true);

    include('../include/connectDB.php');
    include('../include/flogin.php');

    function denied() {

        header('HTTP/1.1 403 Forbidden');
        echo "Vous n'avez pas accès à cette page.";
        die();

    }

    if (isset($_POST['user-token'])) {

        $pdo = connectDB();

        $access = getlogin(false, $pdo, null, null, $_POST['user-token']);

        if (!is_array($access)) {

            denied();

        }

    } else {

        denied();

    }

    echo <<<HTML
    
    <div class="text-3xl">Dashboard is coming back..</div>

    HTML;
?>