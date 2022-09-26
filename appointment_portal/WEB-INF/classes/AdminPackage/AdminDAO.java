package AdminPackage;

import AdminPackage.AdminBean;
import java.util.*; 
import java.sql.*; 

public class AdminDAO{ 

  private Connection con; 

  public AdminDAO() throws Exception{
    establishConnection(); 
  } 

  private void establishConnection() throws Exception{ 
    Class.forName("com.mysql.jdbc.Driver"); 
    String conUrl = "jdbc:mysql://127.0.0.1/appointments_portal";
    con = DriverManager.getConnection(conUrl,"root",""); 
  } 


  public boolean addAdmin(AdminBean p, String password) throws Exception { 

    String sql = " INSERT INTO Admins VALUES (?, ?, ?)"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , p.getUname() ); 
    pStmt.setString( 2 , p.getName() ); 
    pStmt.setString( 3 , password );

    int rv = pStmt.executeUpdate();
    return (rv==1);

  }

  public AdminBean login(String uname, String password) throws Exception { 

    String sql = "SELECT * FROM Admins WHERE uname = ? AND password = ? ;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , uname ); 
    pStmt.setString( 2 , password);

    ResultSet rs = pStmt.executeQuery();
    if(rs.next()){
      String name = rs.getString("name");
      return new AdminBean(uname,name);
    }
    return null;

  }
  public boolean usernameAlreadyExists(String uname) throws Exception { 

    String sql = "SELECT * FROM Admins WHERE uname = ?;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , uname ); 

    ResultSet rs = pStmt.executeQuery();
    if(rs.next()){
      return true;
    }
    return false;

  }
}
