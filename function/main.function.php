<?php 

require_once 'config/constant.php';

/**
 * Generate a token of random characters
 * @param int $tokenLength : token's length
 * @return String : random token
 */
function generateToken(int $tokenLength) :String {
    $token = "";
    // Store all allowed chars into a string, separated from each other by a coma
    $str = 'a,A,b,B,c,C,d,D,e,E,f,F,g,G,h,H,i,I,j,J,k,K,l,L,m,M,n,N,o,O,p,P,q,Q,r,R,s,S,t,T,u,U,v,V,w,W,x,X,y,Y,z,Z,_,-,#,€,$,£';
    // Explode this string to create an array we can use rand() on
    $chars = explode($str, ",");
    
    // Create a token of $tokenLength length
    for ($i = 0; $i < $tokenLength; $i++) {
        $token .= $chars[rand(0, (count($chars) - 1))];
    }
    
    return $token;
}

/**
 * Formate une dateheure au format désiré
 * Soit au format français si la date est extraite de la base de données
 * Soit au format Timestamp mysql (YYYY-mm-dd HH:ii:ss)
 * @param String $dateString : date à formater
 * @return String : date formatée
 */
function setDateFormat(String $dateString) :String {
    
    // In order to make this syntax work
    // We need to be sure that all cases are written in the right order
    // For instance, if date equals "0000-00-00 00:00:00", it will match first and third case
    // But we want it to be formated as "Aucune"
    // So the first case really need to be in that position
    // No need to use "break" command since we return the date inside each case
    switch(true) {
        
        case ($dateString === DEFAULT_DB_DATE):
            return "Aucune";
           
        case ($dateString ==="Aucune"):
            return DEFAULT_DB_DATE;
            
        // Check if the date matches the "YYYY-mm-dd HH:ii:ss" pattern    
        case (preg_match("/^\d{4}[-]{1}\d{2}[-]{1}\d{2} \d{2}[:]{1}\d{2}[:]{1}\d{2}$/", $dateString)):
            return date_format(new DateTime($dateString), "d/m/Y");
        
        // Check if the date matches the "dd/mm/YYYY" pattern    
        case (preg_match("/^\d{2}[\/]{1}\d{2}[\/]{1}\d{4}$/", $dateString)):
            // We have to tell in which format is the date before we can create a real DateTime object
            // Since we use french format, days come before months (as the english format would be month before days)
            // If we don't specify the format, an error will occure and the DateTime object won't be created
            return date_format(DateTime::createFromFormat("d/m/Y", $dateString), "Y-m-d H:i:s");
            
        default:
            return "";
    }
}

/**
 * Look in the msg given in argument if there is a class with "error" in it
 * $mag must be html string returned by a function
 * so it will have a .small-info-ok or small-info-error class
 * @param String $msg : html code returned by a function containing success or error message
 * @return bool : true -> it's an error message, false -> it isn't ("error" from class hasn't been found)
 */
function isErrorMessage(String $msg) :bool{
    return strpos($msg, "error") > 0;
}