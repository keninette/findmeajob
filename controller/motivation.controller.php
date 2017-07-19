<?php

$motivation['subject'] = '';
$motivation['content'] = '';

// if form has been filled : store information into json file
// display this info
if (isset($_POST['form-motivation'])) {

    $motivation['subject'] = (string) htmlspecialchars($_POST['form-motivation']["subject"]);
    $motivation['content'] = (string) htmlspecialchars($_POST['form-motivation']["content"]);
    
    // if file already exists, replace content
    // else create and write into file
    $jsonFile = fopen(JSON_PATH_MOTIV, 'w');
    fwrite($jsonFile, json_encode($motivation));
    fclose($jsonFile);

// if form hasn't been filled
// look for json file
// if it exists, display content    
} else {    
    if (file_exists(JSON_PATH_MOTIV)) {
        $jsonData   = json_decode(file_get_contents(JSON_PATH_MOTIV), true); 
        $motivation['subject']    = $jsonData['subject'];
        $motivation['content']    = $jsonData['content'];
    }
}
