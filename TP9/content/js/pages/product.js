function fetchAllProducts(write, writeOrderSelect) {

    // Status pour le return
    let status = true;

    ResetRequest();

    request.action = "FETCH";
    request.object = "PRODUCT";

    let formdata = new FormData();
    formdata.append('request', JSON.stringify(request));

    fetch ('app/', {method: 'POST', body: formdata})
        .then(response => {

            if (!response.ok) {

                status = false;
                throw new Error(`Erreur de la requête HTTP, ${response.status}`);
            }

            return response.json();

        })
        .then(data => {

            if (data.status !== "SUCCESS") {

                status = false;
                throw new Error(`Erreur retourné par l'API, ${data.message}`);

            }

            productjson = data.content.product;

            if (write) writeProductList();

            console.log('Récupération des produits effectué');

            if (write) commandPageFunctions();

            if (writeOrderSelect) {

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

        })
        .catch(error => console.error(`Erreur lors de la récupération des produits : ${error}`));

    return status;
}

function writeProductList() {

    // Sélectionner la balise de liste
    const list = document.querySelector('#objList');

    list.innerHTML = "";

    // Si le nombre de produits est supérieur à zero
    if (productjson.length > 0) {

        // Écrire chaque ligne dans la liste
        for (let i = 0; i < productjson.length; i++) {

            list.innerHTML += `

                <div class="mb-[5px] px-[20px] py-[5px] flex flex-row gap-[30px] hover:bg-gray-200 rounded-[20px] duration-300 last:mb-[0px] cursor-pointer onglet-btn" data-onglet="${i}">
                    <div class="w-[10%] p-2 flex justify-center items-center">
                        <span class="font-bold">${(i+1)}</span>
                    </div>
                    <div class="w-[40%] p-2">
                        <p class="font-bold">${productjson[i].libelle}</p>
                        <p class="text-slate-600">#${productjson[i].code_produit}</p>
                    </div>
                    <div class="w-[30%] p-2 text-center">
                        <span class="text-slate-600">${productjson[i].prix_unitaire}€</span>
                    </div>
                    <div class="w-[20%] p-2 text-center">
                        <span class="text-slate-600">#${productjson[i].id_produit}</span>
                    </div>
                </div>

            `;

        }

    // Si il n'y a pas de produits
    } else {

        list.innerHTML = `

            <div class="table-cell p-5">
                <p class="font-bold text-center">Aucun produits dans la base de données</p>
            </div>

        `;

    }

    // Mettre la liste visuelle des produits dans le cache
    listcache[currentapp] = list.innerHTML;

}

// Ajouter un produit
function addProductEvent() {

    document.querySelector('#submit_addproduct').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "ADD";
        request.object = "PRODUCT";
        request.content = {
            product_code: document.querySelector('#product_code').value,
            label: document.querySelector('#label').value,
            price: document.querySelector('#price').value,
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
                    throw new Error(`Erreur lors de la création du produit : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.
                // Fermer le popup d'ajout de client
                document.querySelector('.commandLayer2').classList.toggle('hidden');

                fetchAllProducts(true, false);
                
                console.log('Produit créé.');

            })
            .catch(error => console.error(`Erreur du fetch de création : ${error}`));

    });

}

// Edit client
function editProductEvent() {

    document.querySelector('#formOngletSubmit').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "UPDATE";
        request.object = "PRODUCT";
        request.content = {
            product_id: productjson[currentobject].id_produit,
            label: document.querySelector('#formOnglet1').value,
            product_code: document.querySelector('#formOnglet2').value,
            price: document.querySelector('#formOnglet3').value,
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
                    throw new Error(`Erreur lors de l'édition des informations du produit : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.
                // Fermer le popup d'edition du client

                console.log('Produit modifié');
                fetchAllProducts(true, false);

            })
            .catch(error => console.error(`Erreur du fetch d'update : ${error}`));

    });

}

// Supprimer un produit
function deleteProductEvent() {

    document.querySelector('#formOngletDelete').addEventListener('click', () => {

        ResetRequest();
        
        request.action = "DELETE";
        request.object = "PRODUCT";
        request.content = {
            product_id: productjson[currentobject].id_produit
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
                    throw new Error(`Erreur lors de l'effacement du produit : ${data.message}`);

                }

                // Quand on arrive ici, c'est que la requête est effectuée.

                console.log('Produit supprimé');
                fetchAllProducts(true, false);

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

function selectProduct() {

    // Initialisation du form du produit
    document.querySelector('#formOnglet1').value = productjson[currentobject].libelle;
    document.querySelector('#formOnglet2').value = productjson[currentobject].code_produit;
    document.querySelector('#formOnglet3').value = productjson[currentobject].prix_unitaire;

}