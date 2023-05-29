// Function to switch between client app tabs
function ClientPageFunctions() {

    // Select all tab buttons and tab layers
    const ongletBtn = document.querySelectorAll('.onglet-btn'),
    ongletLayout = document.querySelectorAll('.onglet-layer');

    let index = 0;

    // Onglet switch system
    // Add click event listener to each tab button
    ongletBtn.forEach((onglet) => {
        onglet.addEventListener('click', () => {
            ongletSelector(onglet.getAttribute('data-onglet'));
        })
    })

    // Function to switch between tabs
    function ongletSelector(index) {
        console.log('on tente de changer donglet');
        
        // Loop through all tab buttons
        ongletBtn.forEach((onglet) => {
            console.log(index);
            
            // if(onglet.classList.contains('a-onglet')){
            //     return;
            // } else {
            //     onglet.classList.add('a-onglet');
            // }

            // for(i = 0; i < ongletBtn.length; i++) {
            //     if(ongletBtn[i].getAttribute('data-onglet') !== index){
            //         ongletBtn[i].classList.remove('a-onglet');
            //     }
            // }

            for(j = 0; j < ongletLayout.length; j++) {
                if (ongletLayout[j].getAttribute('data-onglet') == index) {
                    ongletLayout[j].classList.remove('hidden');
                } else {
                    ongletLayout[j].classList.add('hidden');
                }
            }

            console.log('on quitte la gentille fonction');
        });
    }

}

// Fonction pour switch entre les différentes pages
function appswitcher(appid) {

    // Si la page souhaitée est déjà sélectionnée et ouverte, arrêter la fonction
    if (appid == currentapp) return console.log(`Same app page, no switch.`);

    // Valeur actuelle qui permet de définir l'application actuelle
    currentapp = appid;

    // Tableaux pour les boutons, noms et url des pages
    const button = ['app00', 'app01', 'app02', 'app03'];
    const name = ['Dashboard', 'Clients', 'Produits', 'Commandes'];
    const url = ['content/pages/dashboard.php', 'content/pages/clients.php', 'content/pages/products.php', 'content/pages/orders.php'];

    console.log(`Switched app: ${appid}, ${button[appid]}/${name[appid]}`);

    // Change le style du bouton selectionné sur "bouton seléctionné"
    document.getElementById(button[appid]).className = "h-[40px] px-4 flex items-center gap-4 bg-neutral-800 rounded-[20px] text-[16px] text-white hover:bg-neutral-700";
    document.getElementById(button[appid]).getElementsByTagName('span')[0].innerHTML = name[appid];

    // Boucler sur les boutons des autres boutons pour défninir leur style sur "bouton désactivé"
    for (let i=0 ; i < 4 ; i++) {

        if (appid == i) continue;

        document.getElementById(button[i]).className = "aspect-square w-[40px] flex justify-center items-center rounded-[20px] text-[16px] text-neutral-400 hover:bg-neutral-800";
        document.getElementById(button[i]).getElementsByTagName('span')[0].innerHTML = "";

    }

    if (cache[appid] !== null) {

        document.getElementById('main').innerHTML = cache[appid];

        // Appeler les fonctions appropriées lors de l'appel des pages
        switch (appid) {

            // DASHBOARD
            case 0:

                break;

            // CLIENTS
            case 1:
                ClientPageFunctions();
                break;

            // PRODUITS
            case 2:

                break;
            
            // COMMANDES
            case 3:

                break;

        }
        
        return console.log('Switched from cache');
            
    }

    // Créer une réponse de formulaire pour la requête, il contiendra le token de l'utilisateur pour pouvoir obtenir la page distante
    let postdata = new FormData();
    postdata.append('user-token', usertoken);

    // Fetch de la page distante en utilisant l'url de la page demandée
    fetch (url[appid], {method: 'POST', body: postdata})
        .then(response => {

            if (!response.ok) {

                throw new Error(`Erreur HTTP, status : ${response.status}`);

            }

            return response.text();

        })
        .then(data => {

            // Remplacer le contenu de la div main par le contenu de la page désirée
            document.getElementById('main').innerHTML = data;

            // Appeler les fonctions appropriées lors de l'appel des pages
            switch (appid) {

                // DASHBOARD
                case 0:

                    break;

                // CLIENTS
                case 1:
                    ClientPageFunctions();
                    break;

                // PRODUITS
                case 2:

                    break;
                
                // COMMANDES
                case 3:

                    break;

            }

            cache[appid] = data;

        })
        .catch(error => console.error('Erreur: ', error));

}

// Fetch dashboard.php content when the page is loaded for the first time
let initpostdata = new FormData();
initpostdata.append('user-token', usertoken);

fetch ('content/pages/dashboard.php', {method: 'POST', body: initpostdata})
    .then(response => {

        if (!response.ok) {

            throw new Error(`Erreur HTTP, status : ${response.status}`);

        }

        return response.text();

    })
    .then(data => {

        // Replace the main content with the dashboard.php content
        document.getElementById('main').innerHTML = data;

    })
    .catch(error => console.error('Erreur: ', error));
