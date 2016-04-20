$("#profile_edit_form_userProfilePictureUrl").change(function() {
    $("#button_name_picture").text(this.files[0].name);
});

$("#profile_edit_form_userCVUrl").change(function() {
    $("#button_name_cv").text(this.files[0].name);
});