using DAL;
using DTO;

namespace BLL
{
    public class ItemBLL
    {
        ItemsDAL dal = new ItemsDAL();
            
        public int GetAvailableId()
        {
            return dal.GetAvailableId();
        }
        public bool AddNewItem(Item item)
        {
            return dal.AddItem(item);
        }
        public bool ItemExists(int id)
        {
            return dal.ItemExists(id);
        }
        public bool RemoveItem(int id)
        {
            return dal.RemoveItem(id);
        }
        public List<Item> GetItems()
        {
            return dal.GetItems();
        }
        public List<Item> FindItems(Item item)
        {
            return dal.FindItems(item);
        }
        public bool UpdateItem(int id, Item item)
        {
            return dal.UpdateItem(id, item);
        }
        public Item? FindItemById(int id)
        {
            return dal.GetItemById(id);
        }
        public bool UpdateItemQuantity(int id, int quantity)
        {
            return dal.UpdateItemQuantity(id, quantity);
        }
    }
}