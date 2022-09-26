package AppointmentPackage;

import AppointmentPackage.*;
import DoctorPackage.*;
import PatientPackage.*;
import java.text.*;
import java.time.*;
import java.util.*; 
import java.sql.*;

public class AppointmentDAO {

  private Connection con; 
  private SimpleDateFormat javaToMySqlDateFormatter;
  private DateFormat mysqlToJavaDateParser = new SimpleDateFormat("yyyy-MM-dd HH:mm");

  public AppointmentDAO() throws Exception{
    establishConnection(); 
    javaToMySqlDateFormatter = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss") ;
  } 

  private void establishConnection() throws Exception{ 
    Class.forName("com.mysql.jdbc.Driver"); 
    String conUrl = "jdbc:mysql://127.0.0.1/appointments_portal";
    con = DriverManager.getConnection(conUrl,"root",""); 
  } 

  

  public boolean addAppointment(AppointmentBean p) throws Exception {

    String sql = " INSERT INTO Appointments VALUES (?, ?, ?, ?)"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    //LocalDateTime date = LocalDateTime.now();

    pStmt.setString( 1 , p.getPatientUname() ); 
    pStmt.setString( 2 , p.getDoctorUname() ); 
    pStmt.setString( 3 , javaToMySqlDateFormatter.format(p.getStart()) );
    pStmt.setString( 4 , javaToMySqlDateFormatter.format(p.getEnd()) );



    int rv = pStmt.executeUpdate();
    return (rv==1);

  }
  public ArrayList<AppointmentBean> getAllAppointments() throws Exception{
    return getAppointmentsBySql("SELECT * FROM appointments;");
  }
  public ArrayList<AppointmentBean> getDoctorAppointments(String doctorUname) throws Exception{
    return getAppointmentsBySql("SELECT * FROM appointments WHERE doctor_uname='"+doctorUname+"';");
  }
  public ArrayList<AppointmentBean> getPatientAppointments(String patientUname) throws Exception{
    return getAppointmentsBySql("SELECT * FROM appointments WHERE patient_uname='"+patientUname+"';");
  }
  public ArrayList<AppointmentBean> getCommonAppointments(String patientUname,String doctorUname) throws Exception{
    return getAppointmentsBySql("SELECT * FROM appointments WHERE patient_uname='"+patientUname+"' OR doctor_uname='"+doctorUname+"';");
  }
  private ArrayList<AppointmentBean> getAppointmentsBySql(String sql) throws Exception { 
    ArrayList<AppointmentBean> aps= new ArrayList<AppointmentBean>();

    DoctorDAO dd = new DoctorDAO();
    PatientDAO pd = new PatientDAO();

    PreparedStatement pStmt = con.prepareStatement(sql); 
    ResultSet rs = pStmt.executeQuery();
    while(rs.next()){
      String patientUname = rs.getString("patient_uname");
      String doctorUname = rs.getString("doctor_uname");
      String startString = rs.getString("start");
      String endString = rs.getString("end");
      
      
      java.util.Date start= mysqlToJavaDateParser.parse(startString);
      java.util.Date end= mysqlToJavaDateParser.parse(endString);

      //do not add if appointment has expired
      if(end.compareTo(new java.util.Date()) < 0){
        continue;
      }

      AppointmentBean ap = new AppointmentBean(patientUname,doctorUname,start,end);

      PatientBean patientBean = pd.getPatient(patientUname);
      ap.setPatientName(patientBean.getName());
      DoctorBean doctorBean = dd.getDoctor(doctorUname);
      ap.setDoctorName(doctorBean.getName());

      aps.add(ap);
    }
    return aps;

  }
  
  public boolean deleteAppointment(AppointmentBean p) throws Exception { 

    String sql = " DELETE FROM Appointments WHERE patient_uname=? AND doctor_uname=? AND start=? AND end=?;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , p.getPatientUname() ); 
    pStmt.setString( 2 , p.getDoctorUname() ); 
    pStmt.setString( 3 , javaToMySqlDateFormatter.format(p.getStart()) );
    pStmt.setString( 4 , javaToMySqlDateFormatter.format(p.getEnd()) );

    int rv = pStmt.executeUpdate();
    return (rv==1);

  }
  public boolean deleteDoctorAppointments(String doctorUname) throws Exception {

    String sql = " DELETE FROM Appointments WHERE doctor_uname=?;"; 
    PreparedStatement pStmt = con.prepareStatement(sql); 

    pStmt.setString( 1 , doctorUname );

    int rv = pStmt.executeUpdate();
    return (rv>0);

  }
}
