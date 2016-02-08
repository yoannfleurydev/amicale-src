/**
 * Created by valentin on 2/8/16.
 */

$("#profil_edit_form_userProfilePictureUrl").change(function() {
    // will log a FileList object, view gifs below
    $("#button_name").text(this.files[0].name);
});