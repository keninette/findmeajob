<?php

$motivation = [];

// if form has been filled : store information into json file
// display this info
if (isset($_POST['form-motivation'])) {

    $motivation['subject'] = (string) htmlspecialchars($_POST['form-motivation']["subject"]);
    $motivation['content'] = (string) htmlspecialchars($_POST['form-motivation']["content"]);
    
    if (!(file_exists(JSON_PATH_MOTIV) && fopen(JSON_PATH_MOTIV, 'w'))) {
        fwrite(JSON_PATH_MOTIV, json_encode($motivation));
        fclose(JSON_PATH_MOTIV);
    }

// if form hasn't been filled
// look for json file
// if it exists, display content    
} else {    
    if (file_exists(JSON_PATH_MOTIV)) {
        
        $jsonData   = json_decode(file_get_contents(JSON_PATH_MOTIV), true); 
        $subject    = $jsonData['subject'];
        $content    = $jsonData['content'];
    }
}