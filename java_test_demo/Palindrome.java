import java.util.*;

public class Palindrome { 



    
public static int palinArray(int[] a, int n) {
        
        for(int i=0;i<n/2;i++){
            if(a[i]!=a[n-i-1]) return 0;
        }
        return 1;
    }

    private static boolean isPalindrome(String str) {
        int left = 0;
        int n = str.length() ;
        for(int i=0;i<str.length()/2;i++){
            if(str.charAt(i)!=str.charAt(n-i-1)) return false;
        }
        return true;
    }


 

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        Timer timer = new Timer();
        int timeout = 10000; // Timeout in milliseconds (e.g., 15 seconds)

        // Schedule a task to terminate the program after the timeout
        timer.schedule(new TimerTask() {
            public void run() {
                System.out.println("Time Limit Exceeded.");
                System.exit(1);
            }
        }, timeout);

        // while (sc.hasNextInt()) { // Check if there's more input
            int t = sc.nextInt();
            int ans[] = new int[t];
            int k = 0;
            while (t-- > 0) {
                int n = sc.nextInt();
                int[] a = new int[n];
                for (int i = 0; i < n; i++)
                    a[i] = sc.nextInt();
                ans[k++] = palinArray(a, n);
            }
            for(int i=0;i<t;i++)
            System.out.println(ans[i]);
        // }
        sc.close();
        timer.cancel(); // Cancel the timer task
        System.exit(1);
    }
}
