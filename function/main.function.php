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