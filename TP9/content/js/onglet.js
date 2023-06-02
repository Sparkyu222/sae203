// Function to switch between client app tabs
function commandPageFunctions() {

    const 
        btns1 = document.querySelector('.commandBtn1'),
        btns2 = document.querySelectorAll('.commandBtn2'),
        addLayouts = document.querySelector('.commandLayer2');


    // Refresh button only 1 time per second
    let debounceTimer;
    btns1.addEventListener('click', () => {
        if (!debounceTimer) {
            debounceTimer = setTimeout(() => {
                switch(currentapp) {
                    case 0:
            
                        break;
                    // CLIENTS
                    case 1:
                        fetchAllClients(true);
            
                        break;
                    // PRODUITS
                    case 2:
                        fetchAllProducts(true);
            
                        break;
                    // COMMANDES
                    case 3:
                        fetchAllOrders(true);
            
                        break;
                }
                debounceTimer = null;
            }, 1000); // 1000ms = 1 second
        }
    });

    // Add client button
    btns2.forEach((addClient) => {
        add(addClient);
    });



    

    function add(addClient){
        addClient.addEventListener('click', () => {
            addLayouts.classList.toggle('hidden');
        });
    }

    // Select all tab buttons and tab layers
    const
        ongletBtn = document.querySelectorAll('.onglet-btn'),
        ongletLayout = document.querySelectorAll('.onglet-layer');

    // Onglet switch system
    // Add click event listener to each tab button
    ongletBtn.forEach((onglet) => {
        onglet.addEventListener('click', () => {
            ongletSelector(onglet, onglet.getAttribute('data-onglet'));
        })
    })

    // Function to switch between tabs
    function ongletSelector(onglet, index) {
        
        //console.log(index);

        currentobject = index;
        
        // Si la ligne a déjà été cliqué dans la liste d'objet
        if(onglet.classList.contains('bg-gray-300')){

            currentobject = null;

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

        // Si la ligne n'a pas encore été cliquée
        } else {

            // METTRE LA FONCTION DE REMPLISSAGE D'INFORMATION ICI
            switch(currentapp){
                case 0:
        
                    break;
                case 1:
                    selectClient();
        
                    break;
                case 2:
                    selectProduct();
        
                    break;
                case 3:
                    selectOrder();
        
                    break;
            }

            onglet.classList.add('bg-gray-300');
            onglet.classList.remove('hover:bg-gray-200');

            for(i = 0; i < ongletBtn.length; i++) {
                if(ongletBtn[i].getAttribute('data-onglet') !== index){
                    ongletBtn[i].classList.remove('bg-gray-300');
                    ongletBtn[i].classList.add('hover:bg-gray-200');
                }
            }

            for(j = 0; j < ongletLayout.length; j++) {
                if (ongletLayout[j].getAttribute('data-onglet') == 2) {
                    ongletLayout[j].classList.remove('hidden');
                } else {
                    ongletLayout[j].classList.add('hidden');
                }
            }
        }
    }
}