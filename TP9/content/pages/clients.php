<?php 

    // Protection d'accès des autres scripts
    define('INCLUDED', true);

    require('../include/connectDB.php');
    require('../include/flogin.php');
    require('../include/getfromdb.php');

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

        <div class="w-full h-full p-[30px] flex justify-center items-center absolute top-[0] left-[0] backdrop-blur-sm bg-gray-300/30 commandLayer3 hidden z-50">
            <div class="max-w-[1200px] p-[40px] relative bg-white shadow-lg rounded-[30px]">
                <button class="aspect-square w-[40px] flex justify-center items-center absolute top-[-10px] right-[-10px] bg-red-700 rounded-full text-white text-[16px] hover:text-[20px] duration-100 commandBtn3"><i class="fa-solid fa-xmark"></i></button>
                <form action="" method="post" class="form flex flex-col gap-[30px]">
                    <h2 class="text-[28px] font-bold text-center">Ajouter un nouveau client</h2>
                    <div class="flex flex-col gap-[20px]">
                        <div class="grid grid-cols-2 gap-[20px]">
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Nom</label>
                                <input type="text" name="firstname" id="firstname" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Prénom</label>
                                <input type="text" name="lastname" id="lastname" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-[20px]">
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Adresse</label>
                                <input type="text" name="address" id="address" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-[20px]">
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Code postal</label>
                                <input type="text" name="postal" id="postal" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                            <div class="flex flex-col gap-[10px] col-span-2">
                                <label for="" class="ml-[15px]">Complément d'adresse</label>
                                <input type="text" name="compladdress" id="compladdress" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-[20px]">
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Ville</label>
                                <input type="text" name="city" id="city" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Pays</label>
                                <input type="text" name="country" id="country" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-[20px]">
                        <button type="reset" class="px-[20px] py-[10px] rounded-[20px]">Rénitialiser</button>
                        <button type="button" id="submit_addclient" class="px-[20px] py-[10px] flex justify-center items-center bg-cyan-950 text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms]">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="h-full w-full flex gap-[20px] relative">
            <div class="flex-1 flex bg-slate-300 rounded-[20px] overflow-hidden">
                <div class="flex-1 p-[20px] flex onglet-container">
                    <div class="p-[30px] flex-1 flex flex-col justify-center items-center gap-[40px] onglet-layer" data-onglet="3">
                        <i class="fa-solid fa-user text-cyan-950 text-[6em]"></i>
                        <span class="text-[20px] text-slate-500">Pas de profil client sélectionné..</span>
                    </div>
                    <div class="flex-1 flex flex-col gap-[20px] overflow-auto onglet-layer hidden" data-onglet="4">
                        <div class="p-[20px] flex gap-[20px] bg-white rounded-[20px]">
                            <div class="w-[30%] flex">
                                <img class="flex-1 flex justify-center items-center rounded-[20px] object-cover overflow-hidden" src="https://images.pexels.com/photos/2599869/pexels-photo-2599869.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
                            </div>
                            <div class="w-[70%] flex flex-col gap-[30px] p-[20px] border rounded-[20px]">
                                <div class="flex flex-col gap-[10px]">
                                    <div class="grid grid-cols-2 gap-[20px]">
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Nom</label>
                                            <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Prénom</label>
                                            <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-[20px]">
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Adresse</label>
                                            <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-[20px]">
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Code postal</label>
                                            <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                        <div class="flex flex-col gap-[10px] col-span-2">
                                            <label for="" class="ml-[15px]">Complément d'adresse</label>
                                            <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-[20px]">
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Ville</label>
                                            <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Pays</label>
                                            <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-[20px]">
                                    <button type="reset" class="px-[20px] py-[10px] rounded-[20px]">Supprimer</button>
                                    <button class="px-[20px] py-[10px] flex justify-center items-center bg-cyan-950 text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms] onglet-btn" data-onglet="3">Sauvegarder</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-h-[80%] flex overflow-hidden">
                            <div class="flex-1 flex flex-col overflow-hidden">
                                <div class="flex flex-col">
                                    <div class="mb-[20px] px-[20px] py-[10px] flex flex-row gap-[30px] bg-black rounded-[20px] text-white">
                                        <div class="w-[10%] p-2 text-center">Liste</div>
                                        <div class="w-[20%] p-2">Numéro client</div>
                                        <div class="w-[30%] p-2">Adresse de livraison</div>
                                        <div class="w-[20%] p-2 text-center">Identifiant</div>
                                        <div class="w-[20%] p-2 text-center">Date</div>
                                    </div>
                                </div>
                                <div class="flex-1 flex flex-col relative overflow-auto">
    HTML;

    $list = getAllClients($pdo);
    
    if (!is_array($list)) {

        echo "ERROR";

    }

    //secho count($list);

    if($list > 0){
        for($i = 0; $i < count($list); $i++) {

            $j = $i+1;

            echo <<<HTML

                        <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-slate-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer onglet-btn" data-onglet="4">
                            <div class="w-[10%] p-2 flex justify-center items-center">
                                <p class="font-bold">#{$i}</p>
                            </div>
                            <div class="w-[20%] p-2">
                                <span class="text-slate-600">{$list[$i]['ville']}, Département</span>
                            </div>
                            <div class="w-[30%] p-2">
                                <p class="font-bold">{$list[$i]['nom']} {$list[$i]['prenom']}</p>
                                <p class="text-slate-600">{$list[$i]['adresse']}, {$list[$i]['code_postal']}</p>
                            </div>
                            <div class="w-[20%] p-2 text-center">
                                <span class="text-slate-600">Code : #{$list[$i]['id_client']}</span>
                            </div>
                            <div class="w-[20%] p-2 text-center">
                                <span class="text-slate-600">Code : #{$list[$i]['id_client']}</span>
                            </div>
                        </div>

            HTML;
        }
    } else {
        echo <<<HTML

                            <div class="table-cell p-5">
                                <p class="font-bold text-center">Aucun client dans la base de donnée</p>
                            </div>'
        
        HTML;
    }

    

    echo <<<HTML
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 flex overflow-hidden">
                <div class="flex-1 flex p-[20px] relative border rounded-[20px]">
                    <div class="flex-1 flex flex-col overflow-hidden">
                        <div class="flex flex-col">
                            <div class="mb-[20px] px-[20px] py-[10px] flex flex-row gap-[30px] bg-black rounded-[20px] text-white">
                                <div class="w-[10%] p-2 text-center">Liste</div>
                                <div class="w-[40%] p-2">Patronime / Adresse</div>
                                <div class="w-[30%] p-2">Ville</div>
                                <div class="w-[20%] p-2 text-center">Identifiant</div>
                            </div>
                        </div>
                        <div id="objList" class="flex-1 pb-[80px] flex flex-col relative overflow-auto">

    HTML;

    /*
    $list = getAllClients($pdo);
    
    if (!is_array($list)) {

        echo "ERROR";

    }

    //secho count($list);

    if($list > 0){
        for($i = 0; $i < count($list); $i++) {

            $j = $i+1;

            if($i == 5){
                echo <<<HTML

                            <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] bg-gray-300 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer onglet-btn" data-onglet="4">
                                <div class="w-[10%] p-2 flex justify-center items-center">
                                    <input type="checkbox" name="" id="">
                                </div>
                                <div class="w-[40%] p-2">
                                    <p class="font-bold">{$list[$i]['nom']} {$list[$i]['prenom']}</p>
                                    <p class="text-slate-600">{$list[$i]['adresse']}, {$list[$i]['code_postal']}</p>
                                </div>
                                <div class="w-[30%] p-2">
                                    <span class="text-slate-600">{$list[$i]['ville']}, Département</span>
                                </div>
                                <div class="w-[20%] p-2 text-center">
                                    <span class="text-slate-600">Code : #{$list[$i]['id_client']}</span>
                                </div>
                            </div>

                HTML;
            } else {
                echo <<<HTML

                            <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-gray-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer onglet-btn" data-onglet="4">
                                <div class="w-[10%] p-2 flex justify-center items-center">
                                    <input type="checkbox" name="" id="">
                                </div>
                                <div class="w-[40%] p-2">
                                    <p class="font-bold">{$list[$i]['nom']} {$list[$i]['prenom']}</p>
                                    <p class="text-slate-600">{$list[$i]['adresse']}, {$list[$i]['code_postal']}</p>
                                </div>
                                <div class="w-[30%] p-2">
                                    <span class="text-slate-600">{$list[$i]['ville']}, Département</span>
                                </div>
                                <div class="w-[20%] p-2 text-center">
                                    <span class="text-slate-600">Code : #{$list[$i]['id_client']}</span>
                                </div>
                            </div>

                HTML;
            }

        }
    } else {
        echo <<<HTML

                            <div class="table-cell p-5">
                                <p class="font-bold text-center">Aucun client dans la base de données</p>
                            </div>'
        
        HTML;
    }
    */

    echo <<<HTML

                        </div>
                    </div>
                    <div class="flex items-center absolute bottom-[20px] left-[50%] translate-x-[-50%] bg-cyan-950 rounded-[20px]">
                        <button class="px-[15px] py-[10px] flex justify-center items-center gap-[10px] text-white rounded-[20px] hover:bg-cyan-700 duration-300 commandBtn2"><i class="fa-solid fa-rotate-right"></i><span>Rafraichir</span></button>
                        <button class="px-[15px] py-[10px] flex justify-center items-center gap-[10px] text-white rounded-[20px] hover:bg-cyan-700 duration-300 commandBtn3"><i class="fa-solid fa-plus"></i><span>Ajouter</span></button>
                    </div>
                </div>
            </div>
            <div id="notification" class="w-full h-full absolute top-[0] left-[0] flex justify-end backdrop-blur-sm bg-gray-300/30 rounded-[20px] z-40 hidden">
                <div class="w-[500px] h-full p-[30px] flex flex-col gap-[20px] bg-cyan-950 rounded-[20px] text-white overflow-auto">
                    <span class="ml-[20px] font-bold text-[1.2em]">Notification</span>
                    <div class="p-[20px] rounded-[20px] border border-cyan-700">
                        <span class="text-slate-300">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolore sequi exercitationem sunt illo, iste rem inventore doloribus eius beatae accusamus molestias, aliquam porro minima, voluptatum placeat temporibus quam repellat soluta.</span>
                    </div>
                </div>
            </div>
        </div>

    HTML;

?>