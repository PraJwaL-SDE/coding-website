<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code'])) {
    $javaCode = $_POST['code'];
    $customTestCase = $_POST['CustomTestCase'];

    // Find the class name from the code
    preg_match('/class\s+(\w+)/', $javaCode, $matches);
    $className = isset($matches[1]) ? $matches[1] : 'Main'; // Default class name if not found
    $javaFileName = $className . '.java';

    // Save the Java code to a file
    $javaFile = tempnam(sys_get_temp_dir(), 'code_') . '.java';
    file_put_contents($javaFile, $javaCode);

    // Rename the Java file to match the class name
    $renamedJavaFile = dirname($javaFile) . DIRECTORY_SEPARATOR . $javaFileName;
    rename($javaFile, $renamedJavaFile);

    $classFile = tempnam(sys_get_temp_dir(), 'class_') . '.class';

    $compileCommand = "javac $renamedJavaFile 2>&1"; // Redirect stderr to stdout for capturing compilation errors
    exec($compileCommand, $output, $returnCode);

    if ($returnCode === 0) {
        // Compilation successful, run the Java code
        $runCommand = "java -cp " . escapeshellarg(dirname($renamedJavaFile)) . " " . $className;

        // Open a process for input/output
        $descriptors = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("pipe", "w")   // stderr is a pipe that the child will write to
        );

        $process = proc_open($runCommand, $descriptors, $pipes);

        if (is_resource($process)) {
            // Write custom test case to the input pipe
            fwrite($pipes[0], $customTestCase);
            fclose($pipes[0]);

            // Read the output from the output pipe
            $outputText = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            // Close all pipes before proc_close
            fclose($pipes[2]);

            // Close the process
            proc_close($process);

            // Filter out unwanted text (e.g., warnings, HTML tags)
            $filteredOutput = filter_output($outputText);

            // Output the result
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => true, 'output' => $filteredOutput]);
        } else {
            // Failed to open process
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'error' => 'Failed to execute Java program']);
        }
    } else {
        // Compilation failed, output error message
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'error' => implode("\n", $output)]);
    }
    
    // Clean up temporary files
    unlink($renamedJavaFile);
    unlink($classFile);
    exit;
}

function filter_output($output) {
    // Define patterns to filter out unwanted text
    $patterns = [
        '/\bwarning\b.*\n/',     // Filter out lines containing 'warning'
        '/<!DOCTYPE html>/',     // Filter out HTML tags
        '/<html.*?>/',
        '/<\/html>/',
        '/<body.*?>/',
        '/<\/body>/',
        '/<head.*?>/',
        '/<\/head>/',
    ];

    // Apply each pattern to the output
    foreach ($patterns as $pattern) {
        $output = preg_replace($pattern, '', $output);
    }

    // Trim leading and trailing whitespace
    $output = trim($output);

    return $output;
}
?>
