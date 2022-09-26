package DoctorPackage;

import DoctorPackage.DoctorBean;
import java.util.*; 
import java.sql.*; 

public class DoctorDAO{ 

  private Connection con; 

  public DoctorDAO() throws Exception{
    establishConnection(); 
  } 

  private void establishConnection() throws Exception{ 
    Class.forName("com.mysql.jdbc.Driver"); 
    String conUrl = "jdbc:mysql://127.0.0.1/appointments_portal";
    con = DriverManager.getConnection(conUrl,"root",""); 
  } 


  public boolean addDoctor(DoctorBean p, String password) throws Exception { 

    String sql = " INSERT INTO Doctors VALUES (?, ?, ?, ?)"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , p.getUname() ); 
    pStmt.setString( 2 , p.getName() );
    pStmt.setString( 3 , password );
    pStmt.setInt( 4, p.getCID() );

    int rv = pStmt.executeUpdate();
    return (rv==1);

  }

  public DoctorBean login(String uname, String password) throws Exception { 

    String sql = "SELECT * FROM Doctors WHERE uname = ? AND password = ? ;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , uname ); 
    pStmt.setString( 2 , password);

    ResultSet rs = pStmt.executeQuery();
    if(rs.next()){
      String name = rs.getString("name");
      int cid = rs.getInt("category");
      DoctorBean doctor = new DoctorBean(uname,name);
      doctor.setCID(cid);

      CategoriesDAO db = new CategoriesDAO();
      String category = db.getCategory(cid);
      if(category != null){
        doctor.setCategory(category);
      }

      return doctor;
    }
    return null;

  }
  public boolean deleteDoctor(String uname) throws Exception { 

    String sql = " DELETE FROM Doctors WHERE uname = ?"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , uname );

    int rv = pStmt.executeUpdate();
    return (rv==1);

  }
  public boolean usernameAlreadyExists(String uname) throws Exception { 

    String sql = "SELECT * FROM Doctors WHERE uname = ?;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , uname ); 

    ResultSet rs = pStmt.executeQuery();
    if(rs.next()){
      return true;
    }
    return false;

  }
  public DoctorBean getDoctor(String uname) throws Exception { 

    String sql = "SELECT * FROM Doctors WHERE uname = ?;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , uname ); 

    ResultSet rs = pStmt.executeQuery();
    if(rs.next()){
      String name = rs.getString("name");
      return new DoctorBean(uname,name);
    }
    return null;

  }
  public ArrayList<DoctorBean> getDoctorsByCategory(int key) throws Exception { 

    ArrayList<DoctorBean> list = new ArrayList<DoctorBean>();

    String sql = "SELECT * FROM Doctors WHERE category = ?;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setInt( 1 , key ); 

    ResultSet rs = pStmt.executeQuery();
    while(rs.next()){
      String name = rs.getString("name");
      String uname = rs.getString("uname");
      int cid = rs.getInt("category");
      DoctorBean doctor = new DoctorBean(uname,name);
      doctor.setCID(cid);
      
      CategoriesDAO db = new CategoriesDAO();
      String category = db.getCategory(cid);
      if(category != null){
        doctor.setCategory(category);
      }
      list.add(doctor);
    }
    return list;
  }
  public ArrayList<DoctorBean> searchDoctors(String text) throws Exception { 

    ArrayList<DoctorBean> list = new ArrayList<DoctorBean>();

    String sql = "SELECT * FROM Doctors WHERE UPPER(name) LIKE UPPER('%"+text+"%');"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 


    ResultSet rs = pStmt.executeQuery();
    while(rs.next()){
      String name = rs.getString("name");
      String uname = rs.getString("uname");
      int cid = rs.getInt("category");
      DoctorBean doctor = new DoctorBean(uname,name);
      doctor.setCID(cid);

      CategoriesDAO db = new CategoriesDAO();
      String category = db.getCategory(cid);
      if(category != null){
        doctor.setCategory(category);
      }

      list.add(doctor);
    }
    return list;
  }
}
