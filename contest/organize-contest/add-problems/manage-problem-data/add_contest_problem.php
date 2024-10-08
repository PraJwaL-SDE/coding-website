<?php
// Database configuration
$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";
session_start();
$question_table_name = $_SESSION['contest_problem_table'];

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table if it does not exist
$createTableSql = "CREATE TABLE IF NOT EXISTS $question_table_name (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    problem_id INT(11) NOT NULL,
    problem_title VARCHAR(255) NOT NULL,
    problem_description TEXT,
    problem_example TEXT,
    problem_prefix_code TEXT,
    problem_postfix_code TEXT,
    empty_code TEXT,
    correct_code TEXT,
    example_test_case TEXT,
    test_case_1 TEXT,
    test_case_2 TEXT,
    test_case_3 TEXT,
    test_case_4 TEXT,
    test_case_5 TEXT,
    test_case_6 TEXT
)";

if ($conn->query($createTableSql) === TRUE) {
    // Table created successfully or already exists
} else {
    die("Error creating table: " . $conn->error);
}

// Retrieve posted data
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

// Prepare an SQL statement
$stmt = $conn->prepare("INSERT INTO $question_table_name (problem_id, problem_title, problem_description, problem_example, problem_prefix_code, problem_postfix_code, empty_code, correct_code, example_test_case, test_case_1, test_case_2, test_case_3, test_case_4, test_case_5, test_case_6) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssssssssssss", $problemId, $problemTitle, $problemDescription, $problemExample, $problemPrefixCode, $problemPostfixCode, $emptyCode, $correctCode, $exampleTestCase, $testCase1, $testCase2, $testCase3, $testCase4, $testCase5, $testCase6);

// Execute the statement
if ($stmt->execute()) {
    echo "1";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();

?>
