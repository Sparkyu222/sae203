<!doctype html>
<html>
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            .lts > ul{
                height: 0;

                padding: 0;
                
                opacity: 0;

                border: 1px solid #dadada;
                border-radius: 0.375rem;

                overflow: hidden;

                transition: 300ms;
            }

            .lts:hover > ul{
                height: auto;

                padding: 20px;

                margin: 0 0 20px 0;
                
                opacity: 1;

                overflow: auto;
            }
        </style>
    </head>

    <body>

    <?php

        include("pages/module/header.php");
        include("include/db_functions.php");
        
        $pdo = connectDB();

        if ($pdo == NULL) {

            echo <<<HTML
    
                <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Erreur</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Il est impossible de se connecter à la base de données. Veuillez contacter l'administrateur du site.</p>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="button" onclick="location.reload()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Rafraîchir</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
    
            HTML;
    
            include("pages/module/footer.php");
    
            exit();
    
        }

        if (isset($_GET['page'])) {

            switch ($_GET['page']) {
                case 0 :
                    include("pages/dashboard.php");
                    break;

                case 1 :
                    include("pages/ajouter_client.php");
                    break;
                
                case 2 :
                    include("pages/ajouter_produit.php");
                    break;
                    
                case 3 :
                    include("pages/commander.php");
                    break;
                
                default:
                    echo <<<HTML

                            <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
                                <div class="text-center">
                                    <p class="text-base font-semibold text-indigo-600">404</p>
                                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Page non trouvée.</h1>
                                    <p class="mt-6 text-base leading-7 text-gray-600">La page que vous tentez d'accéder n'existe pas.</p>
                                    <div class="mt-10 flex items-center justify-center gap-x-6">
                                        <a href="/TP8" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go back home</a>
                                </div>
                            </main>

                    HTML;
                    break;

            }

        } else {

            echo <<<HTML

                    <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
                        <div class="text-center">
                            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Bienvenue sur un système simple de gestion d'un magasin</h1>
                            <p class="mt-6 text-base leading-7 text-gray-600">Sélectionnez un élément dans la barre de menu.</p>
                        </div>
                    </main>

            HTML;

        }
        
        include("pages/module/footer.php");

    ?>

    </body>

</html>