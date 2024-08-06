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
        echo json_encode(['success' => true, 'output' => $outputText]);
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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>C++ Code Executor</title>
</head>
<body>
    <textarea id="code" rows="10" cols="50" placeholder="Enter your C++ code here"></textarea><br>
    <button id="runButton">Run</button><br>
    <div id="output"></div>

    <script>
        document.getElementById('runButton').addEventListener('click', function() {
            var code = document.getElementById('code').value;
            var outputDiv = document.getElementById('output');
            outputDiv.innerHTML = 'Compiling and running...';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // The URL is the same as the current page
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        outputDiv.textContent = response.output;
                    } else {
                        outputDiv.textContent = 'Error: ' + response.error;
                    }
                }
            };
            xhr.send('code=' + encodeURIComponent(code));
        });
    </script>
</body>
</html>
