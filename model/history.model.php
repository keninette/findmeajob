<?php

/**
 * Get all applications info from database
 * @param array $filters : array containing all filters for query
 * @return array : applications retrived from database
 */
function getApplicationsHistory(array $filters = null) :array {
    
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
    
    // No filters : execute query as it is
    if (is_null($filters) || count($filters) === 0) {
        return pdoQuery(sprintf($query, ''));

    // Add filters and prepare query
    // Merge query & query filters
    // Execute query and return result set
    } else {
        return pdoPrepareQuery(sprintf($query, constructFiltersQuery($filters)), $filters);
    }
}

/**
 * Create a string to complete main query in order to include filters selected by user
 * @param array $filters : array of filters used
 * @return string : string to add to the main query
 */
function constructFiltersQuery(array $filters) :string {
    $queryFilters                       = '';
    $iterator                           = 0;
    $previousColumnName                 = '';
    $additionnalParenthesisOpened       = false;

    foreach ($filters as $filter) {
        // Construct query filter and prepare it for PDO bindParam()
        // If value is a bool, we have to compare column value to default timestamp
        // The result of this comparison should be what's in the bool value
        // If not, it's a string that gives us the column value we're looking for
        if (is_bool($filter[PDO_PARAM_ORDER_VALUE])) {

            // In order to construct correctly query filter
            // If both filters have been checked concerning the same column
            // We need to create a single condition for both filters
            // Which would give something like :
            //      WHERE   condition0
            //      AND     (column = value0 OR column = value1) <-- we work on this one (both conditions separed by OR create condition1)
            //      AND     condition2
            // To do that, we compare previous filter's column name and current filter's column name
            // If previous and current filters' column names are the same, we create the "OR" condition
            // Because the same column can NEVER satisfy both conditions
            if($filter[PDO_PARAM_ORDER_COLUMN_NAME] === $previousColumnName) {    
                $queryFilters .=    ' OR (' .addslashes($filter[PDO_PARAM_ORDER_COLUMN_NAME]) .' != \'' .DEFAULT_DB_DATE .'\') = ' .$filter[PDO_PARAM_ORDER_CODE];    


            // If filters' column names are different, it means we're using another filter
            // Therefore another "AND" condition
            // So, we close the additionnal parenthesis linking condition1.1 OR condition1.2 as a single condition1 if necessary
            // And we open a new additionnal parenthesis to be able to create another "OR" condition inside this one if necessary    
            } else {
                $queryFilters .=    ($additionnalParenthesisOpened ? ')' : '')  
                                    .($iterator === 0 ? ' WHERE ' : ' AND ')
                                    .'((' .addslashes($filter[PDO_PARAM_ORDER_COLUMN_NAME]) .' != \'' .DEFAULT_DB_DATE .'\') = ' .$filter[PDO_PARAM_ORDER_CODE];
                $additionnalParenthesisOpened = true;
            }
            $previousColumnName = $filter[PDO_PARAM_ORDER_COLUMN_NAME];
        } else {
            // Filter pattern : "WHERE/AND filterColumn =/LIKE :filterColumn
            $queryFilters .=    ($additionnalParenthesisOpened ? ')' : '')
                                .($iterator === 0 ? ' WHERE ' : ' AND ') 
                                .addslashes($filter[PDO_PARAM_ORDER_COLUMN_NAME]) .' = ' .$filter[PDO_PARAM_ORDER_CODE];        
            $additionnalParenthesisOpened = false;
        }

        // Increment iterator
        $iterator++;
    }

    // Don't forget to close the last additionnalParenthesis if it has been opened
    if ($additionnalParenthesisOpened) { $queryFilters .= ')'; }

    return $queryFilters;
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