var webSocket = WS.connect("ws://127.0.0.1:8080");

var message = $("#ChatMessage");
var sessionGlobal = null;
var idChatTable;
var idUser;
var theUsers = [];
var nb_msg;

$(document).ready(function () {

    $('#message_to_send').focus();

    idChatTable = $('#idChatTable').attr("idRoom");
    idUser = $('#idUser').attr("idUser");
    nb_msg = $('.contenu').length;

    console.log("Connexion de "+idUser);
    console.log("---------------------");
    refreshDate();
});

$(window).on('scroll', function () {
    if (document.body.scrollTop === 0) {
        if (nb_msg >= 100) {
            $.post(Routing.generate('agil_chat_message_load'), {id_table: idChatTable, nb_msg: nb_msg})
                .done(function (data) {
                    nb_msg = $('.contenu').length - 100;
                });
        }
    }
});

// Connexion à la salle
webSocket.on("socket/connect", function (session) {

    sessionGlobal = session;

    // Connexion d'un utilisateur au chat
    session.subscribe("agil/chat/" + idChatTable + "/", function (uri, payload) {

        // Reception d'un message
        if (payload.msg != null) { addMessage(payload.msg); }

        // Quand on se connecte
        // On envoie son idée à la salle
        if (payload.se_co != null) {
            var connec = {'type': 'user_co', 'id_user': idUser, 'id': payload.se_co};
            session.publish("agil/chat/" + idChatTable + "/", connec)
        }

        // Dès qu'un autre utilisateur est connecté
        // on l'affiche
        if (payload.user_add != null) {

            if (theUsers.indexOf(payload.user_add) == -1) {
                theUsers.push(payload.user_add);

                $.post(Routing.generate('agil_chat_user'), {id_user: payload.user_add})
                    .done(function (data) {

                        var user = jQuery.parseJSON(data);
                        $('#users_connected').append(
                            "<div class=\"list-element\" id_user=\"" + user.userId + "\" >" +
                            "<img class=\"img-circle\" src=\"/img/profile/" + user.profilPicture + "\" width=\"20px\"> " +user.userName +
                            "</div>"
                        );
                    });
            }

        }

        if (payload.user_remove != null) {
            console.log("déco de : " + payload.user_remove);

            if (theUsers.indexOf(payload.user_remove) != -1) {
                theUsers.splice(theUsers.indexOf(payload.user_remove), 1);
                console.log("--"+theUsers+"--");
                $('.list-element[id_user=' + payload.user_remove + ']').remove();
            }
        }

        // Toutes les 150 secondes
        if (payload.refresh != null) { refreshDate();}
    });


    $('.send_message').on('click', function () {
        send();
    });

    $('#message_to_send').keydown(function (event) {
        if (event.keyCode == 13) {
            var content = this.value;
            var caret = getCaret(this);
            if (event.shiftKey) {

            } else {
                send();
                $(this).val('').focus();
                $(this).val = content.substring(0, caret - 1) + content.substring(caret, content.length);

                return false;
            }
        }

    });


    function getCaret(el) {
        if (el.selectionStart) {
            return el.selectionStart;
        } else if (document.selection) {
            el.focus();
            var r = document.selection.createRange();
            if (r == null) {
                return 0;
            }
            var re = el.createTextRange(), rc = re.duplicate();
            re.moveToBookmark(r.getBookmark());
            rc.setEndPoint('EndToStart', re);
            return rc.text.length;
        }
        return 0;
    }

    function send() {

        var textArea = $('#message_to_send');
        var message = {'type': 'msg', 'id_user': idUser, 'contenu': textArea.val()};
        if (message.contenu != '') {
            session.publish("agil/chat/" + idChatTable + "/", message);
            textArea.val('');
        }

    }
});


webSocket.on("socket/disconnect", function (error) {
    session = null;
    console.log("Disconnected for " + error.reason + " with code " + error.code);
});


function addMessage(msg) {
    var user = null;
    $.post(Routing.generate('agil_chat_user'), {id_user: msg.id_user})
        .done(function (data) {

            var user = jQuery.parseJSON(data);
            var name = user.userName;
            var couleur = "";
            var col = "";

            if (user.userId == idUser) {
                couleur = "text-red";
                col = "col-lg-offset-6 col-sm-offset-6 col-md-offset-6 col-xs-offset-6";
            } else {
                couleur = "text-blue";
            }
            var image = user.profilPicture;
            var lastMessage = $('.message_received').last();

            var date = moment().format();

            if (lastMessage.attr('idUser') == user.userId) {
                lastMessage.find('.contenu').append("<p class=\"no-margin-top-bot\">" + msg.contenu + "</p>");
            } else {
                console.log("---"+msg.contenu+"---");
                var theMessage =
                    "<div class=\"row\">" +
                        "<div idUser=" + user.userId + " class=\"message_received col-lg-6 col-md-6 col-sm-6 col-xs-8 " + col + "\">" +

                    "<div class=\"panel panel-default\">" +
                    "<div class=\"panel-body\">" +
                    "<div class=\"col-lg-1 col-md-1 col-sm-1 col-xs-2\">" +
                    "<div><img class=\"img-circle img-responsive\" src=\"/img/profile/" + image + "\" size='5px'></div>" +
                    "<div class=\"text-center " + couleur + "\">" + name + "</div>" +
                    "</div>" +
                    "<div date=\"" + moment().format() + "\" class=\"contenu col-lg-12 col-md-12 col-sm-12 col-xs-12\">"
                    + "<p class=\"no-margin-top-bot\">"+ msg.contenu+"</p>"
                    + "</div>" +
                    "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"></div>" +
                    "<div class=\"date\">"+moment(moment().format()).fromNow()+"</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +

                    "</div>";


                var messages = $('.messages');

                messages.append(theMessage);

            }
            //
            $.post(Routing.generate('agil_chat_message'), {
                    msg_content: msg.contenu,
                    msg_date: date,
                    id_table: idChatTable
                })
                .done(function (data) {
                });

        });

}
function refreshDate() {

    $('.message_received').each(function () {
        var date_message = $(this).find('.contenu').attr('date');
        $(this).find('.date').empty();
        $(this).find('.date').append(moment(date_message).fromNow());

    });

    $('.message_received_pers').each(function (){

        var date = $(this).find('.date_message').attr('date');
       $(this).find('.date_message').empty();
        $(this).find('.date_message').append(moment(date).fromNow());
    });
}