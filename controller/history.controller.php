<?php

require_once 'function/main.function.php';
require_once 'function/application.function.php';

// Titre de la page
$pageTitle = "Historique des candidatures";
$msg = "";

// If one of the forms has been filled
if (isset($_GET['target']) && isset($_POST['application'])){
    
    switch ($_GET['target']) {
        
        case "update":
            $msg .= updateApplication(  (int) $_POST["application"]["id-update"]
                                        , (String) htmlspecialchars($_POST["application"]["answer_date"])
                                        , (String) htmlspecialchars($_POST["application"]["meeting_date"])
            );
            
            break;
           
        case "resend":
            
            // Send email
            $msg .= sendMotivationEmail(
                (String) htmlspecialchars($_POST["application"]["email"])
                , (String) htmlspecialchars($_POST["application"]["salutation"])
                , (String) htmlspecialchars($_POST["application"]["motivation"])
            );
            
            // If everything went fine, we save today's date in last_sent_date column in application table
            // And update custom-motivation and salutation in case it has changed
            $msg .= updateResentApplication(  (int) $_POST["application"]["id-resend"]
                                , (String) htmlspecialchars($_POST["application"]["salutation"])
                                , (String) htmlspecialchars($_POST["application"]["motivation"]));
            
            break;
    }
}


// Get all applications from database
$applications = getAllApplicationsHistory();

// If result is NULL, it means something went wrong
// As, even if query had returned no results, it would be an empty array
if (isset($applications["error"]) && $applications["error"]) { 
    $msg            .= "<p class=\"small-info-error\">Une erreur est survenue durant la récupération des candidatures</p>"; 
    $displayTable   = false;

// Else, we'll see if there's something to display, if not, we'll just display a message saying so in the jumbotron    
// count($applications) will always be at least equal to 1, because of the $application["error"]
} else {
    if (count($applications) > 1) {
        $displayTable = true;
    } else {
        $msg .= "<p class=\"small-info\">Il n'y a aucune candidature à afficher.</p>";
        $displayTable = false;
    }
}