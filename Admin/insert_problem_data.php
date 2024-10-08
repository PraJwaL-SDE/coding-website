<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // If there's no password, leave it empty
$database = "codingclub";
$table_name = "problems";

// Get the data sent via POST
$problemId = $_POST['problemId'];
$problemTitle = $_POST['problemTitle'];
$problemDescription = $_POST['problemDescription'];
$problemExample = $_POST['problemExample'];
$problemPrefixCode = $_POST['problemPrefixCode'];
$problemPostfixCode = $_POST['problemPostfixCode'];
$emptyCode = $_POST['emptyCode'];
$correctCode = $_POST['correctCode'];
$exampleTestCase = $_POST['exampleTestCase'];
$testCase1 = $_POST['testCase1'];
$testCase2 = $_POST['testCase2'];
$testCase3 = $_POST['testCase3'];
$testCase4 = $_POST['testCase4'];
$testCase5 = $_POST['testCase5'];
$testCase6 = $_POST['testCase6'];

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the problem ID already exists in the database
$stmt = $conn->prepare("SELECT id FROM $table_name WHERE id = ?");
$stmt->bind_param("i", $problemId);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    // If the ID exists, update the record
    $stmt = $conn->prepare("UPDATE $table_name SET title=?, discription=?, example=?, prefix_code=?, postfix_code=?, empty_code=?, correct_code=?, sample_test_case=?, testCase1=?, testCase2=?, testCase3=?, testCase4=?, testCase5=?, testCase6=? WHERE id=?");
    $stmt->bind_param("ssssssssssssssi", $problemTitle, $problemDescription, $problemExample, $problemPrefixCode, $problemPostfixCode, $emptyCode, $correctCode, $exampleTestCase, $testCase1, $testCase2, $testCase3, $testCase4, $testCase5, $testCase6, $problemId);
} else {
    // If the ID doesn't exist, insert a new record
    $stmt = $conn->prepare("INSERT INTO $table_name (id, title, discription, example, prefix_code, postfix_code, empty_code, correct_code, sample_test_case, testCase1, testCase2, testCase3, testCase4, testCase5, testCase6, likes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("issssssssssssss", $problemId, $problemTitle, $problemDescription, $problemExample, $problemPrefixCode, $problemPostfixCode, $emptyCode, $correctCode, $exampleTestCase, $testCase1, $testCase2, $testCase3, $testCase4, $testCase5, $testCase6);
}

// Execute SQL query
if ($stmt->execute()) {
    echo "Record created/updated successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
