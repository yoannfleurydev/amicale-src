var text = "En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de cookies pour vous proposer " +
    "une meilleure expérience.";
var ok = "OK";

$(document).ready(function () {
    if (getCookie("cookie") !== "true") {
        $("body").append('<div class="cookie_popup">' + text + '<button class="cookie_popup_ok">' + ok + '</button></div>');
    }

    $("body").on('click', '.cookie_popup_ok', function() {
        $('.cookie_popup').fadeOut();
        setCookie("cookie", "true", 30);
    });
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}