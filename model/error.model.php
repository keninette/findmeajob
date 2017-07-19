<?php

/**
 * Write error into database
 * @param String $code : code erreur 
 * @param String $msg : contenu du message
 */
function writeError(String $code, String $msg) :NULL {
    
    // Prepare
    $query = '
        INSERT INTO errors
                    (code, message)
        VALUES      (:code, :message);
    ';
    
    pdoPrepareQuery($query, array(
        array(':code',      $code,  PDO::PARAM_STR)
        , array(':message', $msg,   PDO::PARAM_STR)
    ));

}

