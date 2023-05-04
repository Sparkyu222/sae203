<?php

    session_start();

    $parsed_url = parse_url($_SERVER['REQUEST_URI']);

    $uri = $parsed_url['path'];

    if (isset($_GET['disconnect'])) {
        session_destroy();
        header("Location: $uri");
    }

    include("content/include/connectDB.php");

    $pdo = connectDB();

    if ($pdo == NULL) {

        echo "Connexion impossible à la base de données.";
        exit();

    }

    if (isset($_POST['submit'])) {

        if ($_POST['login-mail'] != "" && $_POST['login-password'] != "") {

            include("content/include/flogin.php");

            // Hashage du mot de passe
            $saltcrypt = [
                'salt' => 'Thisisarandomsaltstring',
            ];
        
            $hash = password_hash($_POST['login-password'], PASSWORD_BCRYPT, $saltcrypt);

            $return = getlogin(true, $pdo, $_POST['login-mail'], $hash, null);

            if (is_array($return)) {

                $_SESSION['user-token'] = $return[0]['token'];
                $_SESSION['user-name'] = $return[0]['username'];
                $_SESSION['user-mail'] = $return[0]['mail'];

                header("Location: $uri");
                
            }

        }

    }

    /// Entête de page
    echo <<<HTML

        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <!-- Paramètres -->
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <!-- Informations -->
                <title>TP9</title>
                <meta name="title" content="TP9">
                <meta name="author" content="">
                <meta name="description" content="Interface de gestion pour commerce en ligne">

                <!-- Imports -->
                <link rel="shortcut icon" href="media/favicon.webp" type="image/x-icon">
                <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
                
                <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
                <link rel="stylesheet" href="content/css/item-list.css">
                <!-- <link rel="stylesheet" href="css/index.css">
                <link rel="stylesheet" href="css/loader.css"> -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
                <script src="https://cdn.tailwindcss.com"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
            </head>
            <body>

    HTML;

    // Si l'utilisateur n'est pas authentifié
    if (!isset($_SESSION['user-token'])) {
        
        // Header
        echo <<<HTML
        
            <main class="w-full h-screen p-10 flex flex-col justify-center items-center gap-5 bg-gradient-to-tr from-gray-700 via-gray-900 to-black">
                <header class="hidden">

        HTML;

        //include("content/pages/header.php");

        echo <<<HTML

                        </header>
                        <div class="p-5 bg-white rounded-[35px]">
        HTML;

        // Page de login
        include("content/pages/login.php");
            
        // Pied de page
        echo <<<HTML

                            </div>
                        </main>
                    </body>
                </html>

        HTML;

        exit();

    }
    
        // Header
        echo <<<HTML
        
                        <main class="w-full h-screen flex flex-col items-center bg-black">
                            <header class="w-full h-[75px] px-[35px] py-[20px] flex justify-between">

        HTML;

        include("content/pages/header.php");

        echo <<<HTML

                            </header>
                            <div class="w-full flex-1 p-[20px] flex gap-[20px] bg-white rounded-t-[35px]">
        HTML;

        if(isset($_GET['dashboard'])){
            include("content/pages/dashboard.php");
        } else if(isset($_GET['client'])){
            include("content/pages/client.php");
        } else if(isset($_GET['order'])){
            include("content/pages/client.php");
        } else if(isset($_GET['product'])){
            include("content/pages/order.php");
        } else {
            include("content/pages/dashboard.php");
        }
            
        // Pied de page
        echo <<<HTML

                            </div>
                        </main>
                    </body>
                </html>

        HTML;

?>