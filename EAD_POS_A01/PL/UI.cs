using DTO;
using BLL;

namespace PL
{
    public class UI
    {
        public const int SENTINAL_INT = -99;
        public static void ShowMainMenu()
        {
            bool exit = false;
            while (true)
            {
                Console.WriteLine("");
                Console.WriteLine("Main Menu: ");
                Console.WriteLine("1- Manage Items");
                Console.WriteLine("2- Manage Customers");
                Console.WriteLine("3- Make New Sale");
                Console.WriteLine("4- Make Payment");
                Console.WriteLine("5- Exit");

                Console.WriteLine("");
                Console.Write("Select One: ");
                int choice = ReadIntFromConsole();
                switch (choice)
                {
                    case 1:
                        {
                            ItemUI itemUI = new ItemUI();
                            itemUI.ShowItemMenu();
                        }
                        break;
                    case 2:
                        {
                            CustomerUI customerUI = new CustomerUI();
                            customerUI.ShowCustomerMenu();
                        }
                        break;
                    case 3:
                        {
                            SaleUI saleUI = new SaleUI();
                            saleUI.StartSale();
                        }
                        break;
                    case 4:
                        {
                            ReceiptUI receiptUI = new ReceiptUI();
                            receiptUI.ReceivePayment();
                        }
                        break;
                    case 5:
                        exit = true;
                        break;
                    default:
                        Console.WriteLine("Invalid Choice");
                        break;
                }
                if(exit)
                    break;
            }
        }

        // reads non-negative integer from console
        public static int ReadIntFromConsole(bool skipEmpty = false)
        {
            string input = Console.ReadLine() ?? "";
            if (skipEmpty && input == "")
                return SENTINAL_INT;
            int result;
            while (true)
            {
                if (int.TryParse(input, out result) && result >= 0)
                    break;
                Console.Write("Invalid input! Please type non-negative number: ");
                input = Console.ReadLine() ?? "";
                if (skipEmpty && input == "")
                    return SENTINAL_INT;
            }
            return result;
        }
        public static string ReadStringFromConsole(bool skipEmpty = false)
        {
            string input = Console.ReadLine() ?? "";
            if (skipEmpty && input == "")
                return "";
            while (input == "")
            {
                Console.Write("Invalid input! Please type something: ");
                input = Console.ReadLine() ?? "";
            }
            return input;
        }
        public static DateTime ReadDateFromConsole(bool skipEmpty = false)
        {
            Console.Write("Format is dd/mm/yyyy: ");
            string input = Console.ReadLine() ?? "";
            if (skipEmpty && input == "")
                return DateTime.Now.Date;
            DateTime result;
            while (!DateTime.TryParse(input, out result))
            {
                Console.Write("Invalid input! Please type a valid date: ");
                input = Console.ReadLine() ?? "";
                if (skipEmpty && input == "")
                    return DateTime.Now.Date;
            }
            return result.Date;
        }
        public static bool ConfirmFromUser()
        {
            Console.Write("Enter Y to confirm or any other key to cancel: ");
            string input = Console.ReadLine() ?? "";
            return input.ToLower() == "y";
        }

    }
}