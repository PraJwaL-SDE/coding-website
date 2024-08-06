<?php
require_once "../database/login_values.php";

// Assuming you've already established a database connection using $servername, $username, $password, and $database variables

// Table names
$user_table_name = "users";
$username_table_suffix = "_table"; // Suffix for user performance tables

// Fetch input values
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
// $solved_table_name = $_POST['solved_table_name'];
$score = 0;

// Check if the username already exists
$sql_check_username = "SELECT * FROM $user_table_name WHERE email = '$email'";
$result_check_username = $conn->query($sql_check_username);

if ($result_check_username->num_rows > 0) {
    // Username already exists
    echo "email already exists. Please choose a different email.";
} else {
    // Username is available, proceed with registration

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $solved_table_name = str_replace(' ', '', $username) . $username_table_suffix;
    // Insert new user into the user table
    $sql_register_user = "INSERT INTO $user_table_name (email, username, password, solved_table_name, score) VALUES ('$email', '$username', '$hashed_password', '$solved_table_name', $score)";

    if ($conn->query($sql_register_user) === TRUE) {
        // Registration successful, create the user's performance table
        $username_table_name = $username . $username_table_suffix;
        $sql_create_username_table = "CREATE TABLE $username_table_name (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            que_id INT(6) NOT NULL,
            solution TEXT,
            response TEXT,
            liked INT(6),
            comments TEXT
        )";

        if ($conn->query($sql_create_username_table) === TRUE) {
            // Performance table created successfully
            $cookie_name = "username";
            $cookie_value = $username;
            $cookie_expiry = time() + (86400 * 30); // Cookie expires in 30 days
            // Set the cookie
            setcookie($cookie_name, $cookie_value, $cookie_expiry, "/");
            echo "1";
            // Redirect to the home page or do further processing
        } else {
            // Error occurred during performance table creation
            echo "Error creating performance table: " . $conn->error;
            // Rollback registration? Delete user from user table?
        }
    } else {
        // Error occurred during registration
        echo "Error: " . $sql_register_user . "<br>" . $conn->error;
        // Handle the error, maybe show an error message to the user
    }
}

// Close the database connection
$conn->close();
?>
