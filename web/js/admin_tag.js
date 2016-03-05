// TODO Déplacer dans le bon dossier
$(document).ready(function () {
    /* fonction pour la suppression */
    $('.deleteTag').on('click', function () {
            var tag = $(this);
            $.ajax(
                {
                    method: "POST",
                    url: Routing.generate('agil_tags_remove'),
                    data: {tagName: tag.text()}
                }
            ).done(function (msg) {
                $('.admin_feedback').text(msg);
                tag.hide();
            }).error(function (msg) {
                // TODO Changer ça
                console.log('ERROR : ' + msg);
            });
        }
    );
});