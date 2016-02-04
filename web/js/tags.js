$(function () {
    /* fonction de recherche */
    var prefixedTags;
    var currentTag;
    $('#tags_input').on('input', function() {
        var input = $(this).val();
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
            $('#tags_container').text('');
            for (d of prefixedTags) {
                // startsWith est sensible à la casse
                if (!d.toLowerCase().startsWith(currentTag.toLowerCase())) {
                    continue;
                }
                $('#tags_container').html($('#tags_container').html() + "<button class='tag'>" + d + "</button>");
            }
        }
        if (currentTag.length === 0) {
            $('#tags_container').text('');
        }
    });

    $('#tags_container').on('click', '.tag', function() {
        var inputTags = $('#tags_input');
        var indexEnd = inputTags.val().length - currentTag.length;

        var toSetUp;
        // Si c'est le premier tag
        if (indexEnd === 0) {
            toSetUp = $(this).text();
        } else if (indexEnd > 0) {
            indexEnd -= 1;
            toSetUp = inputTags.val().substring(0, indexEnd) + ' ' + $(this).text();
        }

        $(this).fadeOut();
        inputTags.val(toSetUp + " ");
        inputTags.focus();
    });
});

