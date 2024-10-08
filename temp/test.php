<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code'])) {
    $cppCode = $_POST['code'];

    $cppFile = tempnam(sys_get_temp_dir(), 'code_') . '.cpp';
    file_put_contents($cppFile, $cppCode);

    $executable = tempnam(sys_get_temp_dir(), 'executable_');

    $compileCommand = "g++ -o $executable $cppFile 2>&1"; // Redirect stderr to stdout for capturing compilation errors
    exec($compileCommand, $output, $returnCode);

    if ($returnCode === 0) {
        // Compilation successful, run the executable
        exec($executable, $output, $returnCode);

        // Output the result
        $outputText = implode("\n", $output);
        
        // Create and write output to a file
        $outputFile = 'output.txt';
        file_put_contents($outputFile, $outputText);

        echo json_encode(['success' => true, 'outputFile' => $outputFile]);
    } else {
        // Compilation failed, output error message
        $outputText = implode("\n", $output);
        echo json_encode(['success' => false, 'error' => $outputText]);
    }
    
    // Clean up temporary files
    unlink($cppFile);
    unlink($executable);
    exit;
}
?>
