<%@page import="DoctorPackage.*,java.util.*" %>
<html>
  <head>
    <title>Doctors</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
  </head>
<body>
  <div class="container-fluid text-center">
  <h2 class="mb-5">Doctors List</h2>
  <%
    ArrayList<DoctorBean> list = (ArrayList<DoctorBean>) request.getAttribute("list");
    if(list == null || list.size()==0){
      out.println("No Doctors Found");
      return;
    }
    String userType = (String) session.getAttribute("userType");
  %>
  <table class="table table-striped text-center table-hover">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Category</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <%
    for(int i=0;i<list.size();i++){
      DoctorBean doctor = list.get(i);
  %>
    <!-- <a href="./Controller?action=goToCreateAppointment&doctorUname=<%= doctor.getUname() %>"><div class="horizontal_container"><span><%= doctor.getName() %></span><span><%= doctor.getCategory() %></span></div> </a> -->
      <tr>
        <td><%= doctor.getName() %></td>
        <td><%= doctor.getCategory() %></td>
        <td>
        <%
          if(userType != null && userType == "admin"){
        %>
          <a href="./Controller?action=deleteDoctor&doctorUname=<%= doctor.getUname() %>" class="btn btn-outline-secondary">Delete</a>
        <%
          }else{
        %>
          <a href="./Controller?action=goToCreateAppointment&doctorUname=<%= doctor.getUname() %>" class="btn btn-outline-secondary">Schedule Appointment</a>
          <a href="./Controller?action=getDoctorAppointments&doctorUname=<%= doctor.getUname() %>" class="btn btn-outline-secondary">Doctor's Appointments</a>
        <%
          }
        %>
        </td>
      </tr>
  <%
    }
  %>
  </tbody>
  </table>
  </div>
</body>
</html>