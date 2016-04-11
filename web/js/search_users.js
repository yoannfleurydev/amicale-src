$(document).ready(function()
{
    $(".loading").hide();
    $(".search-informations").hide();

    $("#search_keywords").keyup(function() {
        search_users();
    });
    $('#search_form').submit(function( event ) {
        event.preventDefault();
        return false;
    });
});

function search_users () {
    $(".loading").show();
    $(".search-informations").show();

    var keywords = $("#search_keywords").val();
    var data_form = 'keyword=' + keywords;

    $.ajax({
        type: "POST",
        url: Routing.generate('agil_admin_user_search'),
        data: data_form,
        cache: false,
        success: function (data) {
            $('#search_result').html(data);
            $(".loading").hide();
        }
    });

    return false;
}