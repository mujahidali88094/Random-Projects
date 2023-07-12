namespace DTO
{
    public class Sale
    {
        public int OrderId { get; set; }
        public int CustomerId { get; set; }
        public DateTime Date { get; set; }
        public string Status { get; set; } = string.Empty;
        public List<SaleLineItem> Items { get; set; } = new List<SaleLineItem>();
        public void AddItem(int itemId, int quatity, int amount)
        {
            int orderId = OrderId;
            
            Items.Add(new SaleLineItem
            {
                OrderId = orderId,
                ItemId = itemId,
                Quantity = quatity,
                Amount = amount
            });
        }
        public bool ItemExists(int itemId)
        {
            return Items.Any(item => item.ItemId == itemId);
        }
        public void UpdateQuantity(int itemId, int quantity, int amount)
        {
            SaleLineItem? item = Items.FirstOrDefault(item => item.ItemId == itemId);
            if (item != null)
            {
                item.Quantity = quantity;
                item.Amount = amount;
            }
        }
        public void RemoveItem(int itemId)
        {
            Items.RemoveAll(item => item.ItemId == itemId);
        }
        public int GetTotal()
        {
            int total = 0;
            foreach (SaleLineItem item in Items)
                total += item.Amount;
            return total;
        }

    }
}