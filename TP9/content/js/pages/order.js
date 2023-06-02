// Function qui récupère toutes les commandes
function fetchAllOrders(write) {

    // Status pour le return
    let status = true;

    // On réinitialise le json de la requête
    ResetRequest();

    // Définition des paramètres de la requête
    request.action = "FETCH";
    request.object = "ORDER";
    request.content = {specific: "false"}

    // Création du formdata
    let formdata = new FormData();
    formdata.append('request', JSON.stringify(request));

    // Fetch des commandes
    fetch('app/', {method: 'POST', body: formdata})
        .then(response => {

            // Si la requête HTTP s'est mal passée
            if (!response.ok) {

                status = false;
                throw new Error(`Erreur HTTP, status : ${response.status}`);

            }

            // Interpréter les données comme du JSON
            return response.json();

        })
        .then(data => {

            // Si le status de l'api n'est pas équivalente à "SUCCESS"
            if (data.status !== "SUCCESS") {

                status = false;
                throw new Error(`Une erreur s'est produite lors de la récupération des commandes : ` + data.message);

            }

            // Stocker les commandes dans l'objet de cache de commandes
            orderjson = data.content.order;

            orderjson.forEach(order => {

                order.items = null;

            });

            console.log('Récupération des commandes effectuées');

            if (write) {

                // Si l'argument est true, alors écrire la liste des commandes
                writeOrderList();
                // Fonction d'onglet pour la page
                commandPageFunctions();
                // Récupérer tous les produits
                fetchAllProducts(false, true);
                fetchAllClients(false, true);

            }

        })
        .catch(error => console.log('Erreur : ', error));

    return status;

}

// Fonction qui écrit la liste des commandes
function writeOrderList() {

    // Sélection de la balise
    const list = document.querySelector('#objList');
    // On efface le contenu de la div
    list.innerHTML = "";

    // Si le nombre de commande est supérieur à zero
    if (orderjson.length > 0) {

        // Écrire chaque ligne dans la div
        for(let i = 0; i < orderjson.length ; i++) {
            list.innerHTML += `

                <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-gray-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer onglet-btn" data-onglet="${i}">
                    <div class="w-[10%] p-2 flex justify-center items-center">
                        <span class="font-bold">${(i+1)}</span>
                    </div>
                    <div class="w-[20%] p-2">
                        <p class="text-center">${orderjson[i].from_client}</p>
                    </div>
                    <div class="w-[30%] p-2">
                        <span class="text-slate-600">${orderjson[i].adresse_livraison}</span>
                    </div>
                    <div class="w-[20%] p-2 text-center">
                        <span class="text-slate-600">#${orderjson[i].id_commande}</span>
                    </div>
                    <div class="w-[20%] p-2 text-center">
                        <span class="text-slate-600">${orderjson[i].date}</span>
                    </div>
                </div>

            `;
        }

    // Si il n'y a pas de commandes
    } else {

        list.innerHTML += `

            <div class="table-cell p-5">
                <p class="font-bold text-center">Aucun client dans la base de données</p>
            </div>

        `;

    }
    
    // Mettre la liste visuelle des commandes en cache
    listcache[currentapp] = list.innerHTML;

}

