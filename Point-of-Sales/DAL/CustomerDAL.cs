using System.Data.SqlClient;
using DTO;

namespace DAL
{
    public class CustomerDAL
    {
        SqlConnection connection;
        public CustomerDAL()
        {
            string connectionString = "Data Source=(LocalDB)\\MSSQLLocalDB;AttachDbFilename=D:\\PUCIT\\EAD\\EAD_POS_A01\\DB\\pos.mdf;Integrated Security=True;Connect Timeout=30";
            connection = new SqlConnection(connectionString);
        }
        public int GetAvailableId()
        {
            string query = "SELECT MAX(CustomerId) FROM Customer";
            SqlCommand command = new SqlCommand(query, connection);
            connection.Open();
            object returnValue = command.ExecuteScalar();
            connection.Close();
            //check if there are any items in the database
            if (returnValue == DBNull.Value)
                return 1;
            else
                return Convert.ToInt32(returnValue) + 1;
        }
        public List<Customer> GetCustomers()
        {
            string query = "SELECT * FROM Customer";
            SqlCommand command = new SqlCommand(query, connection);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            List<Customer> customers = new List<Customer>();
            while (reader.Read())
            {
                Customer customer = new Customer();
                customer.Id = reader.GetInt32(0);
                customer.Name = reader.GetString(1);
                customer.Address = reader.GetString(2);
                customer.Phone = reader.GetString(3);
                customer.Email = reader.GetString(4);
                customer.AmountPayable = reader.GetInt32(5);
                customer.SalesLimit = reader.GetInt32(6);

                customers.Add(customer);
            }
            connection.Close();
            return customers;
        }
        public bool AddCustomer(Customer customer)
        {
            string query = "INSERT INTO Customer (CustomerId, Name, Address, Phone, Email, AmountPayable, SalesLimit) VALUES (@CustomerId, @Name, @Address, @Phone, @Email, @AmountPayable, @SalesLimit)";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@CustomerId", customer.Id);
            command.Parameters.AddWithValue("@Name", customer.Name);
            command.Parameters.AddWithValue("@Address", customer.Address);
            command.Parameters.AddWithValue("@Phone", customer.Phone);
            command.Parameters.AddWithValue("@Email", customer.Email);
            command.Parameters.AddWithValue("@AmountPayable", customer.AmountPayable);
            command.Parameters.AddWithValue("@SalesLimit", customer.SalesLimit);
            connection.Open();
            int noOfRowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return (noOfRowsAffected == 1);
        }
        public bool UpdateCustomer(int customerId, Customer updatedCustomer)
        {
            string query = "UPDATE Customer SET Name = @Name, Address = @Address, Phone = @Phone, Email = @Email, AmountPayable = @AmountPayable, SalesLimit = @SalesLimit WHERE CustomerId = @CustomerId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@CustomerId", customerId);
            command.Parameters.AddWithValue("@Name", updatedCustomer.Name);
            command.Parameters.AddWithValue("@Address", updatedCustomer.Address);
            command.Parameters.AddWithValue("@Phone", updatedCustomer.Phone);
            command.Parameters.AddWithValue("@Email", updatedCustomer.Email);
            command.Parameters.AddWithValue("@AmountPayable", updatedCustomer.AmountPayable);
            command.Parameters.AddWithValue("@SalesLimit", updatedCustomer.SalesLimit);
            connection.Open();
            int noOfRowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return (noOfRowsAffected == 1);
        }
        public List<Customer> FindCustomers(Customer customer)
        {
            string query = "SELECT * FROM Customer";

            List<string> whereConditions = new List<string>();
            if (customer.Id >= 0)
                whereConditions.Add("CustomerId = @CustomerId");
            if (customer.Name != string.Empty)
                whereConditions.Add("Name LIKE @Name");
            if (customer.Address != string.Empty)
                whereConditions.Add("Address LIKE @Address");
            if (customer.Phone != string.Empty)
                whereConditions.Add("Phone LIKE @Phone");
            if (customer.Email != string.Empty)
                whereConditions.Add("Email LIKE @Email");
            if (customer.AmountPayable >= 0)
                whereConditions.Add("AmountPayable = @AmountPayable");
            if (customer.SalesLimit >= 0)
                whereConditions.Add("SalesLimit = @SalesLimit");

            if (whereConditions.Count > 0)
            {
                query += " WHERE " + string.Join(" AND ", whereConditions);
            }
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@CustomerId", customer.Id);
            command.Parameters.AddWithValue("@Name", "%" + customer.Name + "%");
            command.Parameters.AddWithValue("@Address", "%" + customer.Address + "%");
            command.Parameters.AddWithValue("@Phone", "%" + customer.Phone + "%");
            command.Parameters.AddWithValue("@Email", "%" + customer.Email + "%");
            command.Parameters.AddWithValue("@AmountPayable", customer.AmountPayable);
            command.Parameters.AddWithValue("@SalesLimit", customer.SalesLimit);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            List<Customer> customers = new List<Customer>();
            while (reader.Read())
            {
                Customer foundCustomer = new Customer();
                foundCustomer.Id = reader.GetInt32(0);
                foundCustomer.Name = reader.GetString(1);
                foundCustomer.Address = reader.GetString(2);
                foundCustomer.Phone = reader.GetString(3);
                foundCustomer.Email = reader.GetString(4);
                foundCustomer.AmountPayable = reader.GetInt32(5);
                foundCustomer.SalesLimit = reader.GetInt32(6);

                customers.Add(foundCustomer);
            }
            connection.Close();
            return customers;
        }
        public Customer? GetCustomer(int customerId)
        {
            string query = "SELECT * FROM Customer WHERE CustomerId = @CustomerId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@CustomerId", customerId);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            if (!reader.HasRows)
                return null;
            Customer customer = new Customer();
            if (reader.Read())
            {
                customer.Id = reader.GetInt32(0);
                customer.Name = reader.GetString(1);
                customer.Address = reader.GetString(2);
                customer.Phone = reader.GetString(3);
                customer.Email = reader.GetString(4);
                customer.AmountPayable = reader.GetInt32(5);
                customer.SalesLimit = reader.GetInt32(6);
            }
            connection.Close();
            return customer;
        }
        public bool RemoveCustomer(int customerId)
        {
            string query = "DELETE FROM Customer WHERE CustomerId = @CustomerId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@CustomerId", customerId);
            connection.Open();
            int noOfRowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return (noOfRowsAffected == 1);
        }
        public bool ChangeAmountPayable(int customerId, int newAmountPayable)
        {
            string query = "UPDATE Customer SET AmountPayable = @AmountPayable WHERE CustomerId = @CustomerId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@CustomerId", customerId);
            command.Parameters.AddWithValue("@AmountPayable", newAmountPayable);

            connection.Open();
            int noOfRowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return (noOfRowsAffected == 1);
        }
    }
}