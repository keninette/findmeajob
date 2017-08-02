<?php

/**
 * Get all applications info from database
 * @return array : applications retrived from database
 */
function getAllApplicationsHistory() :array {
    
    // Write query to get applications
    $query = '
        SELECT      id
                    , first_sent_date
                    , last_sent_date
                    , email
                    , salutation
                    , company
                    , customized_motivation
                    , answer_date
                    , meeting_date
        FROM        applications
        ORDER BY    company;
    ';
    
    // Execute query and restun result set
    return pdoQuery($query);
}

/**
 * Update an application that's been sent again
 * @param int $id : application's id
 * @param String $salutation : updated salutation
 * @param String $motivation : updated motivation customization
 * @return String : message to be displayed to user, html coded
 */
function updateResentApplication(int $id, String $salutation, String $motivation) :String {
    $query = '
        UPDATE  applications
        SET     last_sent_date          = NOW()
                , salutation            = :salutation
                , customized_motivation = :motivation
        WHERE   id                      = :id
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
            PDO_PARAM_ORDER_CODE    => ":id"
            , PDO_PARAM_ORDER_VALUE => $id
            , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_INT
        )
        , array(
            PDO_PARAM_ORDER_CODE    => ":salutation"
            , PDO_PARAM_ORDER_VALUE => $salutation
            , PDO_PARAM_ORDER_TYPE  => pdo::PARAM_STR
        )
        , array(
            PDO_PARAM_ORDER_CODE    => ":motivation"
            , PDO_PARAM_ORDER_VALUE => $motivation
            , PDO_PARAM_ORDER_TYPE  => pdo::PARAM_STR
        )
    );
    
    // Here, we don't need no data return, but we still want to know if everything went fine
    if (pdoPrepareQuery($query, $arguments)["error"]) {
        return "<p class=\"small-info-error\">Une erreur est survenue durant la mise à jour de la candidature en base de données. </p>";
    } else {
        return "<p class=\"small-info-ok\">La mise à jour de la candidature en base de données a bien été effectuée !</p>";
    }
}

function updateApplication(int $id, String $answerDate, String $meetingDate) {
    $query = '
        UPDATE  applications
        SET     answer_date     = :answer_date
                , meeting_date  = :meeting_date
        WHERE   id              = :id
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
            PDO_PARAM_ORDER_CODE    => ":id"
            , PDO_PARAM_ORDER_VALUE => $id
            , PDO_PARAM_ORDER_TYPE  => PDO::PARAM_INT
        )
        , array(
            PDO_PARAM_ORDER_CODE    => ":answer_date"
            , PDO_PARAM_ORDER_VALUE => setDateFormat($answerDate)
            , PDO_PARAM_ORDER_TYPE  => pdo::PARAM_STR
        )
        , array(
            PDO_PARAM_ORDER_CODE    => ":meeting_date"
            , PDO_PARAM_ORDER_VALUE => setDateFormat($meetingDate)
            , PDO_PARAM_ORDER_TYPE  => pdo::PARAM_STR
        )
    );
        
    // Here, we don't need no data return, but we still want to know if everything went fine
    if (pdoPrepareQuery($query, $arguments)["error"]) {
        return "<p class=\"small-info-error\">Une erreur est survenue durant la mise à jour de la candidature en base de données. </p>";
    } else {
        return "<p class=\"small-info-ok\">La mise à jour de la candidature en base de données a bien été effectuée !</p>";
    }
}