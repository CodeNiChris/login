<?php

$dbHost = '127.0.0.1';
$dbUser = 'root';

$local = file_exists(__DIR__ . '/config.local.php') ? require __DIR__ . '/config.local.php' : [];

$dbPassword = '';

$conn = new mysqli($dbHost, $dbUser, $dbPassword, "bscs");

if (!$conn) {
    exit('Database connection failed.');
}
