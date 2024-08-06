<?php
// Check if cookies are set
if(isset($_COOKIE['email']) && isset($_COOKIE['username']) && isset($_COOKIE['solved_table_name']) && isset($_COOKIE['score'])) {
    // Create an array to store profile data
    $profileData = array(
        'email' => $_COOKIE['email'],
        'username' => $_COOKIE['username'],
        'solved_table_name' => $_COOKIE['solved_table_name'],
        'score' => $_COOKIE['score']
    );

    // Encode profile data as JSON
    $jsonData = json_encode($profileData);

    // Set appropriate headers for JSON response
    header('Content-Type: application/json');

    // Output JSON data
    echo $jsonData;
} else {
    // If any of the cookies is not set, return an error message
    echo json_encode(array('error' => 'Difficulty in getting user data'));
}
?>
