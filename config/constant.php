<?php

// General
define('HOME_PAGE', 'index');

// Templates
define('TEMPLATE_EMAIL_PATH',    'view/template/email.template.html');
define('TEMPLATE_MOTIV_PATH',    'view/template/motivation.template.php');

// Attachments
define('ATTACHMENT_PATH_MOTIV_JSON',        'public/attachments/motivation.json');
define('ATTACHMENT_PATH_MOTIV_PDF',         'public/attachments/motivation.pdf');
define('ATTACHMENT_PATH_CV',                'public/attachments/cv.pdf');

// PDO
define('PDO_PARAM_ORDER_CODE',  0);
define('PDO_PARAM_ORDER_VALUE', 1);
define('PDO_PARAM_ORDER_TYPE',  2);

// Error codes
define('ERROR_CODE_PDO',    'PDO');
define('ERROR_CODE_UPLOAD', 'UPLOAD');
