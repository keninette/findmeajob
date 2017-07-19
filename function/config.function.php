<?php

/**
 * Include or require file depending on its type
 * Using ob_...() and eval()
 * @param String $page : page being viewed
 * @param String $requireType : CONSTANT REQUIRE_... : type of file required
 * @param bool $mandatory (default false) : is file mandatory ?
 * @return String : the includeCommand to execute;
 */
function customRequire(String $page, String $requireType, bool $mandatory = false) {
    
    switch ($requireType) {
        
        // Require a JS file : all in the same directory
        case REQUIRE_JS_FILE:
            $filename       = 'public/js/' .$page .'.js';
            $includeCommand = 'echo \'<script src="' .$filename .'"><script>;\'';
            var_dump($includeCommand);
            
        // Require CSS file : all in the same directory
        case REQUIRE_CSS_FILE:
            $filename       = 'public/css/' .$page .'.css';
            $includeCommand = 'echo \'<link rel="stylesheet" type="text/css" href="' .$filename .'" />\'';
            var_dump($includeCommand);        
            
        // Require PHP file : we need to know in which folder it is
        // All view files follow the pattern view/page.view.php    
        // All controller files follow the pattern controller/page.controller.php    
        // All model files follow the pattern view/page.model.php    
        // All function files follow the pattern function/page.function.php    
        case REQUIRE_FUNCTION_FILE:
        case REQUIRE_CONTROLLER_FILE:
        case REQUIRE_MODEL_FILE:
        case REQUIRE_VIEW_FILE:
            $filename       = $requireType .'/' .$page .'.' .$requireType .'.php';
            $includeCommand = 'require_once \'' .$filename .'\';';
            var_dump($includeCommand);
    }

    // If not mandatory, check if file exists
    // Then try to include it
    if (! $mandatory) {
        if(file_exists($filename)) {
            ob_start();
            eval($includeCommand);
            ob_get_clean();
        }
        
    // If mandatory, try to include anyway, so an error is raised if it doesn't exist    
    } else {
        ob_start();
        eval($includeCommand);
        ob_get_clean();
    }
    
}