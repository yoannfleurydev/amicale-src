// TODO Déplacer dans le bon dossier
$(document).ready(function () {
    /* fonction pour la suppression */
    /*
     * $('button') est un bouton dont la value est un tag existant
     */
    $('button').on('click', function () {
            var tag = $(this);
            $.ajax(
                {
                    method: "POST",
                    url: "remove",
                    data: {tagName: tag.text()},
                    async: false
                }
            ).done(function (msg) {
                $('.admin_feedback').text(msg);
                tag.fadeOut();

            }).error(function (msg) {
                console.log('ERROR : ' + msg);
            });
        }
    );
});