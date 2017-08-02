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
                , SUM(IF(last_sent_date = \'0000-00-00 00:00:00\' OR last_sent_date < (NOW() - INTERVAL 10 DAY), 1, 0)) AS oldApplicationsNb
        FROM    applications        
    ';
    
    // Execute query and return result set
    return pdoQuery($query);
}