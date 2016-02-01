(function() {
    var input = document.getElementById('tags_input');
    var tagsListContainer = document.querySelector('tags_container');
    var ptags;

    var getPreTags = function() {
        clearNodes(tagsListContainer);
        ptags = getPrefixedTags(input.value);
        var len = ptags.length;
        for (var i=0; i<len; i++) {
            var currentTagElement = document.createElement('label');
            currentTagElement.innerHTML = ptags[i];
            // TODO Changer la valeur de id (S'il y en a une)
            currentTagElement.id = 'an_id';
            // TODO Changer la valeur de classes
            currentTagElement.className = 'some classes';
            tagsListContainer.appendChild(currentTagElement);
        }
    };

    input.addEventListener('input', getPreTags, false);
}());

/**
 * Supprime tous les fils d'un élément HTML
 * @param node Le noeud à vider
 */
function clearNodes(node) {
    while (node.childElementCount > 0) {
        node.removeChild(node.firstElementChild);
    }
}

/**
 * Fonction d'obtention de l'ensemble des tags ayant pour préfixe une valeur donnée
 * @param prefix Le préfixe pour lequel on veut la liste de tags
 * @returns {*} null si erreur, un tableau de string sinon
 */
function getPrefixedTags(prefix) {
    var get_xhr = new XMLHttpRequest();
    get_xhr.open('POST', 'search');

    /* On crée un pseudo formulaire pour remplir plus
     aisément les valeurs dans la requête */
    var data = new FormData();

    // TODO Changer le 2nd argument par la valeur reçue par la saisie utilisateur
    data.append('prefix', prefix);

    var response  = null;
    // pour une requête synchrone il n'y a qu'à vérifier le statut de la requête
    get_xhr.addEventListener(
        'load',
        function () {
            if (get_xhr.readyState === get_xhr.DONE) {
                try {
                    // response sera un tableau de string
                    response = JSON.parse(get_xhr.responseText);
                } catch (e) {
                    // parse a foiré
                }
            }
        },
        false
    );

    get_xhr.send(data);

    return response;
}

/**
 * Fonction permettant la suppression d'un tag
 * @param value le nom du tag à supprimer
 */
function removeTag(value) {
    var remove_xhr = new XMLHttpRequest();
    remove_xhr.open('POST', 'remove');
    var data = new FormData();
    data.append('tagValue', value);
    remove_xhr.addEventListener(
        'load',
        function() {
            if (remove_xhr.readyState === remove_xhr.DONE && remove_xhr.status === 200) {
                alert('Tag correctement supprimé');
            } else {
                alert('Erreur. Vérifiez que le tag existe');
            }
        },
        false
    );
}