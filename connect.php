<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "hospital";

// Create connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if (!$con) {
    die("Connection failed: " . $con->connect_error);
}
?>