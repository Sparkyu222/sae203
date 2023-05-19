// Function to switch between client app tabs
function clientappswitcher() {

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

// Function to switch between apps
function appswitcher(appid) {

    // If the selected app is already open, do nothing
    if (appid == currentapp) return console.log(`Same app page, no switch.`);

    // Set the current app to the selected app
    currentapp = appid;

    // Arrays for app buttons, names, and URLs
    const button = ['app00', 'app01', 'app02', 'app03'];
    const name = ['Dashboard', 'Clients', 'Produits', 'Commandes'];
    const url = ['content/pages/dashboard.php', 'content/pages/clients.php', 'content/pages/products.php', 'content/pages/orders.php'];

    console.log(`Switched app: ${appid}, ${button[appid]}/${name[appid]}`);

    // Change the selected app button's style and text
    document.getElementById(button[appid]).className = "h-[40px] px-4 flex items-center gap-4 bg-zinc-800 rounded-[20px] text-[16px] text-white hover:bg-zinc-700";
    document.getElementById(button[appid]).getElementsByTagName('span')[0].innerHTML = name[appid];

    // Loop through all other app buttons and reset their style and text
    for (let i=0 ; i < 4 ; i++) {

        if (appid == i) continue;

        document.getElementById(button[i]).className = "aspect-square w-[40px] flex justify-center items-center rounded-[20px] text-[16px] text-slate-400 hover:bg-zinc-800";
        document.getElementById(button[i]).getElementsByTagName('span')[0].innerHTML = "";

    }

    // Create a new FormData object with the user token
    let postdata = new FormData();
    postdata.append('user-token', usertoken);

    // Fetch the selected app's content using its URL and the user token
    fetch (url[appid], {method: 'POST', body: postdata})
        .then(response => {

            if (!response.ok) {

                throw new Error(`Erreur HTTP, status : ${response.status}`);

            }

            return response.text();

        })
        .then(data => {

            // Replace the main content with the selected app's content
            document.getElementById('main').innerHTML = data;

            // Call the appropriate function for the selected app
            switch (appid) {

                // DASHBOARD
                case 0:

                    break;

                // CLIENTS
                case 1:
                    clientappswitcher();
                    break;

                // PRODUITS
                case 2:

                    break;
                
                // COMMANDES
                case 3:

                    break;

            }

        })
        .catch(error => console.error('Erreur: ', error));

}

// Set the current app to 0
var currentapp = 0;

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
