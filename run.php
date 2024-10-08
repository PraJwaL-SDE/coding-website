<?php
// Database configuration
// include "./database/login_values.php";
// Create a connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the contest table
// $sql = "CREATE TABLE contest (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     organizer VARCHAR(255),
//     title VARCHAR(255),
//     description TEXT,
//     date DATE,
//     time_from TIME,
//     time_to TIME,
//     format VARCHAR(50),
//     motive TEXT,
//     benefit1 VARCHAR(255),
//     benefit2 VARCHAR(255),
//     benefit3 VARCHAR(255),
//     benefit4 VARCHAR(255),
//     organizer_about TEXT,
//     total_question INT,
//     question_table_name VARCHAR(255)
// )";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table 'contest' created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
$conn->close();
?>
