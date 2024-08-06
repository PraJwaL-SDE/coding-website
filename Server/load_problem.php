<?php
include "../models/Problem.php";

$prefix_code =  '
import java.util.*;
import java.util.Timer;
import java.util.TimerTask;
public class ThreeSum {
';

$real_code = '

import java.util.*;

public class Main{
    public List<List<Integer>> threeSum(int[] nums, int k) {
        Arrays.sort(nums); // Sorting the array first
        List<List<Integer>> result = new ArrayList<>();
        
        for (int i = 0; i < nums.length - 2; i++) {
            if (i == 0 || (i > 0 && nums[i] != nums[i - 1])) { // Skip duplicates
                int target = k - nums[i];
                int left = i + 1;
                int right = nums.length - 1;
                
                while (left < right) {
                    if (nums[left] + nums[right] == target) {
                        result.add(Arrays.asList(nums[i], nums[left], nums[right]));
                        while (left < right && nums[left] == nums[left + 1]) left++; // Skip duplicates
                        while (left < right && nums[right] == nums[right - 1]) right--; // Skip duplicates
                        left++;
                        right--;
                    } else if (nums[left] + nums[right] < target) {
                        left++;
                    } else {
                        right--;
                    }
                }
            }
        }
        
        return result;
    }
    
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        
        int n = scanner.nextInt();
        int[] nums = new int[n];
        
        
        for (int i = 0; i < n; i++) {
            nums[i] = scanner.nextInt();
        }
        
        
        int k = scanner.nextInt();
        
        Main solution = new Main();
        List<List<Integer>> result = solution.threeSum(nums, k);
        
        Collections.sort(result, new Comparator<List<Integer>>() {
            @Override
            public int compare(List<Integer> a, List<Integer> b) {
                for (int i = 0; i < a.size(); i++) {
                    if (!a.get(i).equals(b.get(i))) {
                        return a.get(i) - b.get(i);
                    }
                }
                return 0;
            }
        });
       
        for (List<Integer> triplet : result) {
            System.out.println(triplet);
        }
    }
}

';

$postfix_code = '
public static void main(String[] args) {
    Scanner scanner = new Scanner(System.in);
    Timer timer = new Timer();
        int timeout = 10000; // Timeout in milliseconds (e.g., 10 seconds)

        // Schedule a task to terminate the program after the timeout
        timer.schedule(new TimerTask() {
            public void run() {
                System.out.println("Time Limit Exceeded.");
                System.exit(1);
            }
        }, timeout);
    
    int n = scanner.nextInt();
    int[] nums = new int[n];
    
    
    for (int i = 0; i < n; i++) {
        nums[i] = scanner.nextInt();
    }
    
    
    int k = scanner.nextInt();

    
    
    ThreeSum solution = new ThreeSum();
    List<List<Integer>> result = solution.threeSum(nums, k);
    
    Collections.sort(result, new Comparator<List<Integer>>() {
        @Override
        public int compare(List<Integer> a, List<Integer> b) {
            for (int i = 0; i < a.size(); i++) {
                if (!a.get(i).equals(b.get(i))) {
                    return a.get(i) - b.get(i);
                }
            }
            return 0;
        }
    });
   
    for (List<Integer> triplet : result) {
        System.out.println(triplet);
    }
    System.exit(1);
}
}
';

$test_case = '5 1 2 3 4 5 7';

$emptyCode = '
public List<List<Integer>> threeSum(int[] nums, int k) {
    
}
';

// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // If there's no password, leave it empty
$database = "codingclub";
$table_name = "problems";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_POST['id'];
// Prepare SQL statement
$sql = "SELECT id, discription, example, prefix_code, postfix_code, empty_code, correct_code, sample_test_case,  title, likes FROM $table_name WHERE id = $id";

// Execute SQL query
$result = $conn->query($sql);
$example = "";
$description = "";
$title = "";
$likes = 0;
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $description=$row["discription"] ;
        $example= $row["example"];
        $prefix_code=$row["prefix_code"];
        $postfix_code= $row["postfix_code"];
        $emptyCode= $row["empty_code"] ;
        $real_code= $row["correct_code"] ;
        $test_case= $row["sample_test_case"] ;
        $title= $row["title"] ;
        $likes = $row["likes"] ;
    }
} else {
    echo "Server error";
}

// Close connection
$conn->close();



$problem1 = new Problem($id, $description, $example, $real_code, $test_case, $prefix_code, $postfix_code, $emptyCode);

$parameters = array(
    'id' => $problem1->getId(),
    'description' => $problem1->getDescription(),
    'example' => $problem1->getExample(),
    'Correct_code' => $problem1->getCorrectCode(),
    'test_case' => $problem1->getTestCases(),
    'prefix_code' => $problem1->getPrefixCode(),
    'postfix_code' => $problem1->getPostfixCode(),
    'empty_code' => $problem1->getEmptyCode(),
    'title' => $title
    

);

// Send the parameters as JSON
echo json_encode($parameters);
?>
