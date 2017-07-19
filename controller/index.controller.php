<?php

// if url arguement "page" has been defined, use it
if (isset($_GET['page'])) {
    
    // get the page user asked for
    $page = (string) htmlspecialchars($_GET['page']);
    
    // if it's empty or if file doesn't exist, just redirect user on main page
    if ($page === '' || !(file_exists('controller/' .$page .'.controller.php') && file_exists('view/' .$page .'.inc.php'))) {
        $page = HOME_PAGE;
    }

// if not, send user on home page    
} else {
    $page = HOME_PAGE;
}

// require page functions, model (if they exist) and controller (mandatory)
customRequire('function/' .$page .'.function.php');
customRequire('model/' .$page .'.model.php');
require_once 'controller/' .$page .'.controller.php';
