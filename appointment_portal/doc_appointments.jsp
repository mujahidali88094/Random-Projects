<%@page import="AppointmentPackage.*,DoctorPackage.*,java.util.*" %>

<html>
  <head>
    <title>Appointments</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
  </head>
<body>
<div class="container-fluid text-center">
<h2 class="mb-5">Doctor Appointments</h2>
  <%
    ArrayList<AppointmentBean> apms = (ArrayList<AppointmentBean>) request.getAttribute("appointments");
    if(apms == null || apms.size()==0){
      out.println("No appointments found");
      return;
    }
  %>
  <table class="table table-striped text-center table-hover">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Patient</th>
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
        <td><%= apm.getPatientName() %></td>
        <td><%= apm.getDoctorName() %></td>
        <td><%= apm.getStart() %></td>
        <td><%= apm.getEnd() %></td>
  </tr>
  <%
    }
  %>

  </tbody>
  </table>



</body>
</html>