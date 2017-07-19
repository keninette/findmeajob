<?php

/**
 * For every type of error, throw exception
 * Exceptions are logged in db
 * @param type $errno  
 * @param type $errstr
 * @param type $errfile
 * @param type $errline
 * @throws Exception
 */
function errorHandler($errno, $errstr, $errfile, $errline) {
    throw new Exception($errno .' ' .$errfile .' line ' .$errline .' : ' .$errstr);
}