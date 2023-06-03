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
        };

        console.log(document.querySelector('#add-client-selector').value);

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

                fetchAllOrders(true);
                
                console.log('Commande créée.');

            })
            .catch(error => console.error(`Erreur du fetch de création : ${error}`));

    });
}

function addItemToOrderListEvent () {

    // Edition du contenue d'une commande: Ajouter des produits
    document.querySelector('#listEditOrder').addEventListener('click', () => {

        // Sélecteur pour la liste
        const list = document.querySelector('#tableListEditOrder');

        // Variable qui contient le sélecteur et dernière variable qui dit si il faut push ou pas le produit dans l'objet
        let
            productid = document.querySelector('#edit-product-selector').value,
            valuequantity = document.querySelector('#edit-quantity-selector').value;
            nopush = false;

        // Si on sélectionne "<-- Sélectionnez un produit -->", on n'ajoute rien à la liste
        if (productid == -1 || valuequantity === "") return false;

        for (let i=0; i < orderjson[currentobject].items.length ; i++) {

            if (orderjson[currentobject].items[i].num_produit === productid) {
            
                return false;
                break;

            }
            
        }

        // Boucle qui vérifie si l'id donné par le select est déjà présent dans la liste
        for (let i=0; i < currentEditItemAddList.item.length; i++) {

            // Si on a trouvé un cas similaire
            if (productid === currentEditItemAddList.item[i].product_id) {
                
                // Si le cas est similaire et que la quantité est aussi identique, alors ne rien toucher dans la liste
                if (currentEditItemAddList.item[i].quantity === valuequantity) return false;

                // Si l'id est similaire mais que la quantité n'est pas identique, seulement modifier la quantité et ré-imprimmer la liste sans push un nouveau tableau
                currentEditItemAddList.item[i].quantity = valuequantity;
                nopush = true;
                break;

            };

        }
        
        // Push un nouvel élément dans le tableau "item"
        if (!nopush) currentEditItemAddList.item.push({order_id: orderjson[currentobject].id_commande, product_id: productid, quantity: valuequantity});

        // Réinitialiser la liste
        list.innerHTML = "";

        // Imprimmer la liste
        for(let i = 0; i < currentEditItemAddList.item.length; i++) {

            let productname = "";
            
            // Rechercher le nom du produit
            for (let j=0; j < productjson.length; j++) {

                if (currentEditItemAddList.item[i].product_id === productjson[j].id_produit) {

                    productname = productjson[j].libelle;
                    break;

                }

            }

            list.innerHTML += `
                <div class="flex justify-between items-center gap-[10px]">
                    <span>${currentEditItemAddList.item[i].quantity}</span>
                    <span>${productname}</span>
                    <button type="button" class="delListEditOrder" data-index=${i}>Supprimer</button>
                </div>
            `;

        }

        delLineFromEditItem();

    });
    
    /*
    document.querySelector('#listAddOrder').addEventListener('click', () => {

        const list = document.querySelector('#tableListAddOrder');

        let
            productid = document.querySelector('#add-product-selector').value,
            valuequantity = document.querySelector('#add-quantity-selector').value;
            nopush = false;
        
        // Si on sélectionne "<-- Sélectionnez un produit -->", on n'ajoute rien à la liste
        if (productid == -1 || valuequantity === "") return false;

        // Boucle qui vérifie si l'id donné par le select est déjà présent dans la liste
        for (let i=0; i < currentAddItemAddList.item.length; i++) {

            // Si on a trouvé un cas similaire
            if (productid === currentAddItemAddList.item[i].product_id) {
                
                // Si le cas est similaire et que la quantité est aussi identique, alors ne rien toucher dans la liste
                if (currentAddItemAddList.item[i].quantity === valuequantity) return false;

                // Si l'id est similaire mais que la quantité n'est pas identique, seulement modifier la quantité et ré-imprimmer la liste sans push un nouveau tableau
                currentAddItemAddList.item[i].quantity = valuequantity;
                nopush = true;
                break;

            };

        }
        
        // Push un nouvel élément dans le tableau "item"
        if (!nopush) currentAddItemAddList.item.push({product_id: productid, quantity: valuequantity});

        // Réinitialiser la liste
        list.innerHTML = "";

        // Imprimmer la liste
        for(let i = 0; i < currentAddItemAddList.item.length; i++) {

            let productname = "";
            
            // Rechercher le nom du produit
            for (let j=0; j < productjson.length; j++) {

                if (currentAddItemAddList.item[i].product_id === productjson[j].id_produit) {

                    productname = productjson[j].libelle;
                    break;

                }

            }

            list.innerHTML += `
                <div class="flex justify-between items-center gap-[10px]">
                    <span>${currentAddItemAddList.item[i].quantity}</span>
                    <span>${productname}</span>
                    <button type="button" class="delListAddOrder" data-index=${i}>Supprimer</button>
                </div>
            `;
        }

        delLineFromAddItem();
        
    });*/

}

