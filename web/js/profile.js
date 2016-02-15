/**
 * Created by valentin on 2/8/16.
 */

$("#profil_edit_form_userProfilePictureUrl").change(function() {
    // will log a FileList object, view gifs below
    $("#button_name_picture").text(this.files[0].name);
});

$("#profil_edit_form_userCVUrl").change(function() {
    // will log a FileList object, view gifs below
    $("#button_name_cv").text(this.files[0].name);
});