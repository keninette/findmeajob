<?php

/**
 * Get all applications info from database
 * @param array $filters : array containing all filters for query
 * @return array : applications retrived from database
 */
function getApplicationsHistory(array $filters = null) :array {
    $queryFilters = '';
    
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
        %s
        ORDER BY    company;
    ';
    
    // Add filters and prepare query if necessary
    // Merge query & query filters
    // Execute query and return result set
    if(!is_null($filters) && count($filters) > 0) {
        $iterator               = 0;
        $previousColumnName     = '';
        $previousConditionOr    = false;
        
        foreach ($filters as $filter) {
            // Construct query filter and prepare it for PDO bindParam()
            // If value is a bool, we have to compare column value to default timestamp
            // The result of this comparison should be what's in the bool value
            // If not, it's a string that gives us the column value we're looking for
            
            // WHERE 1=1
            // AND 2=2
            // AND (3=3 OR 4=4)
            if (is_bool($filter[PDO_PARAM_ORDER_VALUE])) {
                if($filter[PDO_PARAM_ORDER_COLUMN_NAME] === $previousColumnName) {    
                    $queryFilters .=    ' OR (' .addslashes($filter[PDO_PARAM_ORDER_COLUMN_NAME]) .'= \'' .DEFAULT_DB_DATE .'\') = ' .$filter[PDO_PARAM_ORDER_CODE];    
                    $previousConditionOr = true;
                } else {
                    $queryFilters .=    $previousConditionOr ? ')' : '' 
                                        .($iterator === 0 ? ' WHERE ' : ' AND ')
                                        .'((' .addslashes($filter[PDO_PARAM_ORDER_COLUMN_NAME]) .'= \'' .DEFAULT_DB_DATE .'\') = ' .$filter[PDO_PARAM_ORDER_CODE];
                    $previousConditionOr = false;
                }
                $previousColumnName = $filter[PDO_PARAM_ORDER_COLUMN_NAME];
            } else {
                // Filter pattern : "WHERE/AND filterColumn =/LIKE :filterColumn
                $queryFilters .=     ($iterator === 0 ? ' WHERE ' : ' AND ') 
                                    .addslashes($filter[PDO_PARAM_ORDER_COLUMN_NAME]) .' = ' .$filter[PDO_PARAM_ORDER_CODE];        
            }
            
            // Increment iterator
            $iterator++;
        }
        if ($previousConditionOr) { $queryFilters .= ')'; }
        var_dump(sprintf($query, $queryFilters));
        return pdoPrepareQuery(sprintf($query, $queryFilters), $filters);
    
        
    } else {
        return pdoQuery(sprintf($query, $queryFilters));
    }
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