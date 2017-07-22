// To be executed as soon as the whole DOM has been loaded
$(function(){
    
    $("tr:not(.heading)").hover(function(){
        $(this).toggleClass("table-hover");
    });
});