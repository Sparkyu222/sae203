function appswitcher(appid) {

    if (appid == currentapp) return console.log(`Same app page, no switch.`);

    currentapp = appid;

    const button = ['app00', 'app01', 'app02', 'app03'];
    const name = ['Dashboard', 'Clients', 'Produits', 'Commandes'];
    const url = ['content/pages/dashboard.php', 'content/pages/clients.php', 'content/pages/products.php', 'content/pages/orders.php']

    console.log(`Switched app: ${appid}, ${button[appid]}/${name[appid]}`);

    document.getElementById(button[appid]).className = "px-4 py-2 flex items-center gap-4 bg-zinc-800 rounded-[20px] text-white";
    document.getElementById(button[appid]).getElementsByTagName('span')[0].innerHTML = name[appid];

    for (let i=0 ; i < 4 ; i++) {

        if (appid == i) continue;

        document.getElementById(button[i]).className = "aspect-square p-2 flex justify-center items-center rounded-[20px] text-slate-400";
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

