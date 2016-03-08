$(function () {
    var prefixedTags;
    var currentTag;
    var selectedTags;
    var ajaxDone = false;

    var tagsInput = $('.tags_input_visible');
    var tagsInputHidden = $('#tags_input');
    var tagsContainer = $('#tags_container');
    var listTagItem = $('.list_item_tag');

    /* fonction de recherche dans le tableau de l'ajax */
    var searchInArray = function () {
        // on vide l'endroit où sont afichés les tags
        tagsContainer.text('');
        // si on a reçu la réponse ajax
        // Pour chaque tag qu'on a récupéré et qui n'a pas déjà été sélectionné,
        // on vérifie s'il est préfixé par la valeur qui est entrée
        $.each(prefixedTags, function (key, value) {
            // Si un tag ne correspond plus à la recherche on l'ignore
            // startsWith est sensible à la casse
            if (selectedTags.indexOf(value) !== -1 || !value.toLowerCase().startsWith(currentTag.toLowerCase())) {
                return;
            }
            // On affiche le tag dans la zone d'affichage
            tagsContainer.html(tagsContainer.html() + "<div class='tag'>" + value + "</div>");
        });
        if ($.inArray(currentTag, prefixedTags) === -1) {
            tagsContainer.html(tagsContainer.html() + "<div class='tag'>" + currentTag + "</div>");
        }
    };

    tagsInput.on('input', function() {

        // vide le conteneur des tags disponibles
        tagsContainer.empty();

        var input = $(this).val();
        // la liste des tags déjà sélectionnés
        selectedTags = tagsInputHidden.val().split(" ");
        currentTag = input;

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
                            tagsContainer.html(tagsContainer.html() + "<div class='tag'>" + value + "</div>");
                        }
                    });
                    tagsContainer.html(tagsContainer.html() + "<div class='tag'>" + currentTag + "</div>");
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
            tagsContainer.text('');
        }
    });

    /*
     * Pour tous les boutons qui représenteront les tags disponibles,
     * on ajoute un événement pour qu'ils soient ajoutés à la liste
     * des tags que l'on souhaite
     */
    tagsContainer.on('click', '.tag', function() {
        // La longueur de la chaine sans le tag que l'on est entrain d'écrire moins la longueur d'un espace
        var indexEnd = tagsInputHidden.val().length - 1;
        // la chaine que l'on met dans l'input où sont affichés les tags sélectionnés
        var toSetUp;
        var clickedButton = $(this);
        var tagToAdd = clickedButton.text();
        // Si c'est le premier tag
        if (indexEnd < 0) {
            toSetUp = tagToAdd;
        } else if (indexEnd > 0) {
            // WARNING Rajoute un espace lorsqu'on retape après avoir cliqué sur un tag
            toSetUp = tagsInputHidden.val().substring(0, indexEnd) + ' ' + tagToAdd;
        }

        //On ajout l'item qui permet de montrer et supprimer un tag
        listTagItem.append( "<div class='item_tag'>" +
            "<span class='item_tag_label'>" + tagToAdd.toUpperCase() + "</span>" +
            "<span class='remove_item_tag'><span class='glyphicon glyphicon-remove'></span>" +
            "</span></div>" );

        //On séléctionne le dernier element ajouté
        var lastInsert = listTagItem.find('.item_tag').last();

        //On rajoute sur la croix un envent
        lastInsert.find('.remove_item_tag').click(function() {
            //On enléve le tag et l'espace au cas ou un tag contiendrais le même motif
            // exemple : PHP et PHPSTORM
            var val = tagsInputHidden.val().replace(tagToAdd + " ", "");
            tagsInputHidden.val(val);
            lastInsert.remove();
            clickedButton.show();
        });
        // On remet à 0 le tag courant, pour éviter un résidu
        currentTag = '';
        // On efface le tag cliqué
        clickedButton.hide();
        // On dit de refaire une requête AJAX
        ajaxDone = false;
        // On met le tag actuel
        tagsInputHidden.val(toSetUp + " ");
        // On redonne le focus à l'input pour taper les tags
        tagsInput.val("");
        tagsInput.focus();
        //On vide le container
        tagsContainer.text('');
    });

    $(document).ready(function () {
        var text = tagsInputHidden.val();
        if (text.length > 0) {
            tags = text.split(" ");
            for (tag of tags) {
                //On ajout l'item qui permet de montrer et supprimer un tag
                listTagItem.append( "<div class='item_tag'>" +
                    "<span class='item_tag_label'>" + tag.toUpperCase() + "</span>" +
                    "<span id='" + tag + "' class='remove_item_tag'><span class='glyphicon glyphicon-remove'></span>" +
                    "</span></div>" );

                //On rajoute sur la croix un envent
                $("#" + tag).click(function() {
                    //On enléve le tag et l'espace au cas ou un tag contiendrais le même motif
                    // exemple : PHP et PHPSTORM
                    var tagToDelete = $(this).attr('id');
                    var val = tagsInputHidden.val().replace(tagToDelete + " ", "");
                    tagsInputHidden.val(val);
                    $(this).parent().remove();
                });
            }
        }
    });
});
