$(document).ready(function()
{
    $(".loading").hide();

    $("#search_keywords").keyup(function() {

        $(".loading").show();

        var keywords = $("#search_keywords").val();
        var data_form = 'keyword=' + keywords;

        $.ajax({
            type: "POST",
            url: Routing.generate('agil_admin_user_search'),
            data: data_form,
            cache: false,
            success: function(data){
                $('#search_result').html(data);
                $(".loading").hide();
            }
        });
        return false;
    });
});