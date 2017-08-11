$(function(){
    var viewportHeight          = $(document).height();
    var firstFullscreenDivTop   = $(".fullscreen-height:first-child").top;
    console.log(firstFullscreenDivTop);
    $(".fullscreen-height").css("height", viewportHeight +"px");
});