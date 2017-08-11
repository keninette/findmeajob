<?php

/**
 * Get all data needed on dashboard from a single query
 * @return array : array containing info retrieved from database
 */
function getDashboardData() : array {
    $query = '
        SELECT  COUNT(id)                                                                           AS applicationsNb
                , SUM(IF(answer_date = \'0000-00-00 00:00:00\', 0, 1))                              AS answeredApplicationsNb
                , SUM(IF(meeting_date = \'0000-00-00 00:00:00\', 0, 1))                             AS meetingsGrantedNb
                , SUM(IF(
                    (last_sent_date = \'0000-00-00 00:00:00\' OR last_sent_date < (NOW() - INTERVAL 10 DAY))
                    AND     meeting_date    = \'0000-00-00 00:00:00\' 
                    AND     answer_date     = \'0000-00-00 00:00:00\' 
                , 1, 0)) AS oldApplicationsNb
        FROM    applications        
    ';
    
    // Execute query and return result set
    return pdoQuery($query);
}

/**
 * Gets all applications that need to be sent again
 *  -> the one having no answer or meeting date
 *  -> which have never been resent or having a last_sent_date more than 10 days old
 * @return type
 */
function getApplicationsToResendData() {
    $query = '
        SELECT  id
                , email
                , salutation
                , customized_motivation
        FROM    applications
        WHERE   (last_sent_date  = \'0000-00-00 00:00:00\' 
        OR      last_sent_date  < (NOW() - INTERVAL 10 DAY))
        AND     meeting_date    = \'0000-00-00 00:00:00\' 
        AND     answer_date     = \'0000-00-00 00:00:00\' ;
    ';
    
    return pdoQuery($query);
}