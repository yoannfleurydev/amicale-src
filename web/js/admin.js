$("#user_add_csv_form_file").change(function() {
    // will log a FileList object, view gifs below
    $("#button_name_cv").text(this.files[0].name);
});

$("#choosePicture").change(function() {
    var tabFile = this.files;

    for(var i = 0 ; i < tabFile.length; i++) {
        var preview = $('#' + tabFile[i].name);
        console.log(preview);
        var reader  = new FileReader();
        var theFile = tabFile[i];
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                var span = document.createElement('span');
                span.innerHTML = ['<img height="100px" width="100px" class="thumb" src="', e.target.result,
                    '" title="', escape(theFile.name), '"/>' +
                    '</a>'].join('');
                document.getElementById('addedPicture').appendChild(span);
            };
        })(theFile);

        // Read in the image file as a data URL.
        reader.readAsDataURL(theFile);
    }
});