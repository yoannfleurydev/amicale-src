/**
 * Created by valentin on 3/9/16.
 */
$('img').click(function() {
    console.log($(this));
    $(".modal-body").html($(this).clone());
    $('#img-zoom').modal('show');
});