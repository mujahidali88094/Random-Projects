<%@page import="java.time.*,java.text.*,AppointmentPackage.AppointmentDAO" %>
<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
  </head>
  <body>
    
    <div class="container-fluid text-center">
    <h2 class="mb-5">Login</h2>
    <%
      String userType = (String) session.getAttribute("userType");
      if(userType != null){
        response.sendRedirect("./index.jsp");
        return;
      }
    %>
      <form action="./Controller" method="POST">
        <div class="vstack gap-3 m-auto" style="max-width: 15rem;">
          <label for="uname">UserName</label>
          <input type="text" name="uname" class="form-control" required/>
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" required/>
          <input type="hidden" name="action" value="login">
          <input type="submit" value="Login" class="btn btn-outline-secondary">
        </div>
      </form>
    </div>
  </body>
</html>