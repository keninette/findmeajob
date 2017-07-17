<?php

require_once 'model/pdo.model.php';

$data = pdoQuery('SELECT * FROM emails_sent');
var_dump($data);