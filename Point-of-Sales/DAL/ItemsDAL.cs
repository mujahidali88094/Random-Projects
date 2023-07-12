using System.Data.SqlClient;
using DTO;

namespace DAL
{
    public class ItemsDAL
    {
        SqlConnection connection;
        public ItemsDAL()
        {
            string connectionString = "Data Source=(LocalDB)\\MSSQLLocalDB;AttachDbFilename=D:\\PUCIT\\EAD\\EAD_POS_A01\\DB\\pos.mdf;Integrated Security=True;Connect Timeout=30";
            connection = new SqlConnection(connectionString);
        }

        public List<Item> GetItems()
        {
            string query = "SELECT * FROM Item";
            SqlCommand command = new SqlCommand(query, connection);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            List<Item> items = new List<Item>();
            while (reader.Read())
            {
                Item item = new Item();
                item.Id = reader.GetInt32(0);
                item.Description = reader.GetString(1);
                item.Quantity = reader.GetInt32(2);
                item.Price = reader.GetInt32(3);
                item.CreationDate = reader.GetDateTime(4);
                items.Add(item);
            }
            connection.Close();
            return items;
        }
        public Item? GetItemById(int id)
        {
            string query = "SELECT * FROM Item WHERE ItemId = @id";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("id", id);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            if (!reader.HasRows)
            {
                connection.Close();
                return null;
            }
            Item item = new Item();
            if (reader.Read())
            {
                item.Id = reader.GetInt32(0);
                item.Description = reader.GetString(1);
                item.Quantity = reader.GetInt32(2);
                item.Price = reader.GetInt32(3);
                item.CreationDate = reader.GetDateTime(4);
            }
            connection.Close();
            return item;
        }
        public bool AddItem(Item item)
        {
            string query = "INSERT INTO Item (ItemId, Description, Price, Quantity, CreationDate) VALUES (@ItemId, @Description, @Price, @Quantity, @CreationDate)";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@ItemId", item.Id);
            command.Parameters.AddWithValue("@Description", item.Description);
            command.Parameters.AddWithValue("@Price", item.Price);
            command.Parameters.AddWithValue("@Quantity", item.Quantity);
            command.Parameters.AddWithValue("@CreationDate", item.CreationDate);
            connection.Open();
            int noOfRowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return (noOfRowsAffected == 1);
            
        }
        public bool ItemExists(int id)
        {
            string query = "SELECT * FROM Item WHERE ItemId = @ItemId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@ItemId", id);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            bool exists = reader.HasRows;
            connection.Close();
            return exists;
        }
        public bool RemoveItem(int id)
        {
            string query = "DELETE FROM Item WHERE ItemId = @Id";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@Id", id);
            connection.Open();
            int noOfRowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return (noOfRowsAffected == 1);
        }
        public int GetAvailableId()
        {
            string query = "SELECT MAX(ItemId) FROM Item";
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
        public bool UpdateItem(int id, Item updatedItem) 
        {
            string query = "UPDATE Item SET Description = @Description, Price = @Price, Quantity = @Quantity, CreationDate = @CreationDate WHERE ItemId = @ItemId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@Description", updatedItem.Description);
            command.Parameters.AddWithValue("@Price", updatedItem.Price);
            command.Parameters.AddWithValue("@Quantity", updatedItem.Quantity);
            command.Parameters.AddWithValue("@CreationDate", updatedItem.CreationDate);
            command.Parameters.AddWithValue("@ItemId", id);
            connection.Open();
            int noOfRowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return (noOfRowsAffected == 1);
        }
        public List<Item> FindItems(Item item)
        {
            string query = "SELECT * FROM Item";

            List<string> whereConditions = new List<string>();
            if (item.Id >= 0)
                whereConditions.Add("ItemId = @ItemId");
            if (item.Description != string.Empty)
                whereConditions.Add("Description LIKE @Description");
            if (item.Price >= 0)
                whereConditions.Add("Price = @Price");
            if (item.Quantity >= 0)
                whereConditions.Add("Quantity = @Quantity");
            if (item.CreationDate != DateTime.Now.Date)
                whereConditions.Add("CreationDate = @CreationDate");

            if (whereConditions.Count > 0)
            {
                query += " WHERE " + string.Join(" AND ", whereConditions);
            }

            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@ItemId", item.Id);
            command.Parameters.AddWithValue("@Description", "%" + item.Description + "%");
            command.Parameters.AddWithValue("@Price", item.Price);
            command.Parameters.AddWithValue("@Quantity", item.Quantity);
            command.Parameters.AddWithValue("@CreationDate", item.CreationDate);
            connection.Open();
            SqlDataReader reader = command.ExecuteReader();
            List<Item> items = new List<Item>();
            while (reader.Read())
            {
                Item _item = new Item();
                _item.Id = reader.GetInt32(0);
                _item.Description = reader.GetString(1);
                _item.Quantity = reader.GetInt32(2);
                _item.Price = reader.GetInt32(3);
                _item.CreationDate = reader.GetDateTime(4);
                items.Add(_item);
            }
            connection.Close();
            return items;
        }
        public bool UpdateItemQuantity(int itemId, int quantity)
        {
            string query = "UPDATE Item SET Quantity = @Quantity WHERE ItemId = @ItemId";
            SqlCommand command = new SqlCommand(query, connection);
            command.Parameters.AddWithValue("@Quantity", quantity);
            command.Parameters.AddWithValue("@ItemId", itemId);
            connection.Open();
            int noOfRowsAffected = command.ExecuteNonQuery();
            connection.Close();
            return (noOfRowsAffected == 1);
        }
    }
}