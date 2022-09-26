<%@page import="AppointmentPackage.*,java.text.*,java.util.*" %>
<html><body>
  <%

    DateFormat htmlToJavaDateParser = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm");
    AppointmentDAO ad = new AppointmentDAO();
    ArrayList<AppointmentBean> patientAps = ad.getPatientAppointments("nayab123");
    for(int i=0;i<patientAps.size();i++){
        AppointmentBean current = patientAps.get(i);
        out.println(current);
    }
  %>
  <br>
  <%

    java.util.Date start=htmlToJavaDateParser.parse("2022-09-14T19:41");
    java.util.Date end=htmlToJavaDateParser.parse("2022-09-14T20:41");
    String patientUname="nayab123";
    String doctorUname="faizi123";

    AppointmentBean temp = new AppointmentBean(patientUname,doctorUname,start,end);
    out.println(temp);

    if(temp.hasClashWith(patientAps)){
      out.println("true");
    }
  %>
</body></html>