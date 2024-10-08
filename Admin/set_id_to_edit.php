<?php
session_start();
// isset($_SESSION['ProblemId']);
if(isset($_SESSION['ProblemId'])){
    // echo $_SESSION['ProblemId'];
    unset($_SESSION['ProblemId']); // Unset the session variable
}
$_SESSION['ProblemId'] = $_POST['ProblemId'];

echo "1";


?>