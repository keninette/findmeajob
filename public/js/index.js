function setResendNbPosition() {
    var resendNbDivWidth    = $("#resend-nb-tile").width();
    var resendNbIconWidth   = getFaElementSize("#resend-nb-icon");
    var resendNbHeight      = $("#resend-nb").outerHeight();
    
    $("#resend-nb").css("width", resendNbHeight +"px");
    $("#resend-nb").css("height", resendNbHeight +"px");
    $("#resend-nb").css("margin-top", "-" +resendNbIconWidth/2 +"px");
    $("#resend-nb").css("margin-left", (resendNbDivWidth/2 +resendNbIconWidth/2 -resendNbHeight/2) +"px");
}

$(function(){
    
    // Set on click action on resend-nb-tile
    // Just redirect user on the same page, but with the right parameters
    // So we know the user clicked on the div to resend applications
    $("#resend-nb-tile").click(function(){
        window.location.href="index.php?target=resend";
    });
    
    // Set up knob inputs to display a nice graph
    $("#dial-answer").knob({
        'fgColor':      "#FFD500"
        , 'inputColor': "FFD500"
        , 'readOnly':   true
        , 'thickness':  0.1
    });
    
    $("#dial-meeting").knob({
        'fgColor':      "#FFD500"
        , 'inputColor': "FFD500"
        , 'readOnly':   true
        , 'thickness':  0.1
    });
    
    // Responsively set place of the resendNbDiv on the envelope icon
    setResendNbPosition();
});

