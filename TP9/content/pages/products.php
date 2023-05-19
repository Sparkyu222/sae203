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

        <div class="h-full w-full flex gap-[20px]">
            <div class="flex-1 bg-cyan-100 overflow-auto">
            
            </div>
            <div class="flex-1 overflow-auto">
            <div class="flex flex-col">
                <div class="mb-[20px] px-[20px] py-[10px] flex flex-row gap-[30px] bg-black rounded-[20px] text-white">
                    <div class="w-[10%] p-2 text-center">Liste</div>
                    <div class="w-[40%] p-2">Patronime / Adresse</div>
                    <div class="w-[30%] p-2">Ville</div>
                    <div class="w-[20%] p-2 text-center">Identifiant</div>
                </div>
    HTML;

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

                        <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] bg-gray-300 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer">
                            <div class="w-[10%] p-2 text-center">
                                <p class="font-bold">#{$j}</p>
                            </div>
                            <div class="w-[40%] p-2">
                                <p class="font-bold">{$list[$i]['nom']} {$list[$i]['prenom']}</p>
                                <p class="text-slate-500">{$list[$i]['adresse']}, {$list[$i]['code_postal']}</p>
                            </div>
                            <div class="w-[30%] p-2">
                                <span class="text-slate-500">{$list[$i]['ville']}, Département</span>
                            </div>
                            <div class="w-[20%] p-2 text-center">
                                <span class="text-slate-500">Code : #{$list[$i]['id_client']}</span>
                            </div>
                        </div>

                HTML;
            } else {
                echo <<<HTML

                        <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-gray-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer">
                            <div class="w-[10%] p-2 text-center">
                                <p class="font-bold">#{$j}</p>
                            </div>
                            <div class="w-[40%] p-2">
                                <p class="font-bold">{$list[$i]['nom']} {$list[$i]['prenom']}</p>
                                <p class="text-slate-500">{$list[$i]['adresse']}, {$list[$i]['code_postal']}</p>
                            </div>
                            <div class="w-[30%] p-2">
                                <span class="text-slate-500">{$list[$i]['ville']}, Département</span>
                            </div>
                            <div class="w-[20%] p-2 text-center">
                                <span class="text-slate-500">Code : #{$list[$i]['id_client']}</span>
                            </div>
                        </div>

                HTML;
            }

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

    HTML;

?>