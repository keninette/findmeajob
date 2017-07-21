<?php 

// If form has been submitted, send email !
if (isset($_POST['form-application'])) {
        
    $email      = (string) htmlspecialchars($_POST['form-application']['email']);
    $salutation = (string) htmlspecialchars($_POST['form-application']['salutation']);
    $company    = (string) htmlspecialchars($_POST['form-application']['company']);
    $motivation = (string) htmlspecialchars($_POST['form-application']['motivation']);
    
    // if all required fields all filled
    // send email and insert in database
    // demons run when a good man goes to war (11 <3)
    if ($email != "" && $salutation != "") {
        $msg = sendMotivationEmail($email, $salutation, $motivation);
    
        // if email has successufully been sent
        // insert application data into db
        $msg .= "<br />" .insertApplicationIntoDb($_POST['form-application']);
        
    }
} 
