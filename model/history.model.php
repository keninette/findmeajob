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
