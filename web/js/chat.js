var webSocket = WS.connect("ws://127.0.0.1:8080");
var message = $("#ChatMessage");
var sessionGlobal = null;
var idChatTable;
var idUser;

$(document).ready(function () {
    idChatTable = $('#idChatTable').attr("idRoom");
    idUser = $('#idUser').attr("idUser");
    $('#message_to_send').focus();
});

webSocket.on("socket/connect", function (session) {
    sessionGlobal = session;
    session.subscribe("agil/chat/" + idChatTable + "/", function (uri, payload) {
        if (payload.msg != null) {
            console.log('message de : ' + payload.msg.id_user);
            addMessage(payload.msg);
        }
        /*if(payload.users != null){
            console.log("---"+JSON.parse(payload.users));
        }*/
        // timer
        if (payload.refresh != null) {
            actualiseDate();
        }
        if (payload.msg_co != null) {
            console.log(payload.msg_co);

            // Afficher une petite popup 5 secondes
        }
        if (payload.msg_deco != null) {
        }
        if (payload.users != null) {
            var users = jQuery.parseJSON(payload.users);
           console.log(users[0]);
            //console.log(JSON.parse(payload.users));*/
        }
        if (payload.con != null) {
            console.log(JSON.stringify(payload.con));
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
        var message = {'id_user': idUser, 'contenu': textArea.val()};
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
                    "<div idUser=" + user.userId + " class=\"message_received col-lg-6 col-md-6 col-sm-6 col-xs-8 " + col + "\">" +

                    "<div class=\"panel panel-default\">" +
                    "<div class=\"panel-body\">" +
                    "<div class=\"col-lg-1 col-md-1 col-sm-1 col-xs-2\">" +
                    "<div class=\"text-center " + couleur + "\">" + name + "</div>" +
                    "<img class=\"img-responsive\" src=\"/img/profile/" + image + "\">" +
                    "</div>" +
                    "<div date=\"" + moment().format() + "\" class=\"contenu col-lg-12 col-md-12 col-sm-12 col-xs-12\">"
                    + msg.contenu
                    + "</div>" +
                    "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\"></div>" +
                    "<div class=\"date\"></div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +

                    "</div>";


                var messages = $('.messages');

                messages.append(theMessage);

            }

        });

}

function actualiseDate() {
    //$('.message_received').children('.date').empty();
    //var dateMessage = $('.message_received').children('.contenu')
    //$('.message_received').children('.date').val();

    $('.message_received').each(function () {
        var date_message = $(this).children('.contenu').attr('date');
        $(this).children('.date').empty();
        $(this).children('.date').append(moment(date_message).fromNow());

    });
}
