$('#myCollapsible').collapse({
    toggle: false
});
$('#form_select').hide();
$('#form_add_ss_categorie').hide();

$('input[name=ssCat]').change(
    function () {
        if ($(this).is(':checked')) {
            $('#form_select').show();
            $('#form_add_categorie').hide();
            $('#form_add_ss_categorie').show();

        } else {
            $('#form_select').hide();
            $('#form_add_categorie').show();
            $('#form_add_ss_categorie').hide();

        }
    });

// Gestion de la rotation de l'icone d'une catégorie
var bool_icon_clicked = false;
$('#icon_defil_cat').click(function () {
    if (bool_icon_clicked == false) {
        bool_icon_clicked = true;
        $('#icon_rotate').addClass("animate_up");
        $('#icon_rotate').removeClass("animate_bot");
    } else {
        bool_icon_clicked = false;
        $('#icon_rotate').addClass("animate_bot");
        $('#icon_rotate').removeClass("animate_up");
    }
});

$('#btn-add-cat').click(function () {
    verifFormulaireAjoutCategorie();
});
// Appel la fonction VerifFormulaireAjoutCategorie
$('#input_form_add_cat').on('input', function () {
    verifFormulaireAjoutCategorie();
});
$('#input_form_add_cat').blur(function () {
    verifFormulaireAjoutCategorie();
});

// Appel la fonction VerifFormulaireAjoutCategorie
$('#input_form_add_cat_des').on('input', function () {
    verifFormulaireAjoutCategorie();
});
$('#input_form_add_cat_des').blur(function () {
    verifFormulaireAjoutCategorie();
});

// Vérifie le contenu des champs, s'ils sont vides ou non
function verifFormulaireAjoutCategorie() {
    if ($('#input_form_add_cat').val() == '') {

        $('#form_add_cat_nom').addClass("has-warning");
        $('#btn-add-cat').addClass("disabled");
        $('#helpInput').removeClass("hidden");
    } else {
        if ($('#input_form_add_cat_des').val() == '') {
            $('#helpInput').removeClass("hidden");
            $('#form_add_cat_des').addClass("has-warning");
        } else {
            $('#helpInput').addClass("hidden");

            $('#form_add_cat_des').removeClass("has-warning");
            $('#btn-add-cat').removeClass("disabled");
        }
        $('#form_add_cat_nom').removeClass("has-warning");
    }
}

$('.icon-add-cat').click(function () {
    getGlyph();
    var nmId = this.id;
    this.removeClass("active");
    this.addClass("active");
});
// Gestion Nouveau sujet Forum
$('#inputNamePost').blur(function () {
    verifFormAddPost();
});
$('#inputNamePost').on('input', function () {
    verifFormAddPost();
});

$('#inputDescPost').blur(function () {
    verifFormAddPost();
});
$('#inputDescPost').on('input', function () {
    verifFormAddPost();
});

$('#inputCategPost').blur(function () {
    verifFormAddPost();
});
$('#inputCategPost').on('input', function () {
    verifFormAddPost();
});

$('#inputTagsPost').blur(function () {
    verifFormAddPost();
});
$('#inputTagsPost').on('input', function () {
    verifFormAddPost();
});


$('#inputContentPost').blur(function () {
    verifFormAddPost();
});
$('#inputContentPost').on('input', function () {
    verifFormAddPost();
});

function verifFormAddPost() {

    if ($('#inputNamePost').val() == '') {
        $('#formAddNamePost').addClass("has-warning");
        $('#btn-add-post').addClass("disabled");
        //$('#helpInput').removeClass("hidden");
    } else {
        $('#formAddNamePost').removeClass("has-warning");
        if ($('#inputDescPost').val() == '') {
            $('#formAddDescPost').addClass("has-warning");
            $('#btn-add-post').addClass("disabled");
        } else {
            $('#formAddDescPost').removeClass("has-warning");
            if ($('#inputCategPost').val() == '') {
                $('#formAddCategPost').addClass("has-warning");
                $('#btn-add-post').addClass("disabled");
            } else {
                $('#formAddCategPost').removeClass("has-warning");
                if ($('#inputTagsPost').val() == '') {
                    $('#formAddTagsPost').addClass("has-warning");
                    $('#btn-add-post').addClass("disabled");
                } else {
                    $('#formAddTagsPost').removeClass("has-warning");
                    if ($('#inputTagsPost').val() == '') {
                        $('#formAddContentPost').addClass("has-warning");
                        $('#btn-add-post').addClass("disabled");
                    } else {
                        $('#formAddContentPost').remove("has-warning");
                        $('#formAddNamePost').remove("has-warning");
                        $('#btn-add-post').removeClass("disabled");
                    }
                }
            }
        }
    }
}

$('[data-toggle="tooltip"]').tooltip();


$('.collapse').on('show.bs.collapse', function () {
    var $id = $(this).attr("id");

    var $fils = $( "a[aria-controls="+$id+"]").children();
    //$fils.removeClass("animate_down");
    $fils.addClass("animate_up");
});
$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});

$('.collapse').on('hide.bs.collapse', function () {
    var $id = $(this).attr("id");

    var $fils = $( "a[aria-controls="+$id+"]").children();
    $fils.removeClass("animate_up");
});


$( document ).ready(function() {
    var glyph =  $('#btn-cat-ch').attr('class');
    $('#forum_edit_category_forumCategoryIcon').attr('value', glyph);
});

$("#liste_gly_choice li").click(function() {
    var glyph = $(this).children().children().attr('class');

    $('#btn-cat-ch').removeClass();
    $('#btn-cat-ch').addClass(glyph);
    $('#forum_add_category_forumCategoryIcon').attr('value', glyph);
});


$("#liste_gly_choice_edit li").click(function() {
    var glyph = $(this).children().children().attr('class');

    $('#btn-cat-ch').removeClass();
    $('#btn-cat-ch').addClass(glyph);
    $('#forum_edit_category_forumCategoryIcon').attr('value', glyph);
});