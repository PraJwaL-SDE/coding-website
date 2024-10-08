<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // If there's no password, leave it empty
$database = "codingclub";
$table_name = "problems";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the problem ID is set in the request
if (isset($_POST['ProblemId'])) {
    $problemId = $_POST['ProblemId'];
    
    // Prepare SQL statement using prepared statement
    $stmt = $conn->prepare("DELETE FROM $table_name WHERE id = ?");
    $stmt->bind_param("i", $problemId);
    // Execute SQL query
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    // Close statement
    $stmt->close();
} else {
    // If the problem ID is not set, display an error message
    echo "Error: Problem ID not provided!";
}
// Close connection
$conn->close();
?>
