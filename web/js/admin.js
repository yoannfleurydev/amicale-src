/**
 * Created by valentin on 2/5/16.
 */

$("#upload").change(function() {
    // will log a FileList object, view gifs below
    $("#fileChoose").val(this.files[0].name);
});