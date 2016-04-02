var hideButton = $(".hideSearch");
var contentToHide = $(".searchContent");


var tap = ("ontouchstart" in document.documentElement);

if (tap) {
    contentToHide.hide();
    hideButton.toggleClass('animate_up');
}

hideButton.click(function() {
    contentToHide.fadeToggle();
    hideButton.toggleClass('animate_up');
});