function delLineFromEditItem() {

    // Initiation des addEventListener sur les boutons de suppression des lignes
    document.querySelectorAll('.delListEditOrder').forEach((btn) => {
        btn.addEventListener('click', () => {
            
            // Sélecteur pour la liste
            const list = document.querySelector('#tableListEditOrder');
            let index = btn.getAttribute('data-index');

            if (currentEditItemAddList.item.length === 1) {

                currentEditItemAddList.item = [];

                list.innerHTML = `
                <div class="flex-1 flex justify-center items-center gap-[10px]">
                    <span>Pas de produit listé</span>
                </div>
                `;

                return true;

            }

            currentEditItemAddList.item.splice(index, 1);

            // Réinitialiser la liste
            list.innerHTML = "";
            
            if (currentEditItemAddList.item.length > 0) {
                
                for(let i = 0; i < currentEditItemAddList.item.length; i++) {

                    let productname = "";
                    
                    // Rechercher le nom du produit
                    for (let j=0; j < productjson.length; j++) {
        
                        if (currentEditItemAddList.item[i].product_id === productjson[j].id_produit) {
        
                            productname = productjson[j].libelle;
                            break;
        
                        }
        
                    }
        
                    list.innerHTML += `
                        <div class="flex justify-between items-center gap-[10px]">
                            <span>${currentEditItemAddList.item[i].quantity}</span>
                            <span>${productname}</span>
                            <button type="button" class="delListEditOrder" data-index=${i}>Supprimer</button>
                        </div>
                    `;
                }

            } else {

                list.innerHTML = `
                    <div class="flex-1 flex justify-center items-center gap-[10px]">
                        <span>Pas de produit listé</span>
                    </div>
                `;

            }
            
            delLineFromEditItem();

        });

    });

}


function delLineFromAddItem () {

    // Initiation des addEventListener sur les boutons de suppression des lignes
    document.querySelectorAll('.delListAddOrder').forEach((btn) => {
        btn.addEventListener('click', () => {
            
            // Sélecteur pour la liste
            const list = document.querySelector('#tableListAddOrder');
            let index = btn.getAttribute('data-index');

            if (currentAddItemAddList.item.length === 1) {

                currentAddItemAddList.item = [];

                list.innerHTML = `
                <div class="flex-1 flex justify-center items-center gap-[10px]">
                    <span>Pas de produit listé</span>
                </div>
                `;

                return true;

            }

            currentAddItemAddList.item.splice(index, 1);

            // Réinitialiser la liste
            list.innerHTML = "";
            
            if (currentAddItemAddList.item.length > 0) {
                
                for(let i = 0; i < currentAddItemAddList.item.length; i++) {

                    let productname = "";
                    
                    // Rechercher le nom du produit
                    for (let j=0; j < productjson.length; j++) {
        
                        if (currentAddItemAddList.item[i].product_id === productjson[j].id_produit) {
        
                            productname = productjson[j].libelle;
                            break;
        
                        }
        
                    }
        
                    list.innerHTML += `
                        <div class="flex justify-between items-center gap-[10px]">
                            <span>${currentAddItemAddList.item[i].quantity}</span>
                            <span>${productname}</span>
                            <button type="button" class="delListAddOrder" data-index=${i}>Supprimer</button>
                        </div>
                    `;
                }

            } else {

                list.innerHTML = `
                    <div class="flex-1 flex justify-center items-center gap-[10px]">
                        <span>Pas de produit listé</span>
                    </div>
                `;

            }
            
            delLineFromAddItem();

        });

    });

}

