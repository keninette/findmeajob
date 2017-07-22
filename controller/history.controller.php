<?php

require_once 'function/main.function.php';

// Titre de la page
$pageTitle = "Historique des candidatures";

// Get all applications from database
$applications = getAllApplicationsHistory();

// If result is NULL, it means something went wrong
// As, even if query had returned no results, it would be an empty array
if (is_null($applications)) { 
    $msg            = "<p class=\"small-info-error\">Une erreur est survenue durant la récupération des candidatures</p>"; 
    $displayTable   = false;

// Else, we'll see if there's something to display, if not, we'll just display a message saying so in the jumbotron    
} else {
    if (count($applications) > 0) {
        $displayTable = true;
    } else {
        $msg = "<p class=\"small-info\">Il n'y a aucune candidature à afficher.</p>";
        $displayTable = false;
    }
}