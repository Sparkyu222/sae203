// Fonction qui récupère tous les clients
function fetchAllClients(write, writeClientSelect) {

    // Status pour le return
    let status = true;

    // Réinitialisation de la requête
    ResetRequest();

    // Définition des paramètres pour la requête
    request.action = "FETCH";
    request.object = "CLIENT";
    request.content = {specific: "false"};

    // Création du formdata
    let formdata = new FormData();
    formdata.append('request', JSON.stringify(request));

    // Fetch des clients
    fetch('app/', {method: 'POST', body: formdata})
        .then(response => {

            // Si la requête HTTP n'a pas aboutie
            if (!response.ok) {

                status = false;
                throw new Error(`Erreur HTTP, status : ${response.status}`);

            }

            // Traiter la réponse comme du format JSON
            return response.json();

        })
        .then(data => {

            // Si le status de l'api n'est pas équivalente à "SUCCESS"
            if (data.status !== "SUCCESS") {

                status = false;
                throw new Error(`Une erreur s'est produite lors de la récupération des clients : ` + data.message);

            }

            // Stocker la liste de clients sous forme d'objet
            clientsjson = data.content.client;

            clientsjson.forEach(client => {

                client.orders = null;

            });

            // Si l'argument est true, alors écrire la liste des clients
            if (write) writeClientList();

            console.log('Récupération des clients effectué');

            // Fonctions d'onglet pour la page ESSENTIELodddd
            if (write) commandPageFunctions();

            if (writeClientSelect) {

                const addclientselector = document.querySelector('#add-client-selector');
            
                addclientselector.innerHTML = "";
                addclientselector.innerHTML += `<option value="" disable><-- Selectionnez un client --></option>`;
            
                clientsjson.forEach(client => {
            
                    addclientselector.innerHTML += `<option value="${client.id_client}">${client.nom} ${client.prenom}</option>`;
            
                });

            }
        })

    return status;

}

// Fonction qui écrit la liste des clients
function writeClientList() {

    // Sélectionner la balise de liste
    const list = document.querySelector('#objList');
    
    list.innerHTML = "";

    // Si le nombre de clients est supérieur à zero
    if (clientsjson.length > 0) {

        // Écrire chaque ligne dans la liste
        for (let i = 0; i < clientsjson.length; i++) {

            list.innerHTML += `

                <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-gray-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer onglet-btn" data-onglet="${i}">
                    <div class="w-[10%] p-2 flex justify-center items-center">
                        <span class="font-bold">${(i+1)}</span>
                    </div>
                    <div class="w-[40%] p-2">
                        <p class="font-bold">${clientsjson[i].nom} ${clientsjson[i].prenom}</p>
                        <p class="text-slate-600">${clientsjson[i].adresse}, ${clientsjson[i].code_postal}</p>
                    </div>
                    <div class="w-[30%] p-2">
                        <span class="text-slate-600">${clientsjson[i].ville}, ${clientsjson[i].pays}</span>
                    </div>
                    <div class="w-[20%] p-2 text-center">
                        <span class="text-slate-600">#${clientsjson[i].id_client}</span>
                    </div>
                </div>

            `;

        }

    // Si il n'y a pas de clients
    } else {

        list.innerHTML = `

            <div class="table-cell p-5">
                <p class="font-bold text-center">Aucun client dans la base de données</p>
            </div>

        `;

    }

    // Mettre la liste visuelle des clients dans le cache
    listcache[currentapp] = list.innerHTML;

}

// Add client
function addClientEvent() {

    document.querySelector('#submit_addclient').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "ADD";
        request.object = "CLIENT";
        request.content = {
            name: document.querySelector('#firstname').value,
            firstname: document.querySelector('#lastname').value,
            address: document.querySelector('#address').value,
            postal: document.querySelector('#postal').value,
            compl_address: document.querySelector('#compladdress').value,
            city: document.querySelector('#city').value,
            country: document.querySelector('#country').value
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

                fetchAllClients(true, false);
                
                console.log('Client créé.');

            })
            .catch(error => console.error(`Erreur du fetch de création : ${error}`));

    });
}

// Edit client
function editClientEvent() {

    document.querySelector('#formOngletSubmit').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "UPDATE";
        request.object = "CLIENT";
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

// Remove client
function deleteClientEvent() {

    document.querySelector('#formOngletDelete').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "DELETE";
        request.object = "CLIENT";
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

function selectClient() {

    // initialisation du form du client
    document.querySelector('#formOnglet1').value = clientsjson[currentobject].nom;
    document.querySelector('#formOnglet2').value = clientsjson[currentobject].prenom;
    document.querySelector('#formOnglet3').value = clientsjson[currentobject].adresse;
    document.querySelector('#formOnglet4').value = clientsjson[currentobject].code_postal;
    document.querySelector('#formOnglet5').value = clientsjson[currentobject].complement_adresse;
    document.querySelector('#formOnglet6').value = clientsjson[currentobject].ville;
    document.querySelector('#formOnglet7').value = clientsjson[currentobject].pays;
    

    
    // Affichage des commandes du client
    // Si il n'y a pas de commandes en cache
    if (clientsjson[currentobject].orders === null) {

        ResetRequest();

        request.action = "FETCH";
        request.object = "ORDER";
        request.content = {specific: "true", client_id: clientsjson[currentobject].id_client};

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

                clientsjson[currentobject].orders = data.content.order;

                writeClientOrders();

                console.log('Les commandes du client ont bien été récupéré.');

            })
            .catch(error => console.error(`Erreur lors de la récupération des commandes du client : ${error}`));

    // Si on a déjà fetch les commandes du client dans le passé
    } else {

        console.log('Les commandes du client ont été récupéré du cache.');
        writeClientOrders();

    }


}

function writeClientOrders() {

    // Sélection de la balise contenant la liste
    const list = document.querySelector('#listOnglet');

    // Réinitialisation de la liste
    list.innerHTML = "";

    // Si le nombre de clients est supérieur à zéro
    if (clientsjson[currentobject].orders.length > 0) {

        // Écrire chaque ligne dans la liste
        for (i = 0; i < clientsjson[currentobject].orders.length; i++) {

            list.innerHTML += `

                <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-slate-200 rounded-[20px] duration-300 last:mb-[0px]">
                    <div class="w-[10%] p-2 flex justify-center items-center">
                        <p class="font-bold">${i+1}</p>
                    </div>
                    <div class="w-[20%] p-2 text-center">
                        <span class="text-slate-600">${clientsjson[currentobject].orders[i].from_client}</span>
                    </div>
                    <div class="w-[30%] p-2">
                        <p class="text-slate-600">${clientsjson[currentobject].orders[i].adresse_livraison}</p>
                    </div>
                    <div class="w-[20%] p-2 text-center">
                        <span class="text-slate-600">${clientsjson[currentobject].orders[i].id_commande}</span>
                    </div>
                    <div class="w-[20%] p-2 text-center">
                        <span class="text-slate-600">${clientsjson[currentobject].orders[i].date}</span>
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