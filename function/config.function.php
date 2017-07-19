<?php

/**
 * Check if file exists before requiring it
 * @param String $filename : relative path FROM INDEX.PHP of file
 */
function customRequire(String $filename) :NULL {
    var_dump($filename);
    // Check if file exists
    if (file_exists($filename)) {
        
        // If it does, require it, but with custom relative path
        var_dump('../' .$filename);
        require_once '../' .$filename;
    }
}