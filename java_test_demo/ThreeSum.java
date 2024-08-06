import java.util.*;

public class ThreeSum{
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
        
        ThreeSum solution = new ThreeSum();
        List<List<Integer>> result = solution.threeSum(nums, k);
        
       
        for (List<Integer> triplet : result) {
            System.out.println(triplet);
        }
    }
}
