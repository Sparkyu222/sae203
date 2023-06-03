// Fonction pour reset la requête
function ResetRequest() {

    request = {token: usertoken, action: "", object: "", content: {}};

}

// Fonction qui reset les objets des Item Lists
function ResetCurrentItemList() {

    currentAddItemAddList = {item: []};
    currentEditItemAddList = {item: []};
    currentItemRemoveList = {item: []};

}

// Cache de pages, cache de liste d'objets
var cache = [null, null, null , null], listcache = [null, null, null , null];

// Page par défaut, page actuellement sélectionnée
var currentapp = 0;

// Objet JSON de la requête
var request = {token: usertoken, action: "", object: "", content: {}};

// Variable qui contient l'id de l'objet actuellement sélectionné
var currentobject = null;

// Objet json qui contient les modifications des contenues de commandes
var currentAddItemAddList = {item: []}, currentEditItemAddList = {item: []}, currentItemRemoveList = {item: []};

// Variales qui contient les données contenue de la base
var clientsjson = {}, productjson = {}, orderjson = {};