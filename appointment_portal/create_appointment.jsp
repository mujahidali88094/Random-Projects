<%@page import="AppointmentPackage.*,PatientPackage.*,java.util.*" %>

<html>
<body>
<h2>Create Appointment</h2>
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
    PatientBean patient = (PatientBean) session.getAttribute("user");
    String patientUname = patient.getUname();
    String doctorUname = request.getParameter("doctorUname");
  %>
  <h2>Appointment</h2>
  <form action="./Controller">
    <label for="start">Start Time</label>
    <input type="datetime-local" name="start" id="start"/>
    <label for="end">End Time</label>
    <input type="datetime-local" name="end" id="end"/>

    <input type="hidden" name="patientUname" value="<%= patientUname %>" />
    <input type="hidden" name="doctorUname" value="<%= doctorUname %>" />
    <input type="hidden" name="action" value="saveAppointment" />
    <input type="submit">
  </form>

  <script>
    function toIsoString(date) {
      var tzo = -date.getTimezoneOffset(),
          dif = tzo >= 0 ? '+' : '-',
          pad = function(num) {
              return (num < 10 ? '0' : '') + num;
          };

      return date.getFullYear() +
          '-' + pad(date.getMonth() + 1) +
          '-' + pad(date.getDate()) +
          'T' + pad(date.getHours()) +
          ':' + pad(date.getMinutes())
    }
    function addMinutes(date, minutes) {
        return new Date(date.getTime() + minutes*60000);
    }

    startElement =  document.getElementById("start");
    endElement =  document.getElementById("end");

    startOffset = 30;
    endOffset = startOffset + 60;

    startElement.value = toIsoString(new Date(addMinutes(new Date(),startOffset)))
    endElement.value = toIsoString(new Date(addMinutes(new Date(),endOffset)))



  </script>



</body>
</html>