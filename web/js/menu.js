
var menu = $('nav');
var button = $('.animate');
var up = $('.up');
var bottom = $('.bottom');

function toggleSidebar(){
    menu.toggleClass('show-sidebar');
    up.toggleClass('rotate_up');
    bottom.toggleClass('rotate_bottom');
}

function showSidebar(){
    menu.addClass('show-sidebar');
    up.addClass('rotate_up');
    bottom.addClass('rotate_bottom');
}

function hideSidebar(){
    menu.removeClass('show-sidebar');
    up.removeClass('rotate_up');
    bottom.removeClass('rotate_bottom');
}

var tap = ("ontouchstart" in document.documentElement);

if(!tap){
    $('.hamburger, .sidebar').mouseenter( function () {
        showSidebar();
    });

    $('.sidebar').mouseleave( function () {
        hideSidebar();
    });
} else {
    $('.hamburger').click( function () {
        toggleSidebar();
    });

    $('.container').click( function () {
        hideSidebar();
    });
}
