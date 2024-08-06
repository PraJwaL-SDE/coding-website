<?php
session_start();
// $_SESSION['ProblemId'] = $_POST['ProblemId'];

if(isset($_SESSION['ProblemId'])){
    echo $_SESSION['ProblemId'];
    unset($_SESSION['ProblemId']); // Unset the session variable
}
else
    echo "Server error";

?>