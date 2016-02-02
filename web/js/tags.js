(function() {
    // Le champ dans lequel on tape les tags
    var input = document.getElementById('tags_input');
    // La div où se trouve la liste des tags
    var tagsContainer = document.querySelector('tags_container');
    // le tableau de tags éligibles
    var prefixedTags;
    // booléen servant à savoir si on fait une requête AJAX ou pas
    var requestedAJAX = true;

    /* On ajoute une méthode au conteneur pour le vider facilement */
    tagsContainer.prototype.emptyTags = function() {
        // Tant qu'il y a encore au moins un enfant on le supprime
        while (this.childElementCount > 0) {
            this.removeChild(this.firstElementChild);
        }
    };

    /* On ajoute une méthode au conteneur pour le remplir plus facilement */
    tagsContainer.prototype.fillWithTags = function(ptags) {
        var len = ptags.length;
        /* Pour l'ensemble des tags trouvés, on créé un élément avec les valeurs adaptées */
        for (var i=0; i<len; i++) {
            var currentTagElement = document.createElement('span');
            currentTagElement.innerHTML = ptags[i];
            currentTagElement.className = 'label label-default';
            // On ajoute le nouvel élément au conteneur des tags
            this.appendChild(currentTagElement);
        }
    };

    /*
    #####################################################################################################
     */
    var callback = function() {
        // Si on veut faire une requête ajax
        if (requestedAJAX) {
            tagsContainer.emptyTags();
            prefixedTags = getPrefixedTags(input.value);
            requestedAJAX = false;
        } else {
            var len = prefixedTags.length;
            // Pour chacun des tags déjà trouvés, on cherche s'il commence par la valeur dans l'entrée
            for (var i=0; i<len; i++) {
                // S'il n'existe pas on le supprime de la liste
                if (!prefixedTags[i].startsWith(input.value)) {
                    prefixedTags.splice(i, 1);
                }
            }
            tagsContainer.emptyTags();
        }
        tagsContainer.fillWithTags(prefixedTags);
    };
    /*
    #######################################################################################################
     */

    input.addEventListener('input', getPreTags, false);
}());

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