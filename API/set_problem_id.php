<?php
session_start();

// Check if the POST variable 'ProblemId' is set
if(isset($_POST['ProblemId'])){
    // Unset the session variable if it's already set
    if(isset($_SESSION['ProblemId'])){
        unset($_SESSION['ProblemId']);
    }
    // Set the session variable to the new ProblemId value
    $_SESSION['ProblemId'] = $_POST['ProblemId'];

    // Output '1' to indicate success
    echo "1";
} else {
    // Output an error message if ProblemId is not set in the POST data
    echo "Server Error";
}
?>
