<?php

    echo <<<HTML

        <form method="POST">

            <div class="w-full p-5 bg-cyan-950 rounded-[20px]">
                <img class="w-full" src="content/img/iut.png" alt="Logo de notre magasin">
            </div>

            <!-- <div class="">
                <p class="my-8 text-lg font-bold text-center">Veuillez vous identifier pour accéder au panel de gestion</p>
            </div> -->

            <div>

                <div class="mt-10">
                    <label for="login" class="ml-5 font-semibold">Adresse e-mail</label>
                    <input type="mail" name="login-mail" id="" class="w-full mt-2 px-4 py-3 rounded-[20px] border border-slate-300" placeholder="exemple@rt-iut.re">
                </div>
                <div class="mt-5">
                    <label for="login" class="ml-5 font-semibold">Mot de passe</label>
                    <input type="password" name="login-password" id="" class="w-full mt-2 px-4 py-3 rounded-[20px] border border-slate-300" placeholder="Guegan1234">
                </div>


                    

    HTML;

    if (isset($_POST['submit'])) {
        
        echo <<<HTML

            <!-- Si les identifiants sont incorrects ou l'un des deux input est vide -->
            <div class="flex items-center gap-2 font-semibold text-red-500 pt-5">
                <svg width="21px" class="" height="21px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <title/>
                    <g id="Complete">
                    <g id="alert-circle">
                    <g>
                    <line fill="none" stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="8" y2="12"/>
                    <line fill="none" stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="16" y2="16"/>
                    <circle cx="12" cy="12" data-name="--Circle" fill="none" id="_--Circle" r="10" stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </g>
                    </g>
                    </g>
                </svg>
        
        HTML;

        if (isset($_POST['login-mail']) && isset($_POST['login-password'])) {

            if ($_POST['login-mail'] == "" || $_POST['login-password'] == "") {

                echo <<<HTML
                    
                    <p>Vous devez renseigner tous les champs</p>

                HTML;

            } else {

                echo <<<HTML
                
                    <p>Identifiants de connexion incorrect</p>

                HTML;

            }

        }

        echo "</div>";

    }

    echo <<<HTML

                <div>
                    <button type="submit" name="submit" class="w-full mt-8 px-4 py-4 rounded-[20px] bg-black text-white">Connexion</button>
                </div>

            </div>

        </form>

    HTML;

?>