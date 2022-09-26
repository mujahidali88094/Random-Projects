<html><body>
  <%
    String message= (String) request.getAttribute("message");
    Exception e = (Exception) request.getAttribute("exception");
    if(message == null){
      out.println("<h2>Oops, An Unexpected Error Occurred!</h2>");
      out.println("<h5>We regret the inconvenience happened.</h5>");
    }else{
      out.println("<h2>"+message+"</h2>");
    }
    if(e != null){
      out.println("Exception: "+e);
    }
  %>
  <a href="index.jsp">Home Page</a>
</body></html>