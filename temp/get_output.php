<?php
    // include 'compileJava.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (file_exists('output.txt')) {
        $outputText = file_get_contents('output.txt');
        // echo json_encode(['success' => true, 'output' => $outputText]);
        // if($outputText ==="") echo "Something went wrong. please submit again.";
        // else
        echo  $outputText ;
        unlink('output.txt'); // Delete the temporary output file
    } else {
        echo "Trying to connect with server";
        // echo json_encode(['success' => false, 'error' => $output]);
    }
    exit;
}

?>
