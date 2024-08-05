<?php

$javaCode = $_POST['code'];
$customTestCase = $_POST['CustomTestCase'];
$Correct_code = $_POST['correct_code'];

// Find the class name from the code
$totalRandTestCase = 100;

preg_match('/class\s+(\w+)/', $javaCode, $matches);
$className = isset($matches[1]) ? $matches[1] : 'Main'; // Default class name if not found
$javaFileName = $className . '.java';
$javaFile = tempnam(sys_get_temp_dir(), 'code_') . '.java';
file_put_contents($javaFile, $javaCode);
$renamedJavaFile = dirname($javaFile) . DIRECTORY_SEPARATOR . $javaFileName;
rename($javaFile, $renamedJavaFile);
$classFile = tempnam(sys_get_temp_dir(), 'class_') . '.class';
$outputFile1 = 'output1.txt';
$compileCommand = "javac $renamedJavaFile 2>&1"; // Redirect stderr to stdout for capturing compilation errors
exec($compileCommand, $output, $returnCode);

// compile Correct code
preg_match('/class\s+(\w+)/', $Correct_code, $matches2);
$className2 = isset($matches2[1]) ? $matches2[1] : 'Main'; // Default class name if not found
$javaFileName2 = $className2 . '.java';
$javaFile2 = tempnam(sys_get_temp_dir(), 'code_') . '.java';
file_put_contents($javaFile2, $Correct_code);
$renamedJavaFile2 = dirname($javaFile2) . DIRECTORY_SEPARATOR . $javaFileName2;
rename($javaFile2, $renamedJavaFile2);
$classFile2 = tempnam(sys_get_temp_dir(), 'class_') . '.class';
$outputFile2 = 'output2.txt';
$compileCommand2 = "javac $renamedJavaFile2 2>&1"; // Redirect stderr to stdout for capturing compilation errors
exec($compileCommand2, $output, $returnCode2);

if ($returnCode === 0 && $returnCode2 === 0) {
    // Compilation successful, run the Java code
    // for ($j = 1; $j <= $totalRandTestCase; $j++) {
    //     $randomTestCase = "100 \n";
    //     for ($i = 0; $i <= 100; $i++) {
    //         $randomTestCase .= getRandomPositiveAndNegative(-10, 10) . " ";
    //     }
    //     $customTestCase = $randomTestCase;

        // Run the first Java code
        $runCommand = "java -cp " . escapeshellarg(dirname($renamedJavaFile)) . " " . $className;
        $descriptors = [
            0 => ["pipe", "r"],  // stdin is a pipe that the child will read from
            1 => ["pipe", "w"],  // stdout is a pipe that the child will write to
            2 => ["pipe", "w"]   // stderr is a pipe that the child will write to
        ];
        $process = proc_open($runCommand, $descriptors, $pipes);
        if (is_resource($process)) {
            fwrite($pipes[0], $customTestCase);
            fclose($pipes[0]);
            $outputText1 = '';
            while (!feof($pipes[1])) {
                $outputText1 .= fgets($pipes[1]);
            }
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
            file_put_contents($outputFile1, $outputText1);
        } else {
            file_put_contents("output.txt", 'Failed to execute Java program');
            exit;
        }

        // Run the second Java code
        $runCommand2 = "java -cp " . escapeshellarg(dirname($renamedJavaFile2)) . " " . $className2;
        $descriptors = [
            0 => ["pipe", "r"],  // stdin is a pipe that the child will read from
            1 => ["pipe", "w"],  // stdout is a pipe that the child will write to
            2 => ["pipe", "w"]   // stderr is a pipe that the child will write to
        ];
        $process2 = proc_open($runCommand2, $descriptors, $pipes);
        if (is_resource($process2)) {
            fwrite($pipes[0], $customTestCase);
            fclose($pipes[0]);
            $outputText2 = '';
            while (!feof($pipes[1])) {
                $outputText2 .= fgets($pipes[1]);
            }
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process2);
            file_put_contents($outputFile2, $outputText2);
        } else {
            file_put_contents("output.txt", 'Failed to execute Java program');
            exit;
        }

        // Check the outputs
        if (checkOutput($outputFile1, $outputFile2)) {
            $msg = "<span style='color: green;'><b>Correct Answer</b></span> <br> Your Output: $outputText1 <br> Expected Output: $outputText2";

            file_put_contents("output.txt", $msg);
        } else {
            $msg = "<span style='color: red;'>Wrong Answer</span> <br> <strong> Input:</strong> <br> <pre>$customTestCase</pre> <br> <br> <strong> Your Output:</strong> <br> <pre>$outputText1</pre> <br> <strong>Expected Output:</strong> <br> <pre style='color: green;'>$outputText2</pre>";

            file_put_contents("output.txt", $msg);
            unlink($outputFile1);
            unlink($outputFile2);
            unlink($renamedJavaFile2);
            unlink($classFile2);
            unlink($renamedJavaFile);
            unlink($classFile);
            exit;
        }
    // }
} else {
    // Compilation failed, output error message
    file_put_contents("output.txt", implode("\n", $output));
    unlink($classFile);
    exit;
}

function getRandomInteger($min, $max) {
    return rand($min, $max);
}

function getRandomPositiveAndNegative($min, $max) {
    $randomNumber = getRandomInteger($min, $max);
    $positiveOrNegative = rand(0, 1) === 0 ? -1 : 1;
    return $randomNumber * $positiveOrNegative;
}

function checkOutput($file1, $file2) {
    // Read contents of both files
    $content1 = file_get_contents($file1);
    $content2 = file_get_contents($file2);

    // Compare contents
    return $content1 === $content2;
}

unlink($outputFile1);
unlink($outputFile2);
unlink($renamedJavaFile2);
unlink($classFile2);
unlink($renamedJavaFile);
unlink($classFile);
exit;

?>
