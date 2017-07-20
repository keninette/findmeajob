<?php 

require_once 'config/smtp.config.php';
require_once 'public/vendor/PHPMailer-master/PHPMailerAutoload.php';

// If form has been submitted, send email !
if (isset($_POST['form-application'])) {
    var_dump($_POST['form-application']);
    
    $email      = (string) htmlspecialchars($_POST['form-application']['email']);
    $salutation = (string) htmlspecialchars($_POST['form-application']['salutation']);
    $company    = (string) htmlspecialchars($_POST['form-application']['company']);
    $motivation = (string) htmlspecialchars($_POST['form-application']['motivation']);
    
    // if all required fields all filled
    // send email and insert in database
    // demons run when a good man goes to war (11 <3)
    if ($email != "" && $salutation != "" && $company != "") {
        
    }
} 
