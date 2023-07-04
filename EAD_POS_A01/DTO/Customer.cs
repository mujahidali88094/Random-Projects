namespace DTO
{
    public class Customer
    {
        public int Id { get; set; }
        public string Name { get; set; } = string.Empty;
        public string Address { get; set; } = string.Empty;
        public string Phone { get; set; } = string.Empty;
        public string Email { get; set; } = string.Empty;
        public int AmountPayable { get; set; }
        public int SalesLimit { get; set; }

        public override string ToString()
        {
            return $"ID: {Id}, Name: {Name}, Address: {Address}, Phone: {Phone}, Email: {Email}, AmountPayable: {AmountPayable}, SalesLimit: {SalesLimit}";
        }

    }
}