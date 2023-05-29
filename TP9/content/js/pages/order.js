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

            // Si l'argument est true, alors écrire la liste des commandes
            if (write) writeOrderList();

            console.log('Récupération des commandes effectuée');

            // Fonction d'onglet pour la page
            commandPageFunctions();

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

                <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-gray-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer onglet-btn" data-onglet="${orderjson[i].id_commande}">
                    <p class="text-slate-600"></p>
                <div class="w-[10%] p-2 flex justify-center items-center">
                <input type="checkbox" name="" id="">
                    </div>
                    <div class="w-[20%] p-2">
                        <p class="font-bold text-center">${orderjson[i].from_client}</p>
                        <p class="text-slate-600"></p>
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