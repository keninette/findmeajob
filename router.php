<?php 
        
// require all mandatory components
require_once 'config/ini.config.php';
require_once 'config/constant.php';
require_once 'model/pdo.model.php';
require_once 'model/error.model.php';

// if url arguement "page" has been defined, use it
if (isset($_GET['page'])) {

    // get the page user asked for
    $page = (string) htmlspecialchars($_GET['page']);
    
    // if it's empty or if file doesn't exist, just redirect user on main page
    if ($page === '' || ! file_exists('view/' .$page .'.view.php')) {
        $page = HOME_PAGE;
    }

// if not, send user on home page    
} else {
    $page = HOME_PAGE;
}

// require page functions, model and controller (if they exist)
$filename = 'function/' .$page .'.function.php';
if (file_exists($filename)) { require_once $filename; }
$filename = 'model/' .$page .'.model.php';
if (file_exists($filename)) { require_once $filename; }
$filename = 'controller/' .$page .'.controller.php';
if (file_exists($filename)) { require_once $filename; }