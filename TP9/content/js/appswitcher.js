function clientappswticher() {

    const ongletBtn = document.querySelectorAll('.onglet-btn'),
    ongletLayout = document.querySelectorAll('.onglet-layer');

    let index = 0;



    // Onglet switch system
    ongletBtn.forEach((onglet) => {
        onglet.addEventListener('click', () => {
            ongletSelector(onglet.getAttribute('data-onglet'));
        })
    })

    function ongletSelector(index) {
        console.log('on tente de changer donglet');
        
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

            console.log('on quitte dans la putin de fonction');
        });
    }

}

function appswitcher(appid) {

    if (appid == currentapp) return console.log(`Same app page, no switch.`);

    currentapp = appid;

    const button = ['app00', 'app01', 'app02', 'app03'];
    const name = ['Dashboard', 'Clients', 'Produits', 'Commandes'];
    const url = ['content/pages/dashboard.php', 'content/pages/clients.php', 'content/pages/products.php', 'content/pages/orders.php'];

    console.log(`Switched app: ${appid}, ${button[appid]}/${name[appid]}`);

    document.getElementById(button[appid]).className = "h-[40px] px-4 flex items-center gap-4 bg-zinc-800 rounded-[20px] text-[16px] text-white hover:bg-zinc-700";
    document.getElementById(button[appid]).getElementsByTagName('span')[0].innerHTML = name[appid];

    for (let i=0 ; i < 4 ; i++) {

        if (appid == i) continue;

        document.getElementById(button[i]).className = "aspect-square w-[40px] flex justify-center items-center rounded-[20px] text-[16px] text-slate-400 hover:bg-zinc-800";
        document.getElementById(button[i]).getElementsByTagName('span')[0].innerHTML = "";

    }

    let postdata = new FormData();
    postdata.append('user-token', usertoken);

    fetch (url[appid], {method: 'POST', body: postdata})
        .then(response => {

            if (!response.ok) {

                throw new Error(`Erreur HTTP, status : ${response.status}`);

            }

            return response.text();

        })
        .then(data => {

            document.getElementById('main').innerHTML = data;

            switch (appid) {

                // DASHBOARD
                case 0:

                    break;

                // CLIENTS
                case 1:
                    clientappswticher();
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

var currentapp = 0;

// Récupération de dashboard.php lorsque l'on charge la page pour la première fois
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

        document.getElementById('main').innerHTML = data;

    })
    .catch(error => console.error('Erreur: ', error));
