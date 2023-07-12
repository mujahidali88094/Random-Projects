using System.Data.SqlClient;
using DTO;

namespace DAL
{
    public class ReceiptDAL
    {
        SqlConnection connection;
        public ReceiptDAL()
        {
            string connectionString = "Data Source=(LocalDB)\\MSSQLLocalDB;AttachDbFilename=D:\\PUCIT\\EAD\\EAD_POS_A01\\DB\\pos.mdf;Integrated Security=True;Connect Timeout=30";
            connection = new SqlConnection(connectionString);
        }
        public bool AddReceipt(Receipt receipt)
        {
            string query = "INSERT INTO Receipt (OrderId, ReceiptDate, Amount) VALUES (@OrderId, @Date, @Amount)";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@OrderId", receipt.OrderId);
            command.Parameters.AddWithValue("@Date", receipt.Date);
            command.Parameters.AddWithValue("@Amount", receipt.Amount);
            connection.Open();
            int rowAffected = command.ExecuteNonQuery();
            connection.Close();
            return rowAffected > 0;
        }
        public List<Receipt> GetReceipts(int orderId)
        {
            string query = "SELECT * FROM Receipt WHERE OrderId = @orderId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@OrderId", orderId);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            List<Receipt> receipts = new List<Receipt>();
            while (reader.Read())
            {
                Receipt receipt = new Receipt
                {
                    ReceiptNo = reader.GetInt32(0),
                    Date = reader.GetDateTime(1),
                    OrderId = reader.GetInt32(2),
                    Amount = reader.GetInt32(3)
                };
                receipts.Add(receipt);
            }
            connection.Close();
            return receipts;
        }
        
    }
}