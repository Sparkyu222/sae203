// Function to switch between client app tabs
function commandPageFunctions() {

    const 
        btns1 = document.querySelector('.commandBtn1'),
        btns2 = document.querySelector('.commandBtn2'),
        btns3 = document.querySelectorAll('.commandBtn3'),
        addLayouts = document.querySelector('.commandLayer3');

    
    switch(currentapp){
        case 0:
            

            break;
        case 1:
            btns2.addEventListener('click', () => {
                fetchAllClients(true);
            });

            break;
        case 2:
            btns2.addEventListener('click', () => {
                fetchAllProducts(true);
            });

            break;
        case 3:
            btns2.addEventListener('click', () => {
                fetchAllOrders(true);
            });

            break;
    }

    btns3.forEach((addClient) => {
        addClient.addEventListener('click', () => {
            addLayouts.classList.toggle('hidden');
        });
    });

    

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
        console.log(index);
        
        // Loop through all tab buttons
        ongletBtn.forEach((onglet) => {
            
            if(onglet.classList.contains('bg-gray-300')){
                return;
            } else {
                onglet.classList.add('bg-gray-300');
                onglet.classList.remove('hover:bg-gray-200');
            }

            for(i = 0; i < ongletBtn.length; i++) {
                if(ongletBtn[i].getAttribute('data-onglet') !== index){
                    ongletBtn[i].classList.remove('bg-gray-300');
                    ongletBtn[i].classList.add('hover:bg-gray-200');
                }
            }
        });
    }
}

// if(onglet.classList.contains('a-onglet')){
//     return;
// } else {
//     onglet.classList.add('a-onglet');
// }

// for(i = 0; i < ongletBtn.length; i++) {
//     if(ongletBtn[i].getAttribute('data-onglet') !== index1){
//         ongletBtn[i].classList.remove('a-onglet');
//     }
// }

// for(j = 0; j < ongletLayout.length; j++) {
//     if (ongletLayout[j].getAttribute('data-onglet') == index2) {
//         ongletLayout[j].classList.remove('hidden');
//     } else {
//         ongletLayout[j].classList.add('hidden');
//     }
// }

// ongletBtn.forEach((onglet) => {
//     onglet.addEventListener('click', () => {
//         ongletSelector(onglet.getAttribute('data-onglet'));
//     })
// })