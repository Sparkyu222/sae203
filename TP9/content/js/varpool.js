// Fonction pour reset la requête
function ResetRequest() {

    request = {token: usertoken, action: "", object: "", content: {}};

}

// Cache de pages, cache de liste d'objets
var cache = [null, null, null , null], listcache = [null, null, null , null];


// Page par défaut, page actuellement sélectionnée
var currentapp = 0;

// Objet JSON de la requête
var request = {token: usertoken, action: "", object: "", content: {}};

// Variable qui contient l'id de l'objet actuellement sélectionné
var currentobject = null;

// Variales qui contient les données contenue de la base
var clientsjson = {}, productjson = {}, orderjson = {};
