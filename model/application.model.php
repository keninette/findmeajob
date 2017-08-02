<?php

/**
 * Prepares query and insert application into database
 * @param array $formApplication : $POST[form-application] array, what has been provided in application form
 * @return String : html code container error or success message, just echo() it !
 */
function insertApplicationIntoDb(array $formApplication) :String {
    
    // Write insert query
    $query = '
        INSERT INTO applications
                    (email,     salutation,     company,    customized_motivation)
        VALUES      (:email,    :salutation,    :company,   :customized_motivation);
    ';
    
    // Create array of arguments to be passed onto the pdoPrepareQuery() function
    // This array will contain associative arrays following this pattern :
    //      array(
    //          PDO_PARAM_ORDER_CODE    => ":code_param"
    //          , PDO_PARAM_ORDER_VALUE => "param_value"
    //          , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_...
    //      );
    
    // $arguments is the main array, the one we will pass onto the pdoPrepareQuery() function
    $arguments = array(
        array(
            PDO_PARAM_ORDER_CODE    => ":email"
            , PDO_PARAM_ORDER_VALUE => $formApplication['email']
            , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_STR
        )
        , array(
            PDO_PARAM_ORDER_CODE    => ":salutation"
            , PDO_PARAM_ORDER_VALUE => $formApplication['salutation']
            , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_STR
        )
        , array(
            PDO_PARAM_ORDER_CODE    => ":company"
            , PDO_PARAM_ORDER_VALUE => $formApplication['company']
            , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_STR
        )
        , array(
            PDO_PARAM_ORDER_CODE    => ":customized_motivation"
            , PDO_PARAM_ORDER_VALUE => $formApplication['motivation']
            , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_STR
        )
    );
    
    // Now that everything's ready, we can (finally!) insert application into database
    // Here, we don't need no data return, but we still want to know if everything went fine
    if (pdoPrepareQuery($query, $arguments)["error"]) {
        return "<p class=\"small-info-error\">Une erreur est survenue durant l'enregistrement de la candidature en base de données. </p>";
    } else {
        return "<p class=\"small-info-ok\">L'enregistrement de la candidature en base de données a bien été effectué !</p>";
    }
}