<?php
// Database configuration
$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape special characters, if any
$organizer = $conn->real_escape_string($_POST['organizer']);
$title = $conn->real_escape_string($_POST['title']);
$description = $conn->real_escape_string($_POST['description']);
$date = $conn->real_escape_string($_POST['date']);
$timeFrom = $conn->real_escape_string($_POST['timeFrom']);
$timeTo = $conn->real_escape_string($_POST['timeTo']);
$format = $conn->real_escape_string($_POST['format']);
$motive = $conn->real_escape_string($_POST['motive']);
$benefit1 = $conn->real_escape_string($_POST['benefit1']);
$benefit2 = $conn->real_escape_string($_POST['benefit2']);
$benefit3 = $conn->real_escape_string($_POST['benefit3']);
$benefit4 = $conn->real_escape_string($_POST['benefit4']);
$organizerAbout = $conn->real_escape_string($_POST['organizerAbout']);
$buttonCount = $conn->real_escape_string($_POST['totalQue']);
$question_table_name = $organizer."_". $title . "_table";
// Prepare an SQL statement
$stmt = $conn->prepare("INSERT INTO contest (organizer, title, description, date, time_from, time_to, format, motive, benefit1, benefit2, benefit3, benefit4, organizer_about, total_question , question_table_name ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssssss", $organizer, $title, $description, $date, $timeFrom, $timeTo, $format, $motive, $benefit1, $benefit2, $benefit3, $benefit4, $organizerAbout, $buttonCount,$question_table_name);

session_start();
$_SESSION['contest_problem_table'] = $question_table_name;
// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
