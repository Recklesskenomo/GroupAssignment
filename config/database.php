<?php
/* Database credentials */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');     // Default XAMPP username
define('DB_PASSWORD', '');         // Default XAMPP password
define('DB_NAME', 'number_world'); // Your database name

/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

/* Check connection */
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

/* Set charset to ensure proper encoding */
$mysqli->set_charset("utf8mb4");
?> 