<?php

    include(__DIR__."/../include/db_functions.php");
    include(__DIR__."/../include/addClientProduct_src.php");

    echo <<<HTML

        <html>
            
            <head>
                <meta charset="UTF-8">
            </head>

            <body>
                
            <h1> Système simple de gestion d'un magasin </h1>

            <h2> Ajouter un client </h2>

    HTML;

    $pdo = connectDB();

    if ($pdo == NULL) {

        echo <<<HTML

            <p> Il est impossible de se connecter à la base de donnée. </p>
            <body>
            </html>

        HTML;
        exit();

    }

    echo <<<HTML

            <form action="" method ="POST">

                <p>

                    Nom : <br>
                    <input type="textbox" name="name" value="">

                </p>

                <p> 
                    
                    Prénom : <br>
                    <input type="textbox" name="firstname" value="">
                
                </p>

                <p>
                    
                    Adresse : <br>
                    <input type="textbox" name="address" value="">

                </p>

                <p>
                    
                    Code postal : <br>
                    <input type="textbox" name="postal" value="">

                </p>

                <p>
                    
                    Ville : <br>
                    <input type="textbox" name="city" value="">
                
                </p>

                <br>

                <input type="submit" name="submit" value="Créer">

            </form>

    HTML;

    if (isset($_POST['submit']) && ($_POST['name'] == "" || $_POST['firstname'] == "" || $_POST['address'] == "" || $_POST['postal'] == "" || $_POST['city'] == "")) {

        echo "Erreur : Veuillez spécifier des informations dans tous les champs.";
    
    } else if (isset($_POST['submit'])) {

        $err_catch = addClientToDB($pdo, strtoupper($_POST['name']), $_POST['firstname'], $_POST['address'], $_POST['postal'], $_POST['city']);

        if ($err_catch != true) {

            echo <<<HTML

                <p> Erreur lors de l'insertion de ligne dans la base de données : {$err_catch} </p>

            HTML;

        } else {

            $display_name = strtoupper($_POST['name']);

            echo <<<HTML

                <p> Le client "{$display_name} {$_POST['firstname']}" a bien été ajouté à la base de données.</p>

            HTML;

        }

    }

?>

        <p><a href="../">Retour</a></p>

    </body>

</html>