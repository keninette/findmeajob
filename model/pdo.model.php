<?php

function pdoQuery($query) {
    
    // Get db info
    require_once 'config/db_config.php';
    
    // Connect to database
    $pdo = new PDO($dsn, $user, $pwd);
    var_dump($pdo);
    
    // Execute query
    $data = $pdo->query($query)->fetchAll();
    
    // Disconnect from database
    $pdo = null;
    
    // Return dataset
    return $data;
}

