$(function () {
    /* fonction de recherche */
    var prefixedTags;
    $('#tags_input').on('input', function() {
        var input = $(this).val();
        var tags = input.split(" ");
        var currentTag = tags[tags.length-1];

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
                    $('#tags_container').html($('#tags_container').html() + "<button class='tag'>" + d + "</button>");
                }
            }).error(function (msg) {
                console.log('ERROR : ' + msg);
            });
        }
        if (currentTag.length > 1) {
            $('#tags_container').text('');
            for (d of prefixedTags) {
                if (!d.startsWith(currentTag)) {
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
        // TODO mettre les tags dans l'input
        //$('#tags_input').text($('#tags_input').text + ' ' + $(this).text());
        console.log($(this).text());
    });
});

