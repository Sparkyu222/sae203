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

        <div class="w-full h-full p-[30px] flex justify-center items-center absolute top-[0] left-[0] backdrop-blur-sm bg-gray-300/30 commandLayer2 hidden z-50">
            <div class="max-w-[1200px] p-[40px] relative bg-white shadow-lg rounded-[30px]">
                <button class="aspect-square w-[40px] flex justify-center items-center absolute top-[-10px] right-[-10px] bg-red-700 rounded-full text-white text-[16px] hover:text-[20px] duration-100 commandBtn2"><i class="fa-solid fa-xmark"></i></button>
                <form action="" method="post" class="form flex flex-col gap-[30px]">
                    <h2 class="text-[28px] font-bold text-center">Ajouter un nouveau produit</h2>
                    <div class="flex flex-col gap-[20px]">
                        <div class="grid grid-cols-1 gap-[20px]">
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Libelle</label>
                                <input type="text" name="" id="label" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-[20px]">
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Code du produit/Référence</label>
                                <input type="text" name="" id="product_code" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                            <div class="flex flex-col gap-[10px]">
                                <label for="" class="ml-[15px]">Prix unitaire</label>
                                <input type="text" name="" id="price" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-[20px]">
                        <button type="reset" class="px-[20px] py-[10px] rounded-[20px]">Rénitialiser</button>
                        <button type="button" id="submit_addproduct" class="px-[20px] py-[10px] flex justify-center items-center bg-cyan-950 text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms]">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="h-full w-full flex gap-[20px] relative fade">
            <div class="flex-1 flex bg-slate-300 rounded-[20px] overflow-hidden">
                <div class="flex-1 p-[20px] flex onglet-container">
                    <div class="p-[30px] flex-1 flex flex-col justify-center items-center gap-[40px] onglet-layer fade" data-onglet="1">
                        <i class="fa-solid fa-box-open text-cyan-950 text-[6em]"></i>
                        <span class="text-[20px] text-slate-500">Pas de produit sélectionné..</span>
                    </div>
                    <div class="flex-1 flex flex-col gap-[20px] overflow-auto onglet-layer hidden fade" data-onglet="2">
                        <div class="h-full p-[20px] flex flex-col gap-[20px] bg-white rounded-[20px]">
                            <div class="w-full h-[50%] flex">
                                <img class="flex-1 flex justify-center items-center rounded-[20px] object-cover overflow-hidden" src="https://images.pexels.com/photos/5872351/pexels-photo-5872351.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
                            </div>
                            <div class="h-full flex flex-col justify-between gap-[30px] p-[20px] border rounded-[20px]">
                                <div class="flex flex-col gap-[10px]">
                                    <div class="grid grid-cols-2 gap-[20px]">
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Libelle</label>
                                            <input type="text" name="" id="formOnglet1" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Code du produit/Référence</label>
                                            <input type="text" name="" id="formOnglet2" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-[20px]">
                                        <div class="flex flex-col gap-[10px]">
                                            <label for="" class="ml-[15px]">Prix unitaire</label>
                                            <input type="text" name="" id="formOnglet3" class="w-full px-[20px] py-[10px] block bg-gray-200 rounded-[20px] border-0">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-[20px]">
                                    <button id="formOngletDelete" type="reset" class="px-[20px] py-[10px] rounded-[20px]">Supprimer</button>
                                    <button id="formOngletSubmit"  class="px-[20px] py-[10px] flex justify-center items-center bg-cyan-950 text-white rounded-[20px] hover:bg-cyan-700 duration-[300ms]">Sauvegarder</button>
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
                                <div class="w-[40%] p-2">Libelle / Code</div>
                                <div class="w-[30%] p-2 text-center">Prix unitaire</div>
                                <div class="w-[20%] p-2 text-center">Identifiant</div>
                            </div>
                        </div>
                        <div id="objList" class="flex-1 pb-[80px] flex flex-col relative overflow-auto"></div>
                    </div>
                    <div class="flex items-center absolute bottom-[20px] left-[50%] translate-x-[-50%] bg-cyan-950 rounded-[20px]">
                        <button class="px-[15px] py-[10px] flex justify-center items-center gap-[10px] text-white rounded-[20px] hover:bg-cyan-700 duration-300 commandBtn1"><i class="fa-solid fa-rotate-right"></i><span>Rafraichir</span></button>
                        <button class="px-[15px] py-[10px] flex justify-center items-center gap-[10px] text-white rounded-[20px] hover:bg-cyan-700 duration-300 commandBtn2"><i class="fa-solid fa-plus"></i><span>Ajouter</span></button>
                    </div>
                </div>
            </div>
            <div id="notification" class="w-full h-full absolute top-[0] left-[0] flex justify-end backdrop-blur-sm bg-gray-300/30 rounded-[20px] z-40 hidden">
                <div class="w-[500px] h-full p-[30px] flex flex-col gap-[20px] bg-cyan-950 rounded-[20px] text-white overflow-auto">
                    <span class="ml-[20px] font-bold text-[1.2em]">Notifications</span>
                    <div class="p-[20px] rounded-[20px] border border-cyan-700">
                        <span class="text-slate-300">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolore sequi exercitationem sunt illo, iste rem inventore doloribus eius beatae accusamus molestias, aliquam porro minima, voluptatum placeat temporibus quam repellat soluta.</span>
                    </div>
                </div>
            </div>
        </div>

    HTML;

?>