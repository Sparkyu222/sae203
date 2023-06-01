// Fonction qui récupère tous les clients
function fetchAllClients(write) {

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

            // Si l'argument est true, alors écrire la liste des clients
            if (write) writeClientList();

            console.log('Récupération des clients effectué');

            // Fonction d'onglet pour la page
            commandPageFunctions();
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

                <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-gray-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer onglet-btn" data-onglet="${clientsjson[i].id_client}">
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
                <p class="font-bold text-center">Aucun client dans la base de donnée</p>
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

                    // Si l'API retourne une erreur
                    throw new Error(`Erreur lors de la création du client : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.
                // Fermer le popup d'ajout de client
                document.querySelector('.commandLayer3').classList.toggle('hidden');

                fetchAllClients(true);
                
                console.log('Client créé.');

            })
            .catch(error => console.error(`Erreur du fetch de création`));

    });
}

// Edit client
function editClientEvent() {

    document.querySelector('#submit_addclient').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "UPDATE";
        request.object = "CLIENT";
        request.content = {
            //client_id: À MODIFIER
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

                    // Si l'API retourne une erreur
                    throw new Error(`Erreur lors de l'édition des informations du client : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.
                // Fermer le popup d'edition du client


            })
            .catch(error => console.error(`Erreur du fetch d'update`))

    });
}

// Remove client
function deleteClientEvent() {

    document.querySelector('#submit_addclient').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "DELETE";
        request.object = "CLIENT";
        request.content = {
            //client_id: À MODIFIER [TABLEAU]
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
                // Fermer le popup d'edition du client


            })
            .catch(error => console.error(`Erreur du fetch de deletion`))

    });
}