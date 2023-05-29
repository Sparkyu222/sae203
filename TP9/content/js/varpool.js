// Fonction pour reset la requête
function ResetRequest() {

    request = {token: usertoken, action: "", object: "", content: {}};

}

// Cache de pages
var cache = [null, null, null , null];
// Cache de liste d'objets
var listcache = [null, null, null , null];

// Page par défaut, page actuellement sélectionnée
var currentapp = 0;

// Objet JSON de la requête
var request = {token: usertoken, action: "", object: "", content: {}};

// Variales qui contient les données contenue de la base
var clientsjson = {}, productjson = {}, orderjson = {};
