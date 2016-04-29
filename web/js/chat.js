var webSocket = WS.connect("ws://127.0.0.1:8080");
var message = $("#ChatMessage");
var sessionGlobal = null;
var idChatTable;
var idUser;
var lesUsers = [];

$(document).ready(function () {
    idChatTable = $('#idChatTable').attr("idRoom");
    idUser = $('#idUser').attr("idUser");
    $('#message_to_send').focus();
});

webSocket.on("socket/connect", function (session) {

    sessionGlobal = session;
    // Connexion de l'utilisateur au chat
    session.subscribe("agil/chat/" + idChatTable + "/", function (uri, payload) {

        // Reception d'un message
        if (payload.msg != null) {
            addMessage(payload.msg);

        }
        // Quand on se connecte
        if (payload.se_co != null) {

            var connec = {'type': 'user_co', 'id_user': idUser, 'id': payload.se_co};
            session.publish("agil/chat/" + idChatTable + "/", connec)
        }

        if (payload.user_add != null) {
            if (lesUsers.indexOf(payload.user_add) == -1) {
                lesUsers.push(payload.user_add);
                console.log("ajout d'un utilisateur : " + payload.user_add);
                $.post(Routing.generate('agil_chat_user'), {id_user: payload.user_add})
                    .done(function (data) {
                        var user = jQuery.parseJSON(data);
                        $('#users_connected').append(
                            "<span class=\"user_connected\" id_user=" + user.userId + ">" +
                            "<div class=\" col-lg-2 col-md-2 col-sm-2 col-xs-2\">" +
                            "<img class=\"img-responsive\" src=\"/img/profile/" + user.profilPicture + "\">" +
                            "<span>" + user.userName + "</span>" +
                            "</div>" + "</span>"
                        );
                    });
            }

        }

        if (payload.user_remove != null) {
            console.log("déco de : " + payload.user_remove);
            if(lesUsers.indexOf(payload.user_remove)!=-1){
                lesUsers.splice(lesUsers.indexOf(payload.user_remove), 1);
            }
            $('.user_connected[id_user="' + payload.user_remove + '"]').remove();
        }

        if (payload.users != null && payload.users != 'false') {

            /* console.log(payload.users);
             var users = JSON.stringify(payload.users);
             console.log("entrée : " + users);

             $.post(Routing.generate('agil_chat_users'), {users: users})
             .done(function (data) {
             $("#users_connected").html("");
             var lesUsers = jQuery.parseJSON(data);
             console.log(lesUsers);
             for (var k in lesUsers) {
             var user = lesUsers[k];
             $('#users_connected').append(
             "<span class=\"user_connected\">" +
             "<div class=\" col-lg-2 col-md-2 col-sm-2 col-xs-2\" id_user=" + user.userId + ">" +
             "<img class=\"img-responsive\" src=\"/img/profile/" + user.profilPicture + "\">" +
             "<span>" + user.userName + "</span>" +
             "</div>" + "</span>"
             );
             }
             }
             );
             */
        }


        // timer
        if (payload.refresh != null) {
            actualiseDate();
        }
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

            if (lastMessage.attr('idUser') == user.userId) {
                lastMessage.children('.contenu').append(msg.contenu + "<br/>");

            } else {
                var theMessage =
                    "<div class=\"row\">" +
                    "<div idUser=" + user.userId + " class=\"message_received panel col-lg-6 col-md-6 col-sm-6 col-xs-8 " + col + "\">" +

                    "<div class=\"col-lg-1 col-md-1 col-sm-1 col-xs-2\">" +
                    "<div class=\"text-center " + couleur + "\">" + name + "</div>" +
                    "<img class=\"img-responsive\" src=\"/img/profile/" + image + "\">" +
                    "</div>" +
                    "<div date=\"" + moment().format() + "\" class=\"contenu col-lg-11 col-md-11 col-sm-11 col-xs-10\">" + msg.contenu + "<br/></div>" +
                    "<div class=\"date\"></div>" +
                    "</div>" +

                    "</div>";


                var messages = $('.messages');

                messages.append(theMessage);

            }

        });

}
function actualiseDate() {

    $('.message_received').each(function () {
        var date_message = $(this).children('.contenu').attr('date');
        $(this).children('.date').empty();
        $(this).children('.date').append(moment(date_message).fromNow());

    });
}
