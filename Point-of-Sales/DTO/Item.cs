namespace DTO
{
    public class Item
    {
        public int Id { get; set; }
        public string Description { get; set; } = string.Empty;
        public int Price { get; set; }
        public int Quantity { get; set; }
        public DateTime CreationDate { get; set; }
    }
}