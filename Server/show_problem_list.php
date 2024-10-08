<?php
require_once "../database/login_values.php";
$table_name = "problems";
$sql = "SELECT * FROM $table_name";
$result = mysqli_query($conn,$sql) or die("Fail to Connect Database");

$output = '<div class="title-row">
<div class="title-title">Title</div>
<div class="difficulty-title">Difficulty</div>
</div> ';
$page = "home.html";
if(mysqli_num_rows($result) > 0){
    while($row = $result->fetch_assoc()){
        $output .= '<div class="problem" id="problem">
            <div class="problem-id" id="problem-id">' . $row["id"] . ' </div>
            <div class="problem-title" id="problem-title"> ' . $row["title"] . '</div>
            <div class="problem-difficulty" id="problem-difficulty"> ' . $row["level"] . '</div>
            <button class="problem-solve-btn" id="solve-btn" data-eid="' . $row["id"] . '">solve</button>
        </div>';
    }
}
echo $output;

?>