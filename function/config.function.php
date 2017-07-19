<?php

/**
 * Check if file exists before requiring it
 * @param String $filename : relative path FROM INDEX.PHP of file
 */
function customRequire(String $filename) {
    // Check if file exists
    if (file_exists($filename)) {
        var_dump('required : ' .$filename);
        // If it does, require it, but with custom relative path
        require_once $filename;
    }
}