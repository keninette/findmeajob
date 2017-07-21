<?php

/**
 * Upload file given in parameters
 * @param array $file : $_FILE["form-name"]
 * @param String $key : key used for form-name[key] in input name
 * @param String $fullUploadPath : full upload file (including file name), use constants ATTACHMENT_...
 * @return String : HTML code to display message to user, just echo it in HTML template
 */
function uploadFile(array $file, String $key, String $fullUploadPath) :String {
    $basicErrorMsg  = "<p class=\"small-info-error\">Une erreur est survenue durant le téléchargement de votre pièce-jointe %s.</p>";
    
    if (!empty($file)) {
                
        $file = $file;

        // check if upload to temp dir has been successful
        if ($file["error"][$key] !== UPLOAD_ERR_OK) {
            return sprintf($basicErrorMsg, "(ERR_UPLOAD_INPUT)");
            // todo log error msg
        }

        // check file extension
        if (pathinfo($file["name"][$key], PATHINFO_EXTENSION) !== "pdf") {
            return "<p class=\"small-info-error\">Le document doit être au format PDF, téléchargement interrompu.</p>";
        }

        // preserve file from temporary directory
        $success = move_uploaded_file($file["tmp_name"][$key], $fullUploadPath);
        if (!$success) { 
            return sprintf($basicErrorMsg, "(ERR_UPLOAD_MOVE_FILE)");
            // todo log error msg
        }

        // set proper permissions on the new file
        chmod(ATTACHMENT_PATH_CV, 0644);
        
        // everything went fine, congrats !
        return "<p class=\"small-info-ok\">Le document a bien été téléchargé !</p>";
    }
}

/**
 * Hello Mofo !
 * Encode array into JSON and write it into file (overwrite it if already exists)
 * @param String $fullFileName : full file path including file name, use constant ATTACHMENT_...
 * @param array $dataToEncode : associative array to encode into JSON
 * @return string : HTML code to display, just use echo to print it
 */
function writeJsonFile(String $fullFileName, array $dataToEncode) :string {
    $basicErrorMessage = "<p class=\"small-info-error\">Une erreur est survenue durant la sauvegarde de la lettre de motivation %s</p>";
    
    // [Create and] open JSON file
    // We don't care about the old file, so we'll simply overwrite it
    $jsonFile = fopen($fullFileName, 'w');
    
    // if we couldn't create or open file, catch error
    if ($jsonFile === false) {
        return sprintf($basicErrorMessage, "(ERR_FOPEN_JSON_FILE)");
    }
    
    // Encode array into JSON and write file
    if (! fwrite($jsonFile, json_encode($dataToEncode))) {
        // if we couldn't write in file, catch error
        return sprintf($basicErrorMessage, "(ERR_WRITE_JSON_FILE)");
    }
    
    // Close JSON file
    // If we can't close it, catch error
    if (! fclose($jsonFile)) {
        return sprintf($basicErrorMessage, "(ERR_CLOSE_JSON_FILE)");
    } else {
        return "<p class=\"small-info-ok\">La sauvegarde de la lettre de motivation a bien été effectuée !</p>";
    }
}
 
/**
 * Turns motivation letter into PDF file
 * @param String $contactInfo : personnal contact info (name, address, phone, email, ...)
 * @param String $subject : subject of letter
 * @param String $content : content of letter (containing once "%s" in order to be able to customize content
 * @param String $customizedContent : customized content, to insert into letter where "%s" is
 */
function createMotivationPdfFile(String $contactInfo, String $subject, String $content, String $customizedContent, String $fileName = "") {
    // get pdf api
    require_once dirname(__DIR__) ."/public/vendor/mpdf60/mpdf.php";
    
    // get error message template and pdf template
    //$basicErrorMessage = "<p class=\"small-info-error\">Une erreur est survenue durant la sauvegarde de la lettre de motivation %s</p>";
    $htmlTemplate = file_get_contents(TEMPLATE_MOTIV_PATH);
    
    // customize pdf content
    // if there is some customized content to include, do it
    if (strpos($content, "%s") !== false) { $content = sprintf($content, $customizedContent); }
    
    // Replace 
    $pdfContent = sprintf($htmlTemplate, $contactInfo, $subject, $content);
    $pdfContent = str_replace("\r\n", "<br />", $pdfContent);
    
    // Create actual PDF file
    $mpdf = new mPDF();
    $mpdf->WriteHTML($pdfContent);
    $mpdf->Output($fileName === "" ? ATTACHMENT_PATH_MOTIV_PDF : $fileName, 'F');
    // todo handle errors and exceptions
    
    //return "";
}