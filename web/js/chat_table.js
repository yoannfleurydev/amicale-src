var hideButton = $(".hideNewChat");
var contentToHide = $(".addChatContent");


var tap = ("ontouchstart" in document.documentElement);

if (tap) {
    contentToHide.hide();
    hideButton.toggleClass('animate_up');
}

hideButton.click(function() {
    contentToHide.fadeToggle();
    hideButton.toggleClass('animate_up');
});