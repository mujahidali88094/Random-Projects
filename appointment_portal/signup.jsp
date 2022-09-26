<html>
  <head>
    <title>Signup</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
    <style>
      form>*{
        margin: 0.3rem;
      }
    </style>
  </head>
  <body>
  <%@page import="java.util.*" %>
  <div class="container-fluid text-center">
    <h2 class="mb-5">Signup</h2>
  <%
    String sessionUserType = (String) session.getAttribute("userType");
    if(sessionUserType != null){
      response.sendRedirect("./index.jsp");
      return;
    }
  %>
  <div class="vstack gap-3 m-auto" style="max-width: 15rem;">
  <%

    String userType = request.getParameter("userType");
    if(userType==null){
  %>
      <a href='./Controller?action=redirectToPatientSignup' class="btn btn-outline-secondary">Signup as a patient</a>
      <a href='./Controller?action=redirectToDoctorSignup' class="btn btn-outline-secondary">Signup as a doctor</a>
      <a href='./Controller?action=redirectToAdminSignup' class="btn btn-outline-secondary">Signup as a admin</a>

  <%
      return;
    }
    switch(userType){

      case "patient":
  %>
      
        <form action='./Controller' method='POST' class="container">
          <label>Name</label>
          <input name='name' required class="form-control"/>
          <label>Userame</label>
          <input name='uname' required class="form-control"/>
          <label>Password</label>
          <input name='password' type='password' required class="form-control"/>
          <input type='hidden' name='action' value='savePatient'/>
          <input value='Signup' type='submit' class="btn btn-outline-secondary"/>
        </form>
      </div>
  <%
        break;

      case "doctor":

        HashMap<Integer,String> doc_categories = (HashMap<Integer,String>)request.getAttribute("doc_categories");
  %>
        <form action='./Controller' method='POST' class="container g-2">
          <label>Name</label>
          <input name='name' required class="form-control"/>
          <label>Userame</label>
          <input name='uname' required class="form-control"/>
          <label>Password</label>
          <input name='password' type='password' required class="form-control"/>
          <label for="cid">Choose a cateogry:</label>
          <select name="cid" class="form-select">

  <%
          for (Map.Entry<Integer, String> entry : doc_categories.entrySet()) {
            int key = entry.getKey();
            String value = entry.getValue();
            out.println("<option value='"+key+"'>"+value+"</option>");
          }
  %>
          </select>
          <input type='hidden' name='action' value='saveDoctor'/>
          <input value='Signup' type='submit' class="btn btn-outline-secondary"/>
        </form>
  <%
        break;

      case "admin":
  %>
        <form action='./Controller' method='POST' class="container">
          <label>Name</label>
          <input name='name' required class="form-control"/>
          <label>Userame</label>
          <input name='uname' required class="form-control"/>
          <label>Password</label>
          <input name='password' type='password' required class="form-control"/>
          <input type='hidden' name='action' value='saveAdmin'/>
          <input value='Signup' type='submit' class="btn btn-outline-secondary"/>
        </form>
  <%
        break;

      default:
  %>
        <a href='./Controller?action=redirectToPatientSignup' class="btn btn-outline-secondary">Signup as a patient</a>
        <a href='./Controller?action=redirectToDoctorSignup' class="btn btn-outline-secondary">Signup as a doctor</a>
        <a href='./Controller?action=redirectToAdminSignup' class="btn btn-outline-secondary">Signup as a admin</a>
  <%
        break;
      
    }
  %>
  </div>
</div>
</body></html>