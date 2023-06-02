// Fonction pour switch entre les différentes pages
function appswitcher(appid) {

    // Si la page souhaitée est déjà sélectionnée et ouverte, arrêter la fonction
    if (appid == currentapp) return console.log(`Same app page, no switch.`);

    // Valeur actuelle qui permet de définir l'application actuelle
    currentapp = appid;
    
    // Réinitialisation de la variable qui contient l'objet actuel
    currentobject = null;

    // Tableaux pour les boutons, noms et url des pages
    const button = ['app00', 'app01', 'app02', 'app03'];
    const name = ['Dashboard', 'Clients', 'Produits', 'Commandes'];
    const url = ['content/pages/dashboard.php', 'content/pages/clients.php', 'content/pages/products.php', 'content/pages/orders.php'];

    console.log(`Switched app: ${appid}, ${button[appid]}/${name[appid]}`);

    // Change le style du bouton selectionné sur "bouton seléctionné"
    document.getElementById(button[appid]).className = "h-[40px] px-4 flex items-center gap-4 bg-neutral-800 rounded-[20px] text-[16px] text-white hover:bg-neutral-700 duration-300";
    document.getElementById(button[appid]).getElementsByTagName('span')[0].innerHTML = name[appid];

    // Boucler sur les boutons des autres boutons pour défninir leur style sur "bouton désactivé"
    for (let i=0 ; i < 4 ; i++) {

        if (appid == i) continue;

        document.getElementById(button[i]).className = "aspect-square w-[40px] flex justify-center items-center rounded-[20px] text-[16px] text-neutral-400 hover:bg-neutral-800 duration-300";
        document.getElementById(button[i]).getElementsByTagName('span')[0].innerHTML = "";

    }

    // Si le cache n'est pas vide pour la page demandée
    if (cache[appid] !== null) {

        document.getElementById('main').innerHTML = cache[appid];

        // Appeler les fonctions appropriées lors de l'appel des pages
        switch (appid) {

            // DASHBOARD
            case 0:

                break;

            // CLIENTS
            case 1:
                document.querySelector('#objList').innerHTML = listcache[appid];
                commandPageFunctions();
                addClientEvent();
                editClientEvent();
                deleteClientEvent();
                PingNotification();
                ShowNotification();
                
                break;

            // PRODUITS
            case 2:
                document.querySelector('#objList').innerHTML = listcache[appid];
                commandPageFunctions();
                addProductEvent();
                editProductEvent();
                deleteProductEvent();
                PingNotification();
                ShowNotification();

                break;
            
            // COMMANDES
            case 3:
                document.querySelector('#objList').innerHTML = listcache[appid];
                //fetchAllClients(false, true);
                writeProductSelectFromCache();
                writeClientSelectFromCache();
                commandPageFunctions();
                addOrderEvent();
                editOrderEvent();
                deleteOrderEvent();
                PingNotification();
                ShowNotification();
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
                    fetchAllClients(true, false);
                    addClientEvent();
                    editClientEvent();
                    deleteClientEvent();
                    ShowNotification();
                    break;

                // PRODUITS
                case 2:
                    fetchAllProducts(true, false);
                    addProductEvent();
                    editProductEvent();
                    deleteProductEvent();
                    //commandPageFunctions();
                    ShowNotification();

                    break;
                
                // COMMANDES
                case 3:
                    fetchAllOrders(true);
                    //fetchAllClients(false);
                    //fetchAllProducts(false);
                    // addOrderEvent();
                    // editOrderEvent();
                    // deleteOrderEvent();
                    ShowNotification();

                    break;

            }

            cache[appid] = data;

        })
        .catch(error => console.error('Erreur: ', error));

}

// Fetch dashboard.php content when the page is loaded for the first time
let initpostdata = new FormData();
initpostdata.append('user-token', usertoken);

// Fetch du dashboard quand on arrive sur la page
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


// Afficher le menu de notifications
function ShowNotification(){
    document.getElementById('notifbutton').addEventListener('click', () => {
        document.getElementById('notification').classList.toggle('hidden');
    });
}

function PingNotification(){
    if (data.content != 0) {
        document.getElementById('notifping').classList.add('hidden');
    } else {
        document.getElementById('notifping').classList.remove('hidden');
    }
}