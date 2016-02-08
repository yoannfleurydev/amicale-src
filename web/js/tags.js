$(function () {
    /* fonction de recherche */
    var prefixedTags;
    // le tag que l'on est en train d'écrire
    var currentTag;
    /* $('tags_input') est l'input dans lequel on tape les tags */
    $('#tags_input').on('input', function() {
        var input = $(this).val();
        // la liste des tags déjà sélectionnés
        var selectedTags = input.split(" ");
        currentTag = selectedTags[selectedTags.length-1];

        if (currentTag.length === 1) {
            $.ajax(
                {
                    method: "POST",
                    url: "search",
                    data: {prefix: currentTag},
                    async: false
                }
            ).done(function (json) {
                prefixedTags = JSON.parse(json);
                for (d of prefixedTags) {
                    // TODO Changer pour faire créer un élément HTML à chauqe fois
                    // Si l'élément n'a pas déjà été sélectionné
                    if (selectedTags.indexOf(d) === -1) {
                        $('#tags_container').html($('#tags_container').html() + "<button class='tag'>" + d + "</button>");
                    }
                }
            }).error(function (msg) {
                console.log('ERROR : ' + msg);
            });
        }
        if (currentTag.length > 1) {
            // on vide l'endroit où sont afichés les tags
            $('#tags_container').text('');
            // Pour chaque tag qu'on a récupéré, on vérifie s'il est préfixé par la valeur qui est entrée
            for (d of prefixedTags) {
                // startsWith est sensible à la casse
                if (!d.toLowerCase().startsWith(currentTag.toLowerCase())) {
                    continue;
                }
                // On affiche le tag dans la zone d'affichage
                $('#tags_container').html($('#tags_container').html() + "<button class='tag'>" + d + "</button>");
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
        var inputTags = $('#tags_input');
        // La longueur de la chaine sans le tag que l'on est entrain d'écrire
        var indexEnd = inputTags.val().length - currentTag.length;

        // la chaine que l'on met dans l'input où sont affichés les tags sélectionnés
        var toSetUp;
        // Si c'est le premier tag
        if (indexEnd === 0) {
            toSetUp = $(this).text();
        } else if (indexEnd > 0) {
            indexEnd -= 1;
            toSetUp = inputTags.val().substring(0, indexEnd) + ' ' + $(this).text();
        }

        // On efface le tag cliqué
        $(this).fadeOut();
        // On met le tag actuel
        inputTags.val(toSetUp + " ");
        // On redonne le focus à l'input pour taper les tags
        inputTags.focus();
    });
});

