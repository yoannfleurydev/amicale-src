
$('#askPwd').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);// Button that triggered the modal
    var id = button.attr('idTable');

    var recipient = button.data('whatever');
    var url = "/web/app_dev.php/chat/";
    var modal = $(this);
    modal.find('.modal-form').attr('action', url+id);
    modal.find('.modal-body input').val(recipient);
});

$('#confirmDelete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);// Button that triggered the modal
    var id = button.attr('idTable');

    var recipient = button.data('whatever');
    var url = "/web/app_dev.php/chat/delete/";
    var modal = $(this);
    modal.find('.modal-form').attr('action', url+id);
    modal.find('.modal-body input').val(recipient);
});