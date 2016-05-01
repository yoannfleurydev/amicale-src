$("#offer_add_offerPdfUrl").change(function() {
    // will log a FileList object, view gifs below
    $("#button_name_cv").text(this.files[0].name);
});