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

            <h2> Ajouter un produit </h2>

    HTML;

    $pdo = connectDB();

    if ($pdo == NULL){

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

                Code produit : <br>
                <input type="textbox" name="code" value="">

            </p>

            <p> 
                
                Libelle : <br>
                <input type="textbox" name="label" value="">
            
            </p>

            <p>
                
                Prix unitaire : <br>
                <input type="textbox" name="price" value="">

            </p>

            <br>

            <input type="submit" name="submit" value="Créer">

        </form>

    HTML;

    if (isset($_POST['submit']) && ($_POST['code'] == "" || $_POST['label'] == "" || $_POST['price'] == "")) {

        echo "Erreur : Veuillez spécifier des informations dans tous les champs.";

    } else if (isset($_POST['submit'])) {

        $err_catch = addProductToDB($pdo, $_POST['code'], $_POST['label'], $_POST['price']);

        if ($err_catch != true) {

            echo <<<HTML

                <p> Erreur lors de l'insertion de ligne dans la base de données : {$err_catch} </p>

            HTML;

        } else {
            
            echo <<<HTML

                <p> Le produit "{$_POST['label']}" a bien été ajouté à la base de données.</p>

            HTML;

        }

    }

?>

    <p><a href="../">Retour</a></p>

    </body>

</html>