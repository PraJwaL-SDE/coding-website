<?php
$javaCode = $_POST['code'] ?? '';
$customTestCase = $_POST['CustomTestCase'] ?? '';

if (empty($javaCode)) {
    echo "Java code is empty.";
    exit;
}

// Find the class name from the code
if (!preg_match('/class\s+(\w+)/', $javaCode, $matches)) {
    echo "Failed to extract class name from Java code.";
    exit;
}

$className = $matches[1];
$javaFileName = $className . '.java';
$outputFile = 'output.txt';

// Save the Java code to a file
$javaFile = tempnam(sys_get_temp_dir(), 'code_') . '.java';
if (file_put_contents($javaFile, $javaCode) === false) {
    echo "Failed to write Java code to file.";
    exit;
}

// Rename the Java file to match the class name
$renamedJavaFile = dirname($javaFile) . DIRECTORY_SEPARATOR . $javaFileName;
if (!rename($javaFile, $renamedJavaFile)) {
    echo "Failed to rename Java file.";
    exit;
}

// Compilation command
$compileCommand = "javac $renamedJavaFile 2>&1";

// Execute compilation
exec($compileCommand, $output, $returnCode);

if ($returnCode === 0) {
    // Compilation successful, run the Java code

    $runCommand = "java -cp " . escapeshellarg(dirname($renamedJavaFile)) . " " . $className;

    // Open a process for input/output
    $descriptors = [
        0 => ["pipe", "r"],  // stdin
        1 => ["pipe", "w"],  // stdout
        2 => ["pipe", "w"]   // stderr
    ];

    $process = proc_open($runCommand, $descriptors, $pipes);

    if (is_resource($process)) {
        // Write custom test case to the input pipe
        fwrite($pipes[0], $customTestCase);
        fclose($pipes[0]);

        // Read the output from the output pipe
        $outputText = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        // Close the process
        proc_close($process);

        // Save output to file
        file_put_contents($outputFile, $outputText);

        echo "Java code executed successfully.";
    } else {
        echo 'Failed to execute Java program.';
    }
} else {
    // Compilation failed, output error message
    file_put_contents($outputFile, implode("\n", $output));
    echo "Compilation failed. Error: " . implode("\n", $output);
}
    
    // Clean up temporary files
    unlink($renamedJavaFile);
    unlink($classFile);
    exit;

?>