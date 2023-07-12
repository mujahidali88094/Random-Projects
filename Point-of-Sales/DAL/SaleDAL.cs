using System.Data.SqlClient;
using DTO;

namespace DAL
{
    public class SaleDAL
    {
        SqlConnection connection;
        public SaleDAL()
        {
            string connectionString = "Data Source=(LocalDB)\\MSSQLLocalDB;AttachDbFilename=D:\\PUCIT\\EAD\\EAD_POS_A01\\DB\\pos.mdf;Integrated Security=True;Connect Timeout=30";
            connection = new SqlConnection(connectionString);
        }
        public int GetAvailableSaleId()
        {
            string query = "SELECT MAX(OrderId) FROM Sale";
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
        public bool AddSale(Sale sale)
        {
            string query = "INSERT INTO Sale (OrderId, CustomerId, Date, Status) VALUES (@OrderId, @CustomerId, @Date, @Status)";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@OrderId", sale.OrderId);
            command.Parameters.AddWithValue("@CustomerId", sale.CustomerId);
            command.Parameters.AddWithValue("@Date", sale.Date);
            command.Parameters.AddWithValue("@Status", sale.Status);
            connection.Open();
            int rowsAffected = command.ExecuteNonQuery();
            connection.Close();
            if (rowsAffected > 0)
                return true;
            else
                return false;
        }
        public Sale? GetSale(int orderId)
        {
            string query = "SELECT * FROM Sale WHERE OrderId = @orderId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("orderId", orderId);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            Sale sale = new Sale
            {
                OrderId = -99
            };
            if (reader.Read())
            {
                sale.OrderId = reader.GetInt32(0);
                sale.CustomerId = reader.GetInt32(1);
                sale.Date = reader.GetDateTime(2);
                sale.Status = reader.GetString(3);
            }
            connection.Close();
            if (sale.OrderId == -99)
                return null;
            return sale;
        }
        public bool UpdateSaleStatus(int orderId, string status)
        {
            string query = "UPDATE Sale SET Status = @Status WHERE OrderId = @OrderId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@OrderId", orderId);
            command.Parameters.AddWithValue("@Status", status);

            connection.Open();
            int rowsAffected = command.ExecuteNonQuery();
            connection.Close();
            if (rowsAffected > 0)
                return true;
            else
                return false;
        }
        public bool ItemExistsInASale(int itemId)
        { 
            string query = "SELECT * FROM SaleLineItem WHERE ItemId = @ItemId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@ItemId", itemId);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            bool exists = reader.HasRows;
            connection.Close();
            return exists;
        }
        public bool AddSaleLineItem(SaleLineItem saleLineItem)
        {
            string query = "INSERT INTO SaleLineItem (OrderId, ItemId, Quantity, Amount) VALUES (@OrderId, @ItemId, @Quantity, @Amount)";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@OrderId", saleLineItem.OrderId);
            command.Parameters.AddWithValue("@ItemId", saleLineItem.ItemId);
            command.Parameters.AddWithValue("@Quantity", saleLineItem.Quantity);
            command.Parameters.AddWithValue("@Amount", saleLineItem.Amount);
            connection.Open();
            int rowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return rowsAffected == 1;
        }
        public bool RemoveSaleLineItem(int orderId, int itemId)
        {
            string query = "DELETE FROM SaleLineItem WHERE OrderId = @OrderId AND ItemId = @ItemId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@OrderId", orderId);
            command.Parameters.AddWithValue("@ItemId", itemId);

            connection.Open();
            int rowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return rowsAffected == 1;
        }
        public List<SaleLineItem> GetSaleLineItems(int orderId)
        {
            string query = "SELECT * FROM SaleLineItem WHERE OrderId = @orderId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("orderId", orderId);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            List<SaleLineItem> saleLineItems = new List<SaleLineItem>();
            while (reader.Read())
            {
                SaleLineItem saleLineItem = new SaleLineItem
                {
                    LineNo = reader.GetInt32(0),
                    OrderId = reader.GetInt32(1),
                    ItemId = reader.GetInt32(2),
                    Quantity = reader.GetInt32(3),
                    Amount = reader.GetInt32(4)
                };
                saleLineItems.Add(saleLineItem);
            }
            connection.Close();
            return saleLineItems;
        }
    }
}