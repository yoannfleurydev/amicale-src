$('img').click(function() {
    var img = $(this).clone();
    $(".modal-body").html(img);
    $('#img-zoom').modal('show');
});

$(document).ready(function(){
    $(".owl-carousel").owlCarousel({nav:true});
});

var pictures;
var nbInput = 1;
var nbPicture = 0;

var imageEvent = function () {
    var tabFile = this.files;

    for(var i = 0 ; i < tabFile.length; i++) {
        var preview = $('#' + tabFile[i].name);
        var reader  = new FileReader();
        var theFile = tabFile[i];
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                var span = document.createElement('span');
                span.className = "editable-picture";
                span.innerHTML = ['<img height="100px" width="100px" class="picture' + nbPicture + '" src="', e.target.result,
                    '" title="', escape(theFile.name), '"/>' +
                    '</a>'].join('');
                document.getElementById('addedPicture').appendChild(span);
                nbPicture++;
            };
        })(theFile);

        // Read in the image file as a data URL.
        reader.readAsDataURL(theFile);
    }
    $(this).attr("class","hidden");
    $(this).attr("id","");

    $(".square-add-picture").append("<input type='file' id='choosePicture' " +
        "name='event_add_form[photos][" +  nbInput  + "][]' " +
        "class='form-control' multiple='multiple' />");
    nbInput++;
    $("#choosePicture").change(imageEvent);
}

$("#choosePicture").change(imageEvent);