function addItemsToDBEvent() {

    document.querySelector('#formListEditOrder').addEventListener('click', () => {

        console.log(`On tente d'envoyer les items`);

        if (currentEditItemAddList.item.length < 0) {

            console.log(`Pas de produits dans la liste, aucun ajout effectué`);
            return false;

        }

        ResetRequest();
        request.action = "ADD";
        request.object = "ITEM";
        request.content = {item: currentEditItemAddList.item};

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
                    throw new Error(`Erreur lors de l'ajout des produits dans la commande : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.

                orderjson[currentobject].items = null;
                selectOrder();

                currentEditItemAddList.item = [];

                document.querySelector('#tableListEditOrder').innerHTML = `
                <div class="flex-1 flex justify-center items-center gap-[10px]">
                    <span>Pas de produit listé</span>
                </div>
                `;

                console.log('Contenue de commande ajouté');
                

            })
            .catch(error => console.error(`Erreur du fetch d'ajout de produit dans la commande : ${error}`));

    });

}

function delItemsFromDBEvent() {

    // Initiation des addEventListener sur les boutons de suppression des lignes
    document.querySelectorAll('.delListOnglet').forEach((btn) => {
        btn.addEventListener('click', () => {
            
            // Sélecteur pour la liste
            let id = btn.getAttribute('data-id');

            ResetRequest();

            request.action = "DELETE";
            request.object = "ITEM";
            request.content = {item: [{item_id: id}]};

            let formdata = new FormData();
            formdata.append('request', JSON.stringify(request));

            fetch('app/', {method: "POST", body: formdata})
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
                        throw new Error(`Erreur lors de l'ajout des produits dans la commande : ${data.message}`);
    
                    }

                    orderjson[currentobject].items = null;
                    selectOrder();

                    console.log(`Item supprimé.`);

                })
                .catch(error => console.error(`Erreur de fetch d'update : ${error}`));

        })
    });

}

function editOrderInformationsEvent() { // À MODIFIER

    document.querySelector('#formOngletSubmit').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "UPDATE";
        request.object = "ORDER";
        request.content = {
            order_id: orderjson[currentobject].id_commande,
            client_id: document.querySelector('#client-selector').value,
            address: document.querySelector('#adresse-selector').value
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
                    throw new Error(`Erreur lors de l'édition des informations de la commande : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.
                // Fermer le popup d'edition du client

                console.log('Information de commande modifié');
                fetchAllOrders(true, false);

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
            order_id: orderjson[currentobject].id_commande
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
                    throw new Error(`Erreur lors de l'effacement de la commande : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.

                console.log('Commande supprimé');
                fetchAllOrders(true, false);

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

function selectOrder() {

    document.querySelector('#adresse-selector').value = orderjson[currentobject].adresse_livraison;
    
    const clientselector = document.querySelector('#client-selector');

    clientselector.innerHTML = "";
                
    clientsjson.forEach(client => {

        if(currentobject != null && orderjson[currentobject].from_client == client.id_client) {
            clientselector.innerHTML += `<option value="${client.id_client}" selected>${client.nom} ${client.prenom}</option>`;
        } else {
            clientselector.innerHTML += `<option value="${client.id_client}">${client.nom} ${client.prenom}</option>`;
        }

    });

    // Affichage des commandes du client
    // Si il n'y a pas de commandes en cache
    if (orderjson[currentobject].items === null) {

        ResetRequest();

        request.action = "FETCH";
        request.object = "ITEM";
        request.content = {order_id: orderjson[currentobject].id_commande};

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

                <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-slate-200 rounded-[20px] duration-300 last:mb-[0px]">
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
                        <button class="delListOnglet" data-id="${orderjson[currentobject].items[i].id_contenue}">Supprimer</button>
                    </div>
                </div>

            `;

        }

    // Si il n'y a pas de clients
    } else {

        list.innerHTML = `

            <div class="table-cell p-5">
                <p class="font-bold text-center">Cette commande est vide.</p>
            </div>

        `;

    }

    delItemsFromDBEvent();

}

function writeProductSelectFromCache() {

    const 
    productselector = document.querySelector('#edit-product-selector'),
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

    const addclientselector = document.querySelector('#add-client-selector');

    addclientselector.innerHTML = "";
    addclientselector.innerHTML += `<option value="" disable><-- Selectionnez un client --></option>`;

    clientsjson.forEach(client => {

        addclientselector.innerHTML += `<option value="${client.id_client}">${client.nom} ${client.prenom}</option>`;

    });

}