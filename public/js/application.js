// To be executed when the DOM is fully loaded
$(function(){
    
    // hide motivation customization form
    $("#block-motivation-custom").hide();
    
    // on click on #btn-customize-motivation, show motivation customization form
    $("#btn-customize-motivation").click(function(){
        $("#block-motivation-custom").show("slow");
    });
});

