$(function () {
    // tableau des tags préfixés
    var prefixedTags;
    // le tag que l'on est en train d'écrire
    var currentTag;
    // la liste des tags déjà sélectionnés
    var selectedTags;
    // si l'ajax s'est terminé
    var ajaxDone = false;

    /* fonction de recherche dans le tableau de l'ajax */
    var searchInArray = function () {
        // on vide l'endroit où sont afichés les tags
        $('#tags_container').text('');
        // si on a reçu la réponse ajax
        // Pour chaque tag qu'on a récupéréet qui n'a pas déjà été sélectionné,
        // on vérifie s'il est préfixé par la valeur qui est entrée
        $.each(prefixedTags, function (key, value) {
            // Si un tag ne correspond plus à la recherche on l'ignore
            // startsWith est sensible à la casse
            if (selectedTags.indexOf(value) !== -1 || !value.toLowerCase().startsWith(currentTag.toLowerCase())) {
                return;
            }
            // On affiche le tag dans la zone d'affichage
            $('#tags_container').html($('#tags_container').html() + "<div class='tag'>" + value + "</div>");
        });
    };

    /* $('tags_input') est l'input dans lequel on tape les tags */
    $('#tags_input').on('input', function() {

        // vide le conteneur des tags disponibles
        $('#tags_container').empty();

        var input = $(this).val();
        // la liste des tags déjà sélectionnés
        selectedTags = input.split(" ");
        currentTag = selectedTags[selectedTags.length-1];

        // S'il n'y a qu'un seul caractère alpha numérique
        if (currentTag.length === 1 && /^[a-z0-9]$/i.test(currentTag)) {
            $.ajax(
                {
                    method: "POST",
                    url: Routing.generate('agil_tags_search'),
                    data: {prefix: currentTag}
                }
            ).done(function (json) {
                prefixedTags = json;
                if (currentTag.length >= 1) {
                    $.each(json, function (key, value) {
                        // TODO Changer pour faire créer un élément HTML à chaque fois
                        // Si l'élément n'a pas déjà été sélectionné
                        if (selectedTags.indexOf(value) === -1) {
                            $('#tags_container').html($('#tags_container').html() + "<div class='tag'>" + value + "</div>");
                        }
                    });
                }
                ajaxDone = true;
                if (currentTag.length > 1) {
                    searchInArray();
                }
            }).error(function (msg) {
                // TODO Remove in prod
                console.log('ERROR : ' + msg);
            });
        }
        if (currentTag.length > 1) {
            if (ajaxDone) {
                searchInArray();
            }
        }
        if (currentTag.length === 0) {
            $('#tags_container').text('');
        }
    });

    /*
     * Pour tous les boutons qui représenteront les tags disponibles,
     * on ajoute un événement pour qu'ils soient ajoutés à la liste
     * des tags que l'on souhaite
     */
    $('#tags_container').on('click', '.tag', function() {
        // l'endroit où on tape les tags
        var tags_input = $('#tags_input');
        // La longueur de la chaine sans le tag que l'on est entrain d'écrire moins la longueur d'un espace
        var indexEnd = tags_input.val().length - currentTag.length - 1;
        // la chaine que l'on met dans l'input où sont affichés les tags sélectionnés
        var toSetUp;

        // Si c'est le premier tag
        if (indexEnd < 0) {
            toSetUp = $(this).text();
        } else if (indexEnd > 0) {
            // WARNING Rajoute un espace lorsqu'on retape après avoir cliqué sur un tag
            toSetUp = tags_input.val().substring(0, indexEnd) + ' ' + $(this).text();
        }

        // On remet à 0 le tag courant, pour éviter un résidu
        currentTag = '';
        // On efface le tag cliqué
        $(this).hide();
        // On dit de refaire une requête AJAX
        ajaxDone = false;
        // On met le tag actuel
        tags_input.val(toSetUp + " ");
        // On redonne le focus à l'input pour taper les tags
        tags_input.focus();
    });
});