function addOrderEvent() {
    document.querySelector('#submit_addOrder').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "ADD";
        request.object = "ORDER";
        request.content = {
            client_id: document.querySelector('#add-client-selector').value,
            address: document.querySelector('#add-adresse-selector').value,
            postal: document.querySelector('#add-product-selector').value
        };

        let formdata = new FormData();
        formdata.append('request', JSON.stringify(request));

        fetch('app/', {method: 'POST', body: formdata})
            .then(response => {

                if (!response.ok) {

                    // Si la requête n'a pas aboutie
                    throw new Error(`Erreur lors de la requête vers l'api : ${response.status}`);

                }

                return response.json();

            })
            .then(data => {

                if (data.status !== "SUCCESS") {

                    // Si l'API retourne une erreur${error}
                    throw new Error(`Erreur lors de la création du client : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.
                // Fermer le popup d'ajout de client
                document.querySelector('.commandLayer2').classList.toggle('hidden');

                fetchAllOrders(true, false);
                
                console.log('Client créé.');

            })
            .catch(error => console.error(`Erreur du fetch de création : ${error}`));

    });
}

function editOrderEvent() {
    document.querySelector('#formOngletSubmit').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "UPDATE";
        request.object = "ORDER";
        request.content = {
            client_id: clientsjson[currentobject].id_client,
            name: document.querySelector('#formOnglet1').value,
            firstname: document.querySelector('#formOnglet2').value,
            address: document.querySelector('#formOnglet3').value,
            postal: document.querySelector('#formOnglet4').value,
            compl_address: document.querySelector('#formOnglet5').value,
            city: document.querySelector('#formOnglet6').value,
            country: document.querySelector('#formOnglet7').value
        };

        let formdata = new FormData();

        formdata.append('request', JSON.stringify(request));

        fetch('app/', {method: 'POST', body: formdata})
            .then(response => {

                if (!response.ok) {

                    // Si la requête n'a pas aboutie
                    throw new Error(`Erreur lors de la requête vers l'api : ${response.status}`);

                }

                return response.json();

            })
            .then(data => {

                if (data.status !== "SUCCESS") {

                    // Si l'API retourne une erreur
                    throw new Error(`Erreur lors de l'édition des informations du client : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.
                // Fermer le popup d'edition du client

                console.log('Client modifié');
                fetchAllClients(true, false);

            })
            .catch(error => console.error(`Erreur du fetch d'update : ${error}`));

    });
}

function deleteOrderEvent() {
    document.querySelector('#formOngletDelete').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "DELETE";
        request.object = "ORDER";
        request.content = {
            client: [{client_id: clientsjson[currentobject].id_client}]
        };

        let formdata = new FormData();

        formdata.append('request', JSON.stringify(request));

        fetch('app/', {method: 'POST', body: formdata})
            .then(response => {

                if (!response.ok) {

                    // Si la requête n'a pas aboutie
                    throw new Error(`Erreur lors de la requête vers l'api : ${response.status}`);

                }

                return response.json();

            })
            .then(data => {

                if (data.status !== "SUCCESS") {

                    // Si l'API retourne une erreur
                    throw new Error(`Erreur lors de l'effacement du client : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.

                console.log('Client supprimé');
                fetchAllClients(true, false);

                // Reset page

                currentobject = null;

                const
                    ongletBtn = document.querySelectorAll('.onglet-btn'),
                    ongletLayout = document.querySelectorAll('.onglet-layer');

                for(i = 0; i < ongletBtn.length; i++) {
                    ongletBtn[i].classList.remove('bg-gray-300');
                    ongletBtn[i].classList.add('hover:bg-gray-200');
                }
    
                for(j = 0; j < ongletLayout.length; j++) {
                    if (ongletLayout[j].getAttribute('data-onglet') == 1) {
                        ongletLayout[j].classList.remove('hidden');
                    } else {
                        ongletLayout[j].classList.add('hidden');
                    }
                }

            })
            .catch(error => console.error(`Erreur du fetch de deletion : ${error}`));

    });
}

function selectOrder () {

    document.querySelector('#adresse-selector').value = orderjson[currentobject].adresse_livraison;
    
    // Affichage des commandes du client
    // Si il n'y a pas de commandes en cache
    if (orderjson[currentobject].items === null) {

        ResetRequest();

        request.action = "FETCH";
        request.object = "ITEM";
        request.content = {order_id: orderjson[currentobject].id_commande};

        console.log(JSON.stringify(request));

        let formdata = new FormData();
        formdata.append('request', JSON.stringify(request));

        fetch('app/', {method: 'POST', body: formdata})
            .then(response => {

                if (!response.ok) {

                    throw new Error(`Erreur lors de l'envoie de la requête : ${response.status}`);

                }

                return response.json();

            })
            .then(data => {

                if (data.status !== "SUCCESS") {

                    throw new Error((`Erreur lors de la récupération des commandes du client : ${data.message}`));

                }

                orderjson[currentobject].items = data.content.item;

                writeContentOrder();

                console.log('Les commandes du client ont bien été récupéré.');

            })
            .catch(error => console.error(`Erreur lors de la récupération des commandes du client : ${error}`));

    // Si on a déjà fetch les commandes du client dans le passé
    } else {

        console.log('Le contenue de la commande a été récupéré du cache.');
        writeContentOrder();
    }
}

function writeContentOrder() {

    // Sélection de la balise contenant la liste
    const list = document.querySelector('#listOnglet');

    // Réinitialisation de la liste
    list.innerHTML = "";

    // Si le nombre de clients est supérieur à zéro
    if (orderjson[currentobject].items.length > 0) {

        // Écrire chaque ligne dans la liste
        for (i = 0; i < orderjson[currentobject].items.length; i++) {

            list.innerHTML += `

                <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-slate-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer">
                    <div class="w-[20%] p-2 flex justify-center items-center">
                        <p class="font-bold">${i+1}</p>
                    </div>
                    <div class="w-[30%] p-2 text-center">
                        <span class="text-slate-600">${orderjson[currentobject].items[i].num_produit}</span>
                    </div>
                    <div class="w-[30%] p-2 text-center">
                        <p class="text-slate-600">${orderjson[currentobject].items[i].quantite}</p>
                    </div>
                    <div class="w-[20%] p-2 text-center">
                        <button>Supprimer</button>
                    </div>
                </div>

            `;

        }

    // Si il n'y a pas de clients
    } else {

        list.innerHTML = `

            <div class="table-cell p-5">
                <p class="font-bold text-center">Aucune commande n'a été réalisé par ce client</p>
            </div>

        `;

    }

}

function writeProductSelectFromCache() {

    const 
    productselector = document.querySelector('#product-selector'),
    addproductselector = document.querySelector('#add-product-selector');

    productselector.innerHTML = "";
    productselector.innerHTML += `<option value="" disable><-- Selectionnez un produit --></option>`;

    addproductselector.innerHTML = "";
    addproductselector.innerHTML += `<option value="" disable><-- Selectionnez un produit --></option>`;

    // Écrire la liste des produits dans le select
    productjson.forEach(product => {
        productselector.innerHTML += `<option value="${product.id_produit}">${product.libelle}</option>`;
        addproductselector.innerHTML += `<option value="${product.id_produit}">${product.libelle}</option>`;
});

}

function writeClientSelectFromCache() {

    const 
        clientselector = document.querySelector('#client-selector'),
        addclientselector = document.querySelector('#add-client-selector');

    clientselector.innerHTML = "";
    clientselector.innerHTML += `<option value="" disable><-- Selectionnez un client --></option>`;
    
    clientsjson.forEach(client => {

        if(orderjson[currentobject].from_client == client.id_client) {
            clientselector.innerHTML += `<option value="${client.id_client}" selected>${client.nom} ${client.prenom}</option>`;
        } else {
            clientselector.innerHTML += `<option value="${client.id_client}">${client.nom} ${client.prenom}</option>`;
        }

    });

    addclientselector.innerHTML = "";
    addclientselector.innerHTML += `<option value="" disable><-- Selectionnez un client --></option>`;

    clientsjson.forEach(client => {

        addclientselector.innerHTML += `<option value="${client.id_client}">${client.nom} ${client.prenom}</option>`;

    });

}