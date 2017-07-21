<?php

// GMAIL SMTP INFO
//    Outgoing Mail (SMTP) Server: smtp.gmail.com
//    Use Authentication: Yes
//    Use Secure Connection: Yes (TLS or SSL depending on your mail client/website SMTP plugin)
//    Username: your Gmail account (e.g. user@gmail.com)
//    Password: your Gmail password
//    Port: 465 (SSL required) or 587 (TLS required)

$smtp['server']             = 'smtp.gmail.com';
$smtp['secureConnection']   = "TLS";
$smtp['useAuthentication']  = true;
$smtp['username']           = 'smtp.jeangilles@gmail.com';
$smtp['sender']             = $smtp['username'];
$smtp['senderName']         = 'Jean-Gilles';
$smtp['password']           = 'nobodyputsbabyinacorner./GM';
$smtp['port']               = 587;
$smtp['receiveEmailCopy']   = true;