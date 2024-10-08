import java.util.*;

public class LongestCommonPrefix {
    public String longestCommonPrefix(String[] strs) {
        if (strs == null || strs.length == 0) {
            return "";
        }
        
        String prefix = strs[0];
        for (int i = 1; i < strs.length; i++) {
            while (strs[i].indexOf(prefix) != 0) {
                prefix = prefix.substring(0, prefix.length() - 1);
                if (prefix.isEmpty()) {
                    return "-1";
                }
            }
        }
        return prefix;
    }
    
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int n = scanner.nextInt();
        scanner.nextLine(); 
        String[] strs = new String[n];
        for (int i = 0; i < n; i++) {
            strs[i] = scanner.nextLine();
        }
        Timer timer = new Timer();
        int timeout = 10000; // Timeout in milliseconds (e.g., 15 seconds)

        // Schedule a task to terminate the program after the timeout
        timer.schedule(new TimerTask() {
            public void run() {
                System.out.println("Time Limit Exceeded.");
                System.exit(1);
            }
        }, timeout);
        
        LongestCommonPrefix solution = new LongestCommonPrefix();
        System.out.println(solution.longestCommonPrefix(strs));
        scanner.close();
        timer.cancel(); // Cancel the timer task
        System.exit(1);
    }
}
