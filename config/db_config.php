<?php

// Server info
$server = 'localhost';
$port   = 3306;
$user   = 'root';
$pwd    = 'runyoucleverboyandremember./MYSQL';
$dbname = 'findmeajob';

// Create DSN
$dsn    = sprintf('mysql:dbname=%s;host=%s:%d', $dbname, $server, $port);