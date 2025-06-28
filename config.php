<?php
session_start();
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'project_db';

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME)
  or die('DB Connection Error');
mysqli_set_charset($conn, 'utf8mb4');
?>`