/**
 * Created by valentin on 1/27/16.
 */

var container = document.querySelector('.container');
var button = document.querySelector('.animate');
var up = document.querySelector('.up');
var bottom = document.querySelector('.bottom');
var main = document.querySelector('.main');

function toggleSidebar(){
    isShowingSidebar() ? hideSidebar() : showSidebar();
}

function showSidebar(){
    container.classList.add('show-sidebar');
    up.classList.add('rotate_up');
    bottom.classList.add('rotate_bottom');
}

function hideSidebar(){
    container.classList.remove('show-sidebar');
    up.classList.remove('rotate_up');
    bottom.classList.remove('rotate_bottom');
}

function isShowingSidebar(){
    return container.classList.contains('show-sidebar');
}

document.querySelector('.hamburger').addEventListener('click', toggleSidebar, false);

container.addEventListener('click', function(e){
    if(isShowingSidebar() && main.contains(e.target)){
        e.preventDefault();
        hideSidebar();
    }
}, true);

$(document).scroll(function() {
    hideSidebar();
});

$("input, textearea").focusin(function() {
    hideSidebar();
});