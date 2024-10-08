<?php
// Define global variables
$servername = "localhost";
$username = "root";
$password = ""; // If there's no password, leave it empty
$database = "codingclub";
$table_name = "problems";

// Your PHP code goes here
// For example:
// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Rest of your PHP code
?>
