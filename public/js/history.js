// To be executed as soon as the whole DOM has been loaded
$(function(){
    
    // Every time the mouse comes over a table line
    // We add a css class on it to make it look like it's selected
    // And remove it when mouse goes out
    $("tr:not(.heading)")
        .mouseover(function(){
            $(this).addClass("table-hover");
        })
        .mouseout(function(){
            $(this).removeClass("table-hover")    ;
        });
    
    // Every time we click on a table line
    // We display forms to update or re-send application
    // And we prefill it
    $("tr:not(.heading)").click(function(){
        
        // Get application id from the class of the line that's been selected
        var id      = $(this).attr("id");
        
        // This class should look like "tr-" and followed by application ID
        // But this could change, so instead of looking for "tr-" in the string
        // We'll look for the last iteration of "-" position, to its end
        // This way, if we decide to change <tr> elements ID, we'll still have the right value
        // That is, of course, if we still end it with "-" +application ID
        var idValue = id.substring(id.lastIndexOf("-") +1, id.length);
        
        // Now that we've got application ID
        // We can look for the columns in table and be sure to be on the right table index
        // And get this line content
        var salutationValue     = $("#salutation-" +idValue).text();
        var motivationValue     = $("#motivation-" +idValue).text();
        var answerDateValue     = $("#answer_date-" +idValue).text();
        var meetingDateValue    = $("#meeting_date-" +idValue).text();
        var emailValue          = $("#email-" +idValue).text();
       
        // Now we've got all the content we need
        // We fill the application-forms
        $("#form-id-update").attr("value", idValue);
        $("#form-id-resend").attr("value", idValue);
        $("#form-email").attr("value", emailValue);
        $("#form-answer_date").attr("value", answerDateValue);
        $("#form-meeting_date").attr("value", meetingDateValue);
        $("#form-salutation").attr("value", salutationValue);
        $("#form-motivation").html(motivationValue);
        
        // Show application forms, prefilled for user        
        $("#application-forms").removeClass("hidden");
        
    });
});