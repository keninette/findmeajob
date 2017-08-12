$(function(){
    
    $("#html-code").bind('input propertychange', function() {
        $("#html-display").html($(this).val());
    });
            
});
