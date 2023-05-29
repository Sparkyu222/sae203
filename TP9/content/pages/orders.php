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
                    <h2 class="text-[28px] font-bold text-center">Ajouter une nouvelle commande</h2>
                    <div class="flex flex-col gap-[20px]">
                        <div class="grid grid-cols-3 gap-[20px]">
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Client</label>
                                <select name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-[10px] col-span-2">
                                <label for="" class="ml-[15px]">Adresse</label>
                                <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                        </div>
                        <div class="grid grid-cols-6 gap-[20px]">
                            <div class="flex flex-col gap-[10px] col-span-3">
                                <label for="" class="ml-[15px]">Produit</label>
                                <select name="" id="client-selector" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                    <option value="" disable><-- Selectionnez un client --></option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-[10px] col-span-2">
                                <label for="" class="ml-[15px]">Quantité</label>
                                <input type="number" name="" id="" min="1" max="10" value="1" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                            <div class="flex flex-col justify-end gap-[10px]">
                                <button class="px-[20px] py-[10px] flex justify-center items-center bg-cyan-950 text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms]">Lister</button>
                            </div>
                        </div>
                        <div class="p-[20px] flex flex-col gap-[10px] border rounded-[20px]">
                            <div class="flex justify-between items-center gap-[10px]">
                                <p>Pas de produit ajouté</p>
                                <button>Supprimer</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-[20px]">
                        <button type="reset" class="px-[20px] py-[10px] rounded-[20px]">Rénitialiser</button>
                        <button class="px-[20px] py-[10px] flex justify-center items-center bg-cyan-950 text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms]">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="h-full w-full flex gap-[20px]">
            <div class="flex-1 flex bg-slate-300 rounded-[20px] overflow-hidden">
                <div class="flex-1 p-[20px] flex onglet-container">
                    <div class="p-[30px] flex-1 flex flex-col justify-center items-center gap-[40px] onglet-layer" data-onglet="1">
                        <i class="fa-solid fa-truck text-cyan-950 text-[6em]"></i>
                        <span class="text-[20px] text-slate-500">Pas de commande sélectionnée..</span>
                    </div>
                    <div class="flex-1 flex flex-col gap-[20px] overflow-auto onglet-layer hidden" data-onglet="2">
                        <div class="p-[20px] flex gap-[20px] bg-white rounded-[20px]">
                            <div class="w-[30%] flex">
                                <img class="flex-1 flex justify-center items-center rounded-[20px] object-cover overflow-hidden" src="https://images.pexels.com/photos/2599869/pexels-photo-2599869.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
                            </div>
                            <form action="" method="post" class="w-[70%] form flex flex-col gap-[30px]">
                                <h2 class="text-[28px] font-bold text-center">Ajouter une nouvelle commande</h2>
                                <div class="flex flex-col gap-[20px]">
                                    <div class="grid grid-cols-3 gap-[20px]">
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Client</label>
                                            <select name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col gap-[10px] col-span-2">
                                            <label for="" class="ml-[15px]">Adresse</label>
                                            <input type="text" name="" id="" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-[20px]">
                                        <div class="flex flex-col gap-[10px] col-span-3">
                                            <label for="" class="ml-[15px]">Produit</label>
                                            <select name="" id="client-selector" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                                <option value="" disable><-- Selectionnez un client --></option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col gap-[10px] col-span-2">
                                            <label for="" class="ml-[15px]">Quantité</label>
                                            <input type="number" name="" id="" min="1" max="10" value="1" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                        <div class="flex flex-col justify-end gap-[10px]">
                                            <button class="px-[20px] py-[10px] flex justify-center items-center bg-cyan-950 text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms]">Lister</button>
                                        </div>
                                    </div>
                                    <div class="p-[20px] flex flex-col gap-[10px] border rounded-[20px]">
                                        <div class="flex justify-between items-center gap-[10px]">
                                            <p>Pas de produit ajouté</p>
                                            <button>Supprimer</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-[20px]">
                                    <button type="reset" class="px-[20px] py-[10px] rounded-[20px]">Rénitialiser</button>
                                    <button class="px-[20px] py-[10px] flex justify-center items-center bg-cyan-950 text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms]">Ajouter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 flex overflow-hidden">
                <div class="flex-1 flex p-[20px] relative border rounded-[20px]">
                    <div class="flex-1 flex flex-col overflow-hidden">
                        <div class="flex flex-col">
                            <div class="mb-[20px] px-[20px] py-[10px] flex flex-row gap-[30px] bg-black rounded-[20px] text-white">
                                <div class="w-[10%] p-2 text-center">Sélecteur</div>
                                <div class="w-[20%] p-2 text-center">Numéro client</div>
                                <div class="w-[30%] p-2">Adresse de livraison</div>
                                <div class="w-[20%] p-2 text-center">Identifiant</div>
                                <div class="w-[20%] p-2 text-center">Date</div>
                            </div>
                        </div>
                        <div id="objList" class="flex-1 pb-[80px] flex flex-col relative overflow-auto"></div>
                    </div>
                    <div class="px-[20px] flex items-center gap-[15px] absolute bottom-[20px] left-[50%] translate-x-[-50%] bg-cyan-950 rounded-[20px] opacity-80 hover:opacity-100 duration-300">
                        <div class="flex items-center rounded-[20px] hover:bg-cyan-800">
                            <span class="px-[15px] py-[10px] text-white whitespace-nowrap">20 sélectionnés</span>
                            <button class="px-[15px] py-[10px] flex justify-center items-center gap-[10px] text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms] commandBtn1"><i class="fa-regular fa-trash-can"></i><span>Supprimer</span></button>
                        </div>
                        <button class="px-[15px] py-[10px] flex justify-center items-center gap-[10px] text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms] commandBtn2"><i class="fa-solid fa-rotate-right"></i><span>Rafraichir</span></button>
                        <button class="px-[15px] py-[10px] flex justify-center items-center gap-[10px] text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms] commandBtn3"><i class="fa-solid fa-plus"></i><span>Ajouter</span></button>
                    </div>
                </div>
            </div>
        </div>

    HTML;

?>