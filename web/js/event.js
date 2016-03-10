$('img').click(function() {
    var img = $(this).clone();
    $(".modal-body").html(img);
    $('#img-zoom').modal('show');
});


$(document).ready(function(){
    $(".owl-carousel").owlCarousel({nav:true});
});