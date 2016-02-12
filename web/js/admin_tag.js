// TODO Déplacer dans le bon dossier
$(document).ready(function () {
    /* fonction pour la suppression */
    /*
     * $('button') est un bouton dont la value est un tag existant
     */
    $('.deleteTag').on('click', function () {
            var tag = $(this);

            $.ajax(
                {
                    method: "POST",
                    // TODO Changer ici pour la prod
                    // DEV
                    url: "http://amicale.dev/tags/remove",
                    // PROD
                    /* url: location.hostname + "/tags/remove", */
                    data: {tagName: tag.text()}
                }
            ).done(function (msg) {
                $('.admin_feedback').text(msg);
                tag.fadeOut();
            }).error(function (msg) {
                // TODO Changer ça
                console.log('ERROR : ' + msg);
            });
        }
    );
});