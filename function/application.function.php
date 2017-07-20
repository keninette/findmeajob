<?php

require_once 'function/main.function.php';
require_once 'function/motivation.function.php';

function sendMotivationEmail(String $recipient, String $salutation, String $customizedMotivation) {
    
    // Require PHPmailer
    require dir(__DIR__) .'/public/vendor/PHPMailer-master/PHPMailerAutoload.php';
    require dir(__DIR__) .'/config/smtp.config.php';
    
    // If motivation has been customized
    // We need to create a new motivation letter pdf file in order to send it
    if ($customizedMotivation != "") {
        $newPdfFile = "tmp/" .generateToken(20) .".pdf";
        
        // Get motivation JSON info
        $motivation = json_decode(ATTACHMENT_PATH_MOTIV_JSON);
        
        // Create new PDF file with custom content added to it into tmp directory
        createMotivationPdfFile($motivation['contact'], $motivation['subject'], $motivation['content'], $customizedMotivation, $newPdfFile);
        
        // If PDF has successfully been created : send email
        // todo : error management
        
        // Create and configure new email
        $mail = new PHPMailer;
        $mail->isSMTP();                                        // Set mailer to use SMTP
        $mail->SMTPDebug    = 3;                                   // Enable verbose debug output
        $mail->Host         = $smtpServer;                              // Specify main and backup SMTP servers
        $mail->SMTPAuth     = $smtpUseAuthentication;               // Enable SMTP authentication
        $mail->Username     = $smtpUsername;                        // SMTP username
        $mail->Password     = $smtpPassword;                           // SMTP password
        $mail->SMTPSecure   = $smtpSecureConnection;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = $smtpPort;                                    // TCP port to connect to
        //
        //$mail->setFrom('from@example.com', 'Mailer');
        //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        //
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        //$mail->isHTML(true);                                  // Set email format to HTML
        //
        //$mail->Subject = 'Here is the subject';
        //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        //
        //if(!$mail->send()) {
        //    echo 'Message could not be sent.';
        //    echo 'Mailer Error: ' . $mail->ErrorInfo;
        //} else {
        //    echo 'Message has been sent';
        //}
    }
}
