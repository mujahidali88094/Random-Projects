<%@page import="AppointmentPackage.*,java.util.*,java.text.*" %>

<html>
  <head>
    <title>Appointments</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
  </head>
<body>
  <div class="container-fluid text-center">
<h2 class="mb-5">Patient Appointments</h2>
  <%
    String userType = (String) session.getAttribute("userType");
    if(userType == null){
      out.println("Login First!");
      return;
    }
    if(userType!="patient"){
      out.println("Login as Patient first!");
      return;
    }
    SimpleDateFormat javaToHtmlFormatter = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm") ;
    ArrayList<AppointmentBean> apms = (ArrayList<AppointmentBean>) request.getAttribute("appointments");
    if(apms == null || apms.size()==0){
      out.println("No appointments found");
      return;
    }
  %>
  <table class="table table-striped text-center table-hover">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Doctor</th>
      <th scope="col">From</th>
      <th scope="col">To</th>
    </tr>
  </thead>
  <tbody>
  <%
    for (int i = 0; i < apms.size(); i++){
      AppointmentBean apm = apms.get(i);
  %>
      <tr>
        <td><%= apm.getDoctorName() %></td>
        <td><%= apm.getStart() %></td>
        <td><%= apm.getEnd() %></td>
        <td>
          <form action="./Controller" method="POST">
            <input type="hidden" name="patientUname" value="<%= apm.getPatientUname() %>">
            <input type="hidden" name="doctorUname" value="<%= apm.getDoctorUname() %>">
            <input type="hidden" name="start" value="<%= javaToHtmlFormatter.format(apm.getStart()) %>">
            <input type="hidden" name="end" value="<%= javaToHtmlFormatter.format(apm.getEnd()) %>">
            <input type="hidden" name="action" value="deleteAppointment">
            <input type="submit" class="btn btn-outline-secondary" value="Cancel"/>
          </form>
      </tr>
  <%
    }
  %>
  </tbody>
  </table>


</div>
</body>
</html>