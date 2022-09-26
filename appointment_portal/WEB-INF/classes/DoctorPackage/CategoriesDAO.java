package DoctorPackage;

import java.util.*; 
import java.sql.*; 

public class CategoriesDAO{ 

  private Connection con; 

  public CategoriesDAO() throws Exception{
    establishConnection(); 
  } 

  private void establishConnection() throws Exception{ 
    Class.forName("com.mysql.jdbc.Driver"); 
    String conUrl = "jdbc:mysql://127.0.0.1/appointments_portal";
    con = DriverManager.getConnection(conUrl,"root",""); 
  } 

  public String getCategory(int id) throws Exception { 

    String sql = "SELECT * FROM doc_categories WHERE id=?;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 
    pStmt.setInt(1,id);
    ResultSet rs = pStmt.executeQuery();
    if(rs.next()){
      String name = rs.getString("name");
      return name;
    }
    return null;
  }
  public HashMap<Integer,String> getCategories() throws Exception { 

    HashMap<Integer,String> categories = new HashMap<Integer,String>();

    String sql = "SELECT * FROM doc_categories;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    ResultSet rs = pStmt.executeQuery();
    while(rs.next()){
      int id = rs.getInt("id");
      String name = rs.getString("name");
      categories.put(id,name);
    }
    return categories;
  }
  
}
