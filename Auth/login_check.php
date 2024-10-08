<?php
require_once "../database/login_values.php";

// Table name
$table_name = "users";

// Fetch input values
$email = $_POST['email']; // Changed from $username to $email
$password = $_POST['password'];

// SQL query to search for the email
$sql = "SELECT * FROM $table_name WHERE email = '$email'"; // Changed from username to email
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Email found, now check the password
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Password is correct
        $cookie_expiry = time() + (86400 * 30); // Cookie expires in 30 days
        
        // Set cookies for email, username, solved_table_name, and score
        setcookie("email", $email, $cookie_expiry, "/");
        setcookie("username", $row['username'], $cookie_expiry, "/");
        setcookie("solved_table_name", $row['solved_table_name'], $cookie_expiry, "/");
        setcookie("score", $row['score'], $cookie_expiry, "/");
        
        echo "1";
        // Redirect to the home page or do further processing
    } else {
        // Password is incorrect
        echo "Incorrect password!";
        // Handle the error, maybe show an error message to the user
    }
} else {
    echo "Email not found!";
}

?>
