<?php

require_once 'function/main.function.php';
require_once 'function/motivation.function.php';

/**
 * Send email (based on view/template/email.template.html)
 * Attachments : motivation letter & cv
 * If motivation letter has been customized, it is reprinted as tmp pdf
 * @param String $recipient : email recipient
 * @param String $salutation : salutation at the beginning of the motivation letter, such as "Madame, Monsieur" or "Très chère duchesse d'Aquitaine" as the french would say
 * @param String $customizedMotivation : customized part of motivation letter
 * @return html message to display to user (error or success) : just echo() it !
 */
function sendMotivationEmail(String $recipient, String $salutation, String $customizedMotivation) :String {
    $finalMotivationPdfFile = ATTACHMENT_PATH_MOTIV_PDF;
    // Require PHPmailer
    require_once dirname(__DIR__) .'/public/vendor/PHPMailer-master/PHPMailerAutoload.php';
    require_once dirname(__DIR__) .'/config/smtp.config.php';
    
    // Get motivation JSON info
    $motivation = json_decode(file_get_contents(ATTACHMENT_PATH_MOTIV_JSON), true);
    
    // If motivation has been customized
    // We need to create a new motivation letter pdf file in order to send it
    if ($customizedMotivation != "") {
        $finalMotivationPdfFile = "tmp/" .generateToken(20) .".pdf";       
        
        // Create new PDF file with custom content added to it into tmp directory
        createMotivationPdfFile($motivation['contact'], $motivation['subject'], $motivation['content'], $customizedMotivation, $finalMotivationPdfFile);
    }
    
        // If PDF has successfully been created : send email
        // todo : error management
        
        // Create and configure new email
        $mail = new PHPMailer;
        
        // activate debug and make it easier to read
//        $mail->SMTPDebug    = 3;
//        $mail->Debugoutput  = 'html';
        
        // Server info
        $mail->isSMTP();                                    // Set mailer to use SMTP                                   // Enable verbose debug output
        $mail->Host         = $smtp['server'];              // Specify main and backup SMTP servers
        $mail->SMTPAuth     = $smtp['useAuthentication'];   // Enable SMTP authentication
        $mail->Username     = $smtp['username'];            // SMTP username
        $mail->Password     = $smtp['password'];            // SMTP password
        $mail->SMTPSecure   = $smtp['secureConnection'];    // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = $smtp['port'];                // TCP port to connect to
       
        // Mail info
        $mail->setFrom($smtp['sender'], $smtp['sender']);   // Add sender and sender name
        $mail->addAddress($recipient);                      // Add a recipient
        if ($smtp['receiveEmailCopy']) { $mail->addCC($smtp['sender']); }   // Send a copy to sender ?
        
        // Mail attachments
        $mail->addAttachment($finalMotivationPdfFile,   'motivation.pdf');  // Add attachment and attachment name
        $mail->addAttachment(ATTACHMENT_PATH_CV,        'cv.pdf');          // Again
        $mail->isHTML(true);                                                // Set email format to HTML
        
        // Mail content
        $mail->Subject = $motivation['subject'];                                        // Set email subject
        $mail->Body    = sprintf(file_get_contents(TEMPLATE_EMAIL_PATH), $salutation);  // Set email body

        // Send email
        if(!$mail->send()) {
            return "<p class=\"small-info-error\">Une erreur est survenue durant l'envoi de l'email, contacte keninette bobby johnny !</p>";
        //    echo 'Mailer Error: ' . $mail->ErrorInfo; // todo error management
        }
        
        // Destroy custom motivation pdf file
        if ($finalMotivationPdfFile != ATTACHMENT_PATH_MOTIV_PDF) { unlink($finalMotivationPdfFile); }
        
        return "<p class=\"small-info-ok\">Email envoyé !</p>";
}
