<?php

$pageTitle = "Lettre de motivation & CV";

// a form has been filled
if (isset($_GET['target'])) {

    switch($_GET['target']) {
        
        // cv form has been filled : upload cv
        case 'cv':
            $msg = uploadFile($_FILES["form-motivation"], "cv", ATTACHMENT_PATH_CV);
            break;
        
        // motivation form has been filled : create json file and pdf
        case 'motivation':
            
            if (isset($_POST['form-motivation'])) {
                $motivation['contact'] = (string) addslashes($_POST['form-motivation']["contact"]);
                $motivation['subject'] = (string) addslashes($_POST['form-motivation']["subject"]);
                $motivation['content'] = (string) addslashes($_POST['form-motivation']["content"]);

                // if file already exists, replace content
                // else create and write into file
                $msg = writeJsonFile(ATTACHMENT_PATH_MOTIV_JSON, $motivation);

                // create motivation pdf (without customization)
                createMotivationPdfFile($motivation['contact'], $motivation['subject'], $motivation['content'], "");
                break;
            }       
    }    
}

// if motivation part of form hasn't been filled
// look for json file
// if it exists, display content
if (! isset($motivation['subject']) || ! isset($motivation['content']) || ! isset($motivation['contact'])) {
    if (file_exists(ATTACHMENT_PATH_MOTIV_JSON)) {
        $jsonData   = json_decode(file_get_contents(ATTACHMENT_PATH_MOTIV_JSON), true); 
        $motivation['contact']    = $jsonData['contact'];
        $motivation['subject']    = $jsonData['subject'];
        $motivation['content']    = $jsonData['content'];
    
    // else you still need to set these variables
    // or you will trigger an error in view
    // you don't check if they are set in view in order to keep php code in view at its minimum    
    } else {
        $motivation['contact']    = '';
        $motivation['subject']    = '';
        $motivation['content']    = '';
    }
}
