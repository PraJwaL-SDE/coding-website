<?php

$servername = "localhost";
$username = "root";
$password = ""; // If there's no password, leave it empty
$database = "codingclub";
$table_name = "problems";

$connect = mysqli_connect($servername, $username, $password, $database);

$sql = "SELECT * FROM $table_name";
$result = mysqli_query($connect,$sql) or die("Fail to Connect Database");

$output = "";
$page = "home.html";
if(mysqli_num_rows($result) > 0){
    while($row = $result->fetch_assoc()){
        $output .= '<div class="problem" id="problem">
            <div class="problem-id" id="problem-id">' . $row["id"] . '</div>
            <div class="problem-title" id="problem-title">' . $row["title"] . '</div>
            <div class="problem-difficulty" id="problem-difficulty">' . $row["level"] . '</div>
            <div class="temp" id="temp"></div>
            <button class="problem-edit-btn" id="edit-btn" data-eid="' . $row["id"] . '" >Edit</button>
            <button class="problem-delete-btn" id="delete-btn" data-eid="' . $row["id"] . '">Delete</button>
        </div>';
    }
}
echo $output;

$connect->close();

?>