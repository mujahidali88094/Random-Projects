using BLL;
using DTO;

namespace PL
{
    internal class CustomerUI
    {
        CustomerBLL bll = new CustomerBLL();
        public void ShowCustomerMenu()
        {
            bool exit = false;
            while (true)
            {
                Console.WriteLine("CustomerMenu:");
                Console.WriteLine("1- Add New Customer");
                Console.WriteLine("2- Update Customer Details");
                Console.WriteLine("3- Find Customer");
                Console.WriteLine("4- Remove Existing Customer");
                Console.WriteLine("5- Back To Main Menu");

                Console.Write("Please enter your choice:");
                int choice = UI.ReadIntFromConsole();
                switch (choice)
                {
                    case 1:
                        {
                            Console.WriteLine("Add New Customer");
                            int id = bll.GetAvailableId();
                            Console.WriteLine("ID: " + id);
                            Console.Write("Name: ");
                            string name = UI.ReadStringFromConsole();
                            Console.Write("Address: ");
                            string address = UI.ReadStringFromConsole();
                            Console.Write("Phone: ");
                            string phone = UI.ReadStringFromConsole();
                            Console.Write("Email: ");
                            string email = UI.ReadStringFromConsole();
                            Console.Write("SalesLimit: ");
                            int salesLimit = UI.ReadIntFromConsole();

                            Customer customer = new Customer
                            {
                                Id = id,
                                Name = name,
                                Address = address,
                                Phone = phone,
                                Email = email,
                                AmountPayable = 0,
                                SalesLimit = salesLimit
                            };
                            if (!UI.ConfirmFromUser())
                                break;
                            if (bll.AddCustomer(customer))
                                Console.WriteLine("Customer Added Successfully");
                            else
                                Console.WriteLine("Customer Not Added");
                        }
                        break;
                    case 2:
                        {
                            Console.WriteLine("Update Customer Details");
                            Console.Write("Enter Customer ID: ");
                            int id = UI.ReadIntFromConsole();
                            Customer? customer = bll.GetCustomer(id);
                            if (customer == null)
                            {
                                Console.WriteLine("Customer Not Found");
                                break;
                            }
                            Console.WriteLine("Customer Details:");
                            ShowCustomer(customer);
                            Console.WriteLine("Enter New Details:");
                            Console.Write("Name: ");
                            string name = UI.ReadStringFromConsole(true);
                            Console.Write("Address: ");
                            string address = UI.ReadStringFromConsole(true);
                            Console.Write("Phone: ");
                            string phone = UI.ReadStringFromConsole(true);
                            Console.Write("Email: ");
                            string email = UI.ReadStringFromConsole(true);
                            Console.Write("SalesLimit: ");
                            int salesLimit = UI.ReadIntFromConsole(true);

                            customer.Name = name == "" ? customer.Name : name;
                            customer.Address = address == "" ? customer.Address : address;
                            customer.Phone = phone == "" ? customer.Phone : phone;
                            customer.Email = email == "" ? customer.Email : email;
                            customer.SalesLimit = salesLimit == UI.SENTINAL_INT ? customer.SalesLimit : salesLimit;

                            if (!UI.ConfirmFromUser())
                                break;
                            if (bll.UpdateCustomer(id, customer))
                                Console.WriteLine("Customer Updated Successfully");
                            else
                                Console.WriteLine("Customer Not Updated");
                        }
                        break;
                    case 3:
                        {
                            Console.WriteLine("Find Customer");
                            Console.WriteLine("Tip: You can skip any field by pressing enter");
                            Console.Write("Enter Customer ID: ");
                            int id = UI.ReadIntFromConsole(true);
                            Console.Write("Enter Customer Name: ");
                            string name = UI.ReadStringFromConsole(true);
                            Console.Write("Enter Customer Address: ");
                            string address = UI.ReadStringFromConsole(true);
                            Console.Write("Enter Customer Phone: ");
                            string phone = UI.ReadStringFromConsole(true);
                            Console.Write("Enter Customer Email: ");
                            string email = UI.ReadStringFromConsole(true);
                            Console.Write("Enter Customer SalesLimit: ");
                            int salesLimit = UI.ReadIntFromConsole(true);
                            Console.Write("Enter Customer AmountPayable: ");
                            int amountPayable = UI.ReadIntFromConsole(true);

                            Customer customer = new Customer
                            {
                                Id = id,
                                Name = name,
                                Address = address,
                                Phone = phone,
                                Email = email,
                                AmountPayable = amountPayable,
                                SalesLimit = salesLimit
                            };
                            List<Customer> customers = bll.FindCustomers(customer);
                            if (customers.Count == 0)
                            {
                                Console.WriteLine("No Customers Found");
                                break;
                            }
                            Console.WriteLine("Customers Found:");
                            ShowCustomers(customers);
                        }
                        break;
                    case 4:
                        {
                            Console.WriteLine("Remove Existing Customer");
                            Console.Write("Enter Customer ID: ");
                            int id = UI.ReadIntFromConsole();
                            Customer? customer = bll.GetCustomer(id);
                            if (customer == null)
                            {
                                Console.WriteLine("Customer Not Found");
                                break;
                            }
                            Console.WriteLine("Customer Details:");
                            ShowCustomer(customer);
                            if (!UI.ConfirmFromUser())
                                break;
                            if (bll.RemoveCustomer(id))
                                Console.WriteLine("Customer Removed Successfully");
                            else
                                Console.WriteLine("Customer Not Removed");
                        }
                        break;
                    case 5:
                        exit = true;
                        break;
                    default:
                        Console.WriteLine("Invalid choice");
                        break;
                }
                if (exit)
                    return;
            }
        }
        public static void ShowCustomers(List<Customer> customers)
        {
            Console.WriteLine("");
            Console.WriteLine("{0,5}{1,20}{2,20}{3,20}{4,30}{5,20}{6,20}", "ID","Name","Address","Phone","Email","AmountPayable","SalesLimit");
            Console.WriteLine("");
            foreach (Customer customer in customers)
            {
                Console.WriteLine("{0,5}{1,20}{2,20}{3,20}{4,30}{5,20}{6,20}", customer.Id, customer.Name, customer.Address, customer.Phone, customer.Email, customer.AmountPayable, customer.SalesLimit);
            }
            Console.WriteLine("");
        }
        public static void ShowCustomer(Customer customer)
        {
            Console.WriteLine("");
            Console.WriteLine("{0,5}{1,20}{2,20}{3,20}{4,30}{5,20}{6,20}", "ID", "Name", "Address", "Phone", "Email", "AmountPayable", "SalesLimit");
            Console.WriteLine("");
            Console.WriteLine("{0,5}{1,20}{2,20}{3,20}{4,30}{5,20}{6,20}", customer.Id, customer.Name, customer.Address, customer.Phone, customer.Email, customer.AmountPayable, customer.SalesLimit);
            Console.WriteLine("");
        }
    }
}
