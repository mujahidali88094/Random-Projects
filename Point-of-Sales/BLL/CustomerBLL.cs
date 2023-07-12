using DAL;
using DTO;

namespace BLL
{
    public class CustomerBLL
    {
        CustomerDAL customerDAL = new CustomerDAL();
        public int GetAvailableId()
        {
            return customerDAL.GetAvailableId();
        }
        public List<Customer> GetCustomers()
        {
            return customerDAL.GetCustomers();
        }
        public bool AddCustomer(Customer customer)
        {
            return customerDAL.AddCustomer(customer);
        }
        public bool UpdateCustomer(int id, Customer customer)
        {
            return customerDAL.UpdateCustomer(id, customer);
        }
        public bool RemoveCustomer(int id)
        {
            return customerDAL.RemoveCustomer(id);
        }
        public Customer? GetCustomer(int id)
        {
            return customerDAL.GetCustomer(id);
        }
        public List<Customer> FindCustomers(Customer customer)
        {
            return customerDAL.FindCustomers(customer);
        }
        public bool IncreaseAmountPayable(int id, int amount)
        {
            Customer? customer = customerDAL.GetCustomer(id);
            if (customer == null)
                return false;
            customer.AmountPayable += amount;
            return customerDAL.UpdateCustomer(id, customer);
        }
        public bool DecreaseAmountPayable(int id, int amount)
        {
            Customer? customer = customerDAL.GetCustomer(id);
            if (customer == null)
                return false;
            customer.AmountPayable -= amount;
            return customerDAL.UpdateCustomer(id, customer);
        }
    }
}