<?php 

    include('../include/connectDB.php');
    include('../include/flogin.php');
    include('../include/getfromdb.php');

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
            <div class="flex-1 bg-red-600 overflow-auto">
            
            </div>
            <div class="flex-1 overflow-auto">
                <div class="table w-full">
                    <div class="table-header-group sticky top-0 text-white">
                        <div class="table-row mb-[20px]">
                            <div class="table-cell pl-5 py-5 bg-black rounded-[20px_0_0_20px]">Liste</div>
                            <div class="table-cell py-5 bg-black">Patronime / Adresse</div>
                            <div class="table-cell py-5 bg-black">Ville</div>
                            <div class="table-cell pr-5 py-5 bg-black rounded-[0_20px_20px_0]">Identifiant</div>
                        </div>
                    </div>
                    <div class="table-row-group">
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

                        <div class="table-row">
                            <div class="table-cell pl-5 py-2">
                                <p class="font-bold">#{$j}</p>
                            </div>
                            <div class="table-cell py-5">
                                <p class="font-bold">{$list[$i]['nom']} {$list[$i]['prenom']}</p>
                                <p class="text-slate-500">{$list[$i]['adresse']}, {$list[$i]['code_postal']}</p>
                            </div>
                            <div class="table-cell py-5">
                                <span class="text-slate-500">{$list[$i]['ville']}, Département</span>
                            </div>
                            <div class="table-cell pr-5 py-2">
                                <span class="text-slate-500">Code : #{$list[$i]['id_client']}</span>
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

    HTML;

?>