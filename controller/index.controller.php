<?php

$pageTitle      = "Résumé";
$msg            = "";
$displayData    = true;

// if url arguement "page" has been defined, use it
if (isset($_GET['page'])) {

    // get the page user asked for
    $page = (string) htmlspecialchars($_GET['page']);
    
    // if it's empty or if file doesn't exist, just redirect user on main page
    if ($page === '' || !(file_exists('controller/' .$page .'.controller.php') && file_exists('view/' .$page .'.view.php'))) {
        $page = HOME_PAGE;
    }

// if not, send user on home page    
} else {
    $page = HOME_PAGE;
}

// require page functions, model (if they exist) and controller (mandatory)
$filename = 'function/' .$page .'.function.php';
if (file_exists($filename)) { require_once $filename; }
$filename = 'model/' .$page .'.model.php';
if (file_exists($filename)) { require_once $filename; }
$filename = 'controller/' .$page .'.controller.php';
require_once $filename;

// if required page is the home page, we get all the info we need
if ($page === HOME_PAGE) {
    $data = getDashboardData();
    
    if (isset($data["error"]) && $data["error"]) {
        $msg .= "<p class=\"small-info-error\">Une erreur est survenue durant la récupération des données</p>";
        $displayData = false;
    }
}