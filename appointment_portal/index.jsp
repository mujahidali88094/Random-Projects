<%@ taglib prefix = "c" uri = "http://java.sun.com/jsp/jstl/core" %>
<%@page import="PatientPackage.*,DoctorPackage.*,AdminPackage.*,java.util.*" %>

<html>
  <head>
    <title>Appointment Portal</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
  </head>
  <body>
    <div class="container-fluid text-center">
    <h2 class="mb-5">Appointment Portal</h2>
    <div class="vstack gap-3 m-auto" style="max-width: 15rem;">
    <%
      String message = (String) request.getAttribute("message");
      if(message != null){
        out.println("<h4>"+message+"</h4>");
      }

      String userType = (String) session.getAttribute("userType");

      //user is logged in
      if(userType != null){
    %>
        <a href="./Controller?action=logout" class="btn btn-outline-secondary">Logout</a>
    <%
        if(userType.equals("patient")){
          PatientBean patient = (PatientBean) request.getAttribute("user");
    %>
        <a href="./Controller?action=getPatientAppointments" class="btn btn-outline-secondary">Appointments</a>
        <a href="./Controller?action=redirectToSearchDoctors" class="btn btn-outline-secondary">Search Doctors</a>
        <a href="./Controller?action=getDoctorCategories" class="btn btn-outline-secondary">Doctor Categories</a>
    <%
        }else if(userType.equals("doctor")){
          DoctorBean doctor = (DoctorBean) session.getAttribute("user");
          if(doctor == null){
            out.println("No user found");
            return;
          }
          String doctorUname = doctor.getUname();
          
    %>
      <a href="./Controller?action=getDoctorAppointments&doctorUname=<%=doctorUname%>" class="btn btn-outline-secondary">Appointments</a>
      <form action="./Controller" method="POST">
        <input type="hidden" name="doctorUname" value="<%=doctorUname%>"/>
        <input type="hidden" name="action" value="deleteDoctorAppointment"/>
        <input type="submit" value="Cancel All Appointments" class="btn btn-outline-secondary" />
      </form>
    <%

        }else if(userType.equals("admin")){
          AdminBean admin = (AdminBean) request.getAttribute("user");
    %>
        <a href="./Controller?action=redirectToSearchDoctors" class="btn btn-outline-secondary">Search Doctors</a>
        <a href="./Controller?action=getDoctorCategories" class="btn btn-outline-secondary">Doctor Categories</a>
    <%
        }
      }else{ //user is not logged in
    %>
        <a href="signup.jsp" class="btn btn-outline-secondary">Signup</a>
        <a href="login.jsp" class="btn btn-outline-secondary">Login</a>
    <%
      }
    %>
    </div>
  </div>
  </body>
</html>