<%@page import="java.util.*" %>
<html>
  <head>
    <title>Categories</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
  </head>
<body>
  <div class="container-fluid text-center">
  <h2 class="mb-5">Doctor Categories</h2>
  <div class="vstack gap-3 m-auto" style="max-width: 15rem;">
  <%
    HashMap<Integer,String> categories = (HashMap<Integer,String>) request.getAttribute("categories");
    if(categories == null){
      out.println("Nothing to Display");
      return;
    }
    for (Map.Entry<Integer, String> entry : categories.entrySet()) {
      int key = ((Integer) entry.getKey()).intValue();
      String value = (String) entry.getValue();
  %>
      <a href="./Controller?action=getDoctorsByCategory&key=<%= key %>" class="btn btn-outline-secondary"><%= value %></a>
      
  <%
    }
  %>
  </div>
  </div>
</body>
</html>