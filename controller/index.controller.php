<?php

require_once 'function/application.function.php';
require_once 'model/history.model.php';

$pageTitle      = "Résumé";
$msg            = "";
$msgEmail       = "";
$displayData    = true;
$emailsSent     = true;

// if required page is the home page, we get all the info we need 
// in order to display them in dashboard
$data = getDashboardData();

if (isset($data["error"]) && $data["error"]) {
    $msg .= "<p class=\"small-info-error\">Une erreur est survenue durant la récupération des données</p>";
    $displayData = false;
} else {
    $data = $data[0];
    
    // if user clicked on "resend" link, resend all awaiting applications
    if(isset($_GET["target"]) && (string) $_GET["target"] === "resend") {
        
        // if there's no application to resend, just say so
        if ($data["oldApplicationsNb"] === 0) {
            $msg .= "<p class=\"small-info\">Il n'y a aucune candidature à relancer</p>";
        } else {
            $applicationsToResend = getApplicationsToResendData();
            
            if (isset($applicationsToResend["error"]) && $applicationsToResend["error"]) {
                $msg .= "<p class=\"small-info-error\">Une erreur est survenue durant le renvoi des candidatures</p>"; 
            } else {
                foreach($applicationsToResend as $thisApplication) {
                    // if $thisApplication is the "error" index, it's a boolean so we won't display it
                    if (!is_bool($thisApplication)) {
                        $msgEmail = sendMotivationEmail($thisApplication['email'], $thisApplication['salutation'], $thisApplication['customized_motivation']); 
                        
                        // if erverything went fine, update application's last_sent_date
                        if (isErrorMessage($msgEmail)) {
                            $emailsSent = false;
                        } else {
                            updateResentApplication($thisApplication['id'], $thisApplication['salutation'], $thisApplication['customized_motivation']);
                            $data['oldApplicationsNb']--;
                        }
                    }
                }
                
                // if one or multiple emails hasn't been sent correctly, tell the user
                // else just display the success message returned by sendMotivationEmail()
                $msg .= $emailsSent ? $msgEmail : '<p class="small-info-error">Une erreur est survenue pendant l\'envoi d\'un ou plusieurs mails</p>';
            }
        }
    }
}


