<?php
session_start();
isset($_SESSION['ProblemId']);
$_SESSION['ProblemId'] = $_POST['ProblemId'];

echo "1";


?>