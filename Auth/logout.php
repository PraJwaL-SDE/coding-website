<?php

if(isset($_COOKIE['email'])) {
    // Unset the email cookie by setting its expiration time to the past
    setcookie('email', '', time() - 3600, '/'); // Set expiration time in the past
    echo "1"; // Send success response
} else {
    echo "Error: Unable to logout"; // Send error response
}


?>