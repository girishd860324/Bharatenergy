<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'girish_deshmukh';

$mysqli = new mysqli($servername, $username, $password, $db);

// Check if the connection was successful
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Connection established successfully
?>
