<?php

require_once 'function/main.function.php';
require_once 'function/application.function.php';

// Titre de la page
$pageTitle  = "Historique des candidatures";
$msg        = "";
$companies  = [];

$postFilters        =   !is_null(filter_input_array(INPUT_POST)) 
                        && array_key_exists('application-filter',filter_input_array(INPUT_POST)) 
                        ? filter_input_array(INPUT_POST)['application-filter']  : null;
$postApplication    =   !is_null(filter_input_array(INPUT_POST)) 
                        && array_key_exists('application', filter_input_array(INPUT_POST))       
                        ? filter_input_array(INPUT_POST)['application']         : null;


// If one of the forms has been filled
switch (filter_input(INPUT_GET, 'target')) {
    
    // Update application
    case "update":
        if (!is_null($postApplication)) {
            $msg .= updateApplication(  (int) $_POST["application"]["id-update"]
                                        , (String) addslashes($_POST["application"]["answer_date"])
                                        , (String) addslashes($_POST["application"]["meeting_date"])
            );

        }
        
        break;

    // Re-send email
    case "resend":
        if (!is_null($postApplication)) {
            $msg .= sendMotivationEmail(
                        (String) addslashes($_POST["application"]["email"])
                        , (String) addslashes($_POST["application"]["salutation"])
                        , (String) addslashes($_POST["application"]["motivation"])
                    );
        
        // If everything went fine, we save today's date in last_sent_date column in application table
        // And update custom-motivation and salutation in case it has changed
        $msg .= updateResentApplication(  (int) $_POST["application"]["id-resend"]
                            , (String) addslashes($_POST["application"]["salutation"])
                            , (String) addslashes($_POST["application"]["motivation"]));
        }
        
        break;

    // Filters have been selected
    // Create array of arguments to pass onto pdoPrepareQuery() function 
    case 'filter':
        $args = createArgsForQuery($postFilters);
        break;
}

// Get all applications from database
$applications = getApplicationsHistory(isset($args) ? $args : null);

// If result is NULL, it means something went wrong
// As, even if query had returned no results, it would be an empty array
if (isset($applications["error"]) && $applications["error"]) { 
    $msg            .= "<p class=\"small-info-error\">Une erreur est survenue durant la récupération des candidatures</p>"; 
    $displayTable   = false;

// Else, we'll see if there's something to display, if not, we'll just display a message saying so in the jumbotron    
// count($applications) will always be at least equal to 1, because of the $application["error"]
} else {
    if (count($applications) > 1) {
        $displayTable   = true;
        
        // ---------------------- datalist management -------------------
        // Get all companies in an array we can work on (delete double entries and sort it alphabetically)
        $companies      = array_unique(array_column($applications, 'company'));
        sort($companies);
        // Get all recipients in an array, delete double entries and sort it alphabetically
        $recipients     = array_unique(array_column($applications, 'email'));
        sort($recipients);
    } else {
        $msg .= "<p class=\"small-info\">Il n'y a aucune candidature à afficher.</p>";
        $displayTable = false;
    }
}