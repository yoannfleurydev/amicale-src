/**
 * Created by valentin on 2/5/16.
 */

$("#user_add_csv_form_file").change(function() {
    // will log a FileList object, view gifs below
    $("#button_name_cv").text(this.files[0].name);
});