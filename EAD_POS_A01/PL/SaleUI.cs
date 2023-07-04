using BLL;
using DTO;

namespace PL
{
    internal class SaleUI
    {
        ItemBLL itemBll = new ItemBLL();
        CustomerBLL customerBll = new CustomerBLL();
        SaleBLL saleBll = new SaleBLL();

        Sale sale = new Sale();
        Customer? customer = new Customer();
        
        public void StartSale()
        {
            int id = saleBll.GetAvailableSaleId();
            DateTime date = DateTime.Now.Date;
            string status = "Pending";

            Console.WriteLine("Sales ID: " + id);
            Console.WriteLine("Sales Date: " + date.ToShortDateString());
            Console.Write("Enter Customer ID: ");
            int customerId = UI.ReadIntFromConsole();
            customer = customerBll.GetCustomer(customerId);
            if (customer == null)
            {
                Console.WriteLine("Customer not found");
                return;
            }
            sale.OrderId = id;
            sale.CustomerId = customerId;
            sale.Date = date;
            sale.Status = status;

            AddItem();
            ShowAddItemsMenu();
        }
        public void ShowAddItemsMenu()
        {
            bool exit = false;
            while (true)
            {
                Console.WriteLine("");
                Console.WriteLine("Sale Menu:");
                Console.WriteLine("1- Enter New Item");
                Console.WriteLine("2- End Sale");
                Console.WriteLine("3- Remove Existing Item from Current Sale");
                Console.WriteLine("4- Cancel Sale");

                Console.Write("Choose from option 1 – 4: ");
                int option = UI.ReadIntFromConsole();
                switch (option)
                {
                    case 1:
                        AddItem();
                        break;
                    case 2:
                        {
                            if (sale.Items.Count == 0)
                            {
                                Console.WriteLine("No items in sale!");
                                Console.WriteLine("Add Some Items to Complete the Sale.");
                                break;
                            }
                            if (sale.GetTotal() > customer?.SalesLimit)
                            {
                                Console.WriteLine("Total for this Sale is exceeding the limit of the Customer!");
                                Console.WriteLine("Consider Removing Some Items to Complete the Sale.");
                                break;
                            }
                            ShowSale(sale);
                            if (!UI.ConfirmFromUser())
                                break;

                            sale.Status = "Not Paid";
                            saleBll.AddSale(sale);
                            foreach (SaleLineItem item in sale.Items)
                            {
                                saleBll.AddSaleLineItem(item);
                                itemBll.UpdateItemQuantity(item.ItemId, item.Quantity);
                            }
                                
                            customerBll.IncreaseAmountPayable(sale.CustomerId, sale.GetTotal());

                            Console.WriteLine("Sale Completed");
                            exit = true;
                        }
                        break;
                    case 3:
                        {
                            Console.Write("Enter Item ID: ");
                            int itemId = UI.ReadIntFromConsole();
                            if (sale.ItemExists(itemId))
                            {
                                sale.RemoveItem(itemId);
                                Console.WriteLine("Item removed");
                            }
                            else
                                Console.WriteLine("Item not found");
                        }
                        break;
                    case 4:
                        exit = true;
                        break;
                    default:
                        break;
                }
                if (exit)
                    return;
            }

        }
        public void AddItem()
        {
            Console.Write("Item Id: ");
            int itemId = UI.ReadIntFromConsole();
            Item? item = itemBll.FindItemById(itemId);
            if (item == null)
            {
                Console.WriteLine("Item Not Found");
                return;
            }  
            if (item.Quantity == 0)
            {
                Console.WriteLine("Item is out of stock");
                return;
            }
            Console.WriteLine("Description: " + item.Description);
            Console.WriteLine("Price: " + item.Price);
            Console.Write("Quantity: ");
            int quantity = UI.ReadIntFromConsole();
            if(quantity > item.Quantity)
            {
                Console.WriteLine("Quantity exceeds stock!");
                Console.WriteLine("Only " + item.Quantity + " remaining in stock");
                return;
            }
            int subTotal = item.Price * quantity;
            Console.WriteLine("Sub-Total: " + subTotal);
            if (sale.ItemExists(itemId))
            {
                sale.UpdateQuantity(itemId, quantity, subTotal);
                Console.WriteLine("Item already exists in sale, Quantity is updated.");
            }
            else
            {
                sale.AddItem(itemId, quantity, subTotal);
                Console.WriteLine("Item is Added");
            }
            Console.WriteLine("Total: " + sale.GetTotal());
        }
        public void ShowSale(Sale sale)
        {
            Console.WriteLine("Sale Id: "+ sale.OrderId);
            Console.WriteLine("Date: "+ sale.Date.ToShortDateString());
            Console.WriteLine("Customer Id: "+ sale.CustomerId);
            Console.WriteLine("Customer Name: "+ customerBll.GetCustomer(sale.CustomerId)?.Name);
            ShowSaleLineItems(sale.Items);
            Console.WriteLine("Total: "+ sale.GetTotal());
            Console.WriteLine("");
        }
        public void ShowSaleLineItems(List<SaleLineItem> items)
        {
            Console.WriteLine("");
            Console.WriteLine("{0,10}{1,30}{2,10}{3,20}", "ItemId", "Description", "Quantity", "Amount");
            Console.WriteLine("");
            foreach (SaleLineItem item in items)
                Console.WriteLine("{0,10}{1,30}{2,10}{3,20}", item.ItemId, itemBll.FindItemById(item.ItemId)?.Description, item.Quantity, item.Amount);
            Console.WriteLine("");
        }
    }
}
