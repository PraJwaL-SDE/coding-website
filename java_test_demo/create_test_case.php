<?php

// $testcaseText = "";
// $n = 6000; 
// $testcaseText .= $n . " ";
// for($i = 0;$i<$n;$i++){
//     $testcaseText .=$i . " ";
// }
// for($i = $n;$i>=0;$i--){
//     $testcaseText .=$i . " ";
// }
// echo $testcaseText;

function generateRandomString($length) {
    $alphabets = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $alphabets[rand(0, strlen($alphabets) - 1)];
    }

    return $randomString;
}
$length = 65; // Change the length as needed
echo "5000 ";
for($i = 0;$i<5000;$i++){

    echo "".generateRandomString(rand(1,2))." ";
}
    

?>