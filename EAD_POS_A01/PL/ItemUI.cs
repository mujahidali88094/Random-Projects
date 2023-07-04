using BLL;
using DTO;

namespace PL
{
    internal class ItemUI
    {
        ItemBLL bll = new ItemBLL();
        SaleBLL saleBll = new SaleBLL();
        public void ShowItemMenu()
        {
            bool exit = false;
            while (true)
            {
                Console.WriteLine("");
                Console.WriteLine("ItemsMenu:");
                Console.WriteLine("1- Add New Item");
                Console.WriteLine("2- Update Item Details");
                Console.WriteLine("3- Find Items");
                Console.WriteLine("4- Remove Existing Item");
                Console.WriteLine("5- Back to Main Menu");

                Console.Write("Select One: ");
                int choice = UI.ReadIntFromConsole();
                switch (choice)
                {
                    case 1:
                        {
                            Console.WriteLine("Add Item: ");

                            int id = bll.GetAvailableId();
                            Console.WriteLine("Item Id: " + id);
                            Console.Write("Enter Item Description: ");
                            string description = UI.ReadStringFromConsole();
                            Console.Write("Enter Item Price: ");
                            int price = UI.ReadIntFromConsole();
                            Console.Write("Enter Item Quantity: ");
                            int quantity = UI.ReadIntFromConsole();
                            if (!UI.ConfirmFromUser())
                                break;
                            Item item = new Item
                            {
                                Id = id,
                                Description = description,
                                Price = price,
                                Quantity = quantity,
                                CreationDate = DateTime.Now
                            };
                            if (bll.AddNewItem(item))
                                Console.WriteLine("Item Added Successfully");
                            else
                                Console.WriteLine("Error Adding Item");
                        }
                        break;
                    case 2:
                        {
                            Console.WriteLine("Update Item: ");
                            Console.Write("Enter Item Id: ");
                            int id = UI.ReadIntFromConsole();
                            Item? foundItem = bll.FindItemById(id);

                            if (foundItem == null)
                            {
                                Console.WriteLine("Item Not Found");
                                break;
                            }
                            Console.Write("Enter Item Description (" + foundItem.Description + "): ");
                            string description = UI.ReadStringFromConsole(true);
                            Console.Write("Enter Item Price (" + foundItem.Price + "): ");
                            int price = UI.ReadIntFromConsole(true);
                            Console.Write("Enter Item Quantity (" + foundItem.Quantity + "): ");
                            int quantity = UI.ReadIntFromConsole(true);

                            if (!UI.ConfirmFromUser())
                                break;

                            Item item = new Item
                            {
                                Description = description == "" ? foundItem.Description : description,
                                Price = price == UI.SENTINAL_INT ? foundItem.Price : price,
                                Quantity = quantity == UI.SENTINAL_INT ? foundItem.Quantity : quantity,
                                CreationDate = foundItem.CreationDate
                            };
                            if (bll.UpdateItem(id, item))
                                Console.WriteLine("Item Updated Successfully");
                            else
                                Console.WriteLine("Error Updating Item");
                        }
                        break;
                    case 3:
                        {
                            Console.WriteLine("Find Items: ");
                            Console.WriteLine("Tip: Skip the field you don't want to search by.");
                            Console.Write("Enter Item Id: ");
                            int id = UI.ReadIntFromConsole(true);
                            Console.Write("Enter Item Description: ");
                            string description = UI.ReadStringFromConsole(true);
                            Console.Write("Enter Item Price: ");
                            int price = UI.ReadIntFromConsole(true);
                            Console.Write("Enter Item Quantity: ");
                            int quantity = UI.ReadIntFromConsole(true);
                            Console.Write("Enter Item Creation Date: ");
                            DateTime creationDate = UI.ReadDateFromConsole(true);

                            Item item = new Item
                            {
                                Id = id,
                                Description = description,
                                Price = price,
                                Quantity = quantity,
                                CreationDate = creationDate
                            };
                            List<Item> items = bll.FindItems(item);
                            ShowItems(items);
                        }
                        break;
                    case 4:
                        {
                            Console.Write("Enter Item Id: ");
                            int id = UI.ReadIntFromConsole();
                            if (!bll.ItemExists(id))
                            {
                                Console.WriteLine("Item Not Found");
                                break;
                            }
                            if (!UI.ConfirmFromUser())
                                break;
                            if(saleBll.ItemExistsInASale(id))
                            {
                                Console.WriteLine("A sale contains this item. So cannot be removed!");
                                break;
                            }
                            if (bll.RemoveItem(id))
                                Console.WriteLine("Item Removed Successfully");
                            else
                                Console.WriteLine("Failed to Remove Item");
                            
                        }
                        break;
                    case 5:
                        exit = true;
                        break;
                    default:
                        Console.WriteLine("Invalid Choice");
                        break;
                }
                if (exit)
                    return;
            }
        }
        public static void ShowItems(List<Item> items)
        {
            if(items.Count == 0)
            {
                Console.WriteLine("No Items Found");
                return;
            }
            Console.WriteLine("Items:");
            Console.WriteLine("{0,10}{1,25}{2,10}{3,10}{4,20}", "ID","Description","Price","Quantity","Created On");
            Console.WriteLine("");
            foreach(Item item in items)
                Console.WriteLine("{0,10}{1,25}{2,10}{3,10}{4,20}", item.Id, item.Description, item.Price, item.Quantity, item.CreationDate.ToShortDateString());
            Console.WriteLine("");
        }
        public static void ShowItem(Item item)
        {
            Console.WriteLine("");
            Console.WriteLine("{0,10}{1,25}{2,10}{3,10}{4,20}", "ID", "Description", "Price", "Quantity", "Created On");
            Console.WriteLine("");
            Console.WriteLine("{0,10}{1,25}{2,10}{3,10}{4,20}", item.Id, item.Description, item.Price, item.Quantity, item.CreationDate.ToShortDateString());
            Console.WriteLine("");
        }
    }
}
