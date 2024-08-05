<?php
include "../models/Problem.php";
session_start();
$ProblemId = $_SESSION['ProblemId'];
$servername = "localhost";
$username = "root";
$password = ""; // If there's no password, leave it empty
$database = "codingclub";
$table_name = "problems";

$connect = mysqli_connect($servername, $username, $password, $database);

$sql = "SELECT id, discription, level, example, prefix_code, postfix_code, empty_code, correct_code, sample_test_case, testCase1, testCase2, testCase3, testCase4, testCase5, testCase6, title, likes FROM $table_name WHERE id = $ProblemId";

// Execute SQL query
$result = $connect->query($sql);
$example = "";
$description = "";
$title = "";
$likes = 0;
$id = 1;
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $description = $row["discription"];
        $level = $row["level"];
        $example = $row["example"];
        $prefix_code = $row["prefix_code"];
        $postfix_code = $row["postfix_code"];
        $emptyCode = $row["empty_code"];
        $real_code = $row["correct_code"];
        $sample_test_case = $row["sample_test_case"];
        $testCases = array();
        for ($i = 1; $i <= 6; $i++) {
            $testCases["testCase$i"] = $row["testCase$i"];
        }
        $title = $row["title"];
        $likes = $row["likes"];
    }
} else {
    echo "Server error";
}

// Close connection
$connect->close();

$problem1 = new Problem($id, $description, $example, $real_code, $sample_test_case, $prefix_code, $postfix_code, $emptyCode);

$parameters = array(
    'id' => $problem1->getId(),
    'description' => $problem1->getDescription(),
    'example' => $problem1->getExample(),
    'Correct_code' => $problem1->getCorrectCode(),
    'sample_test_case' => $sample_test_case,
    'prefix_code' => $problem1->getPrefixCode(),
    'postfix_code' => $problem1->getPostfixCode(),
    'empty_code' => $problem1->getEmptyCode(),
    'title' => $title,
    'level' => $level
);

// Merge test cases array into parameters array
$parameters = array_merge($parameters, $testCases);

// Send the parameters as JSON
echo json_encode($parameters);
session_destroy();
?>
