import java.util.Scanner;
import java.time.format.DateTimeFormatter;
import java.time.LocalDateTime;
import java.text.DecimalFormat;
import java.math.RoundingMode;

public class app {

    public static void main (String[] args) {

        Scanner obj = new Scanner(System.in);

        System.out.println("Enter your name");
        String name = obj.nextLine();
        if(Character.isLowerCase(name.charAt(0)))
        {
            System.out.println("Name must start with uppercase, please try again");
            return;
        }
        else
        {
            System.out.println("Hello " + name);
        }

        DateTimeFormatter dtf = DateTimeFormatter.ofPattern("yyyy/MM/dd HH:mm:ss");
        LocalDateTime now = LocalDateTime.now();
        System.out.println("Computation starts: "+dtf.format(now));

        double mean = 0, sum = 0;
        int size = 0;

        System.out.println("Enter series of numbers seperated by commas!");
        String numbers = obj.nextLine();
        

        String delim = ",";
        String[] numArray = numbers.split(delim);

        for (int i = 0; i < numArray.length; i++)
        {
            int digit = Integer.parseInt(numArray[i]);
            size++;
            sum += digit;

        }

        DecimalFormat format = new DecimalFormat("#.##");
        format.setRoundingMode(RoundingMode.UP);
        mean = sum/size;

        System.out.println("You have entered "+size+" number(s)");
        System.out.println("The sum of the numbers is = "+sum);
        System.out.println("The Mean of the numbers is = "+format.format(mean));
    }
}