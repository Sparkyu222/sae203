<?php

    include(__DIR__."/../include/db_functions.php");
    include(__DIR__."/../include/addCommand_src.php");

    echo <<<HTML

        <html>
            
            <head>
                <meta charset="UTF-8">
            </head>

            <body>
                
            <h1> Système simple de gestion d'un magasin </h1>

            <h2> Commander un produit </h2>

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

                Adresse de livraison : <br>
                <input type="textbox" name="address" value="">

            </p>

    HTML;

    $client_list = getClients($pdo);
    $products_list = getProducts($pdo);

    echo <<<HTML

        <p> 
                
            Nom du client : <br>
            <select name="client">
                <option value="">--client--</option>

    HTML;

    for($i=0 ; $i < count($client_list) ; $i++) {

        echo '<option value="' . $client_list[$i][0] . '">' . $client_list[$i][1] . " " . $client_list[$i][2] . '</option>';

    }

    echo <<<HTML

            </select>
        </p>

        <p> 
                
            Produit : <br>
            <select name="product">
                <option value="">--produit--</option>

    HTML;

    for ($i=0 ; $i < count($products_list) ; $i++) {

        echo '<option value="' . $products_list[$i][0] . '">' . $products_list[$i][1] . '</option>';

    }

    echo <<<HTML

            </select>
        </p>

        <p> 
                
            Quantité : <br>
            <input type="text" name="quantity" value ="">

        </p>


        <br>

        <input type="submit" name="submit" value="Créer">

        </form>

    HTML;

    if (isset($_POST['submit']) && ($_POST['address'] == "" || $_POST['client'] == "" || $_POST['product'] == "" || $_POST['quantity'] == "")) {

        echo "Erreur : Veuillez spécifier des informations dans tous les champs.";

    } else if (isset($_POST['submit'])) {

        $err_catch = addOrderToDB($pdo, $_POST['client'], $_POST['address'], $_POST['product'], $_POST['quantity']);

        if ($err_catch != true) {

            echo "Une erreur s'est produite lors de l'insertion des données à la base de données : $err_catch";

        } else {

            echo "La commande de ". $client_list[$_POST['client']][1] ." a correctement été ajouté la base de données";

        }

    }

?>

    <p><a href="../">Retour</a></p>

    </body>

</html>