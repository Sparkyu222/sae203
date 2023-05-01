<?php

    include(__DIR__."/../include/addClientProduct_src.php");

    echo <<<HTML

            <header class="bg-white shadow">

                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Ajouter un produit</h1>
                </div>

            </header>

        HTML;

    echo <<<HTML

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            <form action="" method ="POST">

                <div>
                    <label for="code-produit" class="block text-sm font-medium leading-6 text-gray-900">Code produit :</label>
                    <div class="mt-2">
                        <input type="text" name="code" id="code-produit" autocomplete="given-name" class="p-2.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="libelle" class="block text-sm font-medium leading-6 text-gray-900">Libelle :</label>
                    <div class="mt-2">
                        <input type="text" name="label" id="libelle" autocomplete="family-name" class="p-2.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <label for="prix" class="block text-sm font-medium leading-6 text-gray-900">Prix unitaire :</label>
                    <div class="mt-2">
                        <input type="text" name="price" id="prix" autocomplete="street-address" class="p-2.5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="reset" class="text-sm font-semibold leading-6 text-gray-900">Réinitialiser</button>
                    <button type="submit" name="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Envoyer</button>
                </div>

            </form>

        </div>

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