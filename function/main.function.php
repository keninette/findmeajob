<?php 

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
 * Formatte une dateheure au format français
 * @param String $dateString : date à formater
 * @return String : date formatée
 */
function setDateFormat(String $dateString) :String {
    
    return $dateString === "0000-00-00 00:00:00" ? "Aucune" : date_format(date_create($dateString), "d/m/Y");
}