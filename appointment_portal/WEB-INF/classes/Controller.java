import java.io.*;
import java.sql.*;
import java.util.*;
import java.text.*;
import javax.servlet.*;
import javax.servlet.http.*;

import PatientPackage.*;
import AppointmentPackage.*;
import DoctorPackage.*;
import AdminPackage.*;

public class Controller extends HttpServlet {

    private void forwardToPage(String msg, String location, HttpServletRequest request, HttpServletResponse response){
        try{
            request.setAttribute("message", msg);
            RequestDispatcher rd = request.getRequestDispatcher(location);
            rd.forward(request, response);
        }catch(Exception e){
            
        }
    }

    // This method only calls processRequest() 
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        processRequest(request, response);
    }

    // This method only calls processRequest() 
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        processRequest(request, response);
    }

    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        DateFormat htmlToJavaDateParser = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm");

        try {
            String action = request.getParameter("action");
            PrintWriter out = response.getWriter();

            if (action == null) {
                response.sendRedirect("./errorpage.jsp");
            } else if (action.equals("redirectToPatientSignup")) {
                response.sendRedirect("./signup.jsp?userType=patient");
            } else if (action.equals("redirectToDoctorSignup")) {
                CategoriesDAO db = new CategoriesDAO();
                HashMap < Integer, String > categories = db.getCategories();
                request.setAttribute("doc_categories", categories);
                RequestDispatcher rd = request.getRequestDispatcher("./signup.jsp?userType=doctor");
                rd.forward(request, response);
                return;
            } else if (action.equals("redirectToAdminSignup")) {
                response.sendRedirect("./signup.jsp?userType=admin");
            } else if (action.equals("logout")) {
                HttpSession session = request.getSession(false);
                session.invalidate();
                response.sendRedirect("./login.jsp");
            } else if (action.equals("login")) {
                String uname = request.getParameter("uname");
                String password = request.getParameter("password");

                PatientDAO pdb = new PatientDAO();
                AdminDAO adb = new AdminDAO();
                DoctorDAO ddb = new DoctorDAO();

                PatientBean pb;AdminBean ab;DoctorBean db;

                if((pb = pdb.login(uname,password)) != null){
                    HttpSession session = request.getSession(true);
                    session.setAttribute("userType", "patient");
                    session.setAttribute("user", pb);
                    this.forwardToPage("Logged in as Patient", "./index.jsp", request,response);
                    return;
                }else if((ab = adb.login(uname,password)) != null){
                    HttpSession session = request.getSession(true);
                    session.setAttribute("userType", "admin");
                    session.setAttribute("user", ab);
                    this.forwardToPage("Logged in as Admin", "./index.jsp", request,response);
                    return;
                }else if((db = ddb.login(uname,password)) != null){
                    HttpSession session = request.getSession(true);
                    session.setAttribute("userType", "doctor");
                    session.setAttribute("user", db);
                    this.forwardToPage("Logged in as Doctor", "./index.jsp", request,response);
                    return;
                }else{
                    this.forwardToPage("Login Unsuccessful", "./index.jsp", request,response);
                    return;
                }
            } else if (action.equals("saveAdmin")) {
                String name = request.getParameter("name");
                String uname = request.getParameter("uname");
                String password = request.getParameter("password");
                AdminDAO db = new AdminDAO();
                if (db.usernameAlreadyExists(uname)) {
                    this.forwardToPage("Username already exists", "./errorpage.jsp", request,response);
                    return;
                }
                AdminBean adminBean = new AdminBean(uname, name);

                if (db.addAdmin(adminBean, password)) {

                    HttpSession session = request.getSession(true);
                    session.setAttribute("userType", "admin");
                    session.setAttribute("user", adminBean);
                    this.forwardToPage("Your accout was created", "./index.jsp", request,response);
                    return;
                } else {
                    response.sendRedirect("./errorpage.jsp");
                }
            } else if (action.equals("saveDoctor")) {
                String name = request.getParameter("name");
                String uname = request.getParameter("uname");
                String password = request.getParameter("password");
                int cid = Integer.parseInt(request.getParameter("cid"));
                DoctorDAO db = new DoctorDAO();
                if (db.usernameAlreadyExists(uname)) {
                    this.forwardToPage("Username already exists", "./errorpage.jsp", request,response);
                    return;
                }
                DoctorBean doctorBean = new DoctorBean(uname, name);
                doctorBean.setCID(cid);
                if (db.addDoctor(doctorBean, password)) {

                    CategoriesDAO _db = new CategoriesDAO();
                    String category = _db.getCategory(cid);
                    if (category != null) {
                        doctorBean.setCategory(category);
                    }
                    HttpSession session = request.getSession(true);
                    session.setAttribute("userType", "doctor");
                    session.setAttribute("user", doctorBean);
                    this.forwardToPage("Your accout was created", "./index.jsp", request,response);
                    return;
                }

            } else if (action.equals("savePatient")) {
                String name = request.getParameter("name");
                String uname = request.getParameter("uname");
                String password = request.getParameter("password");
                PatientDAO db = new PatientDAO();
                if (db.usernameAlreadyExists(uname)) {
                    this.forwardToPage("Username already exists", "./errorpage.jsp", request,response);
                    return;
                }
                PatientBean patientBean = new PatientBean(uname, name);

                if (db.addPatient(patientBean, password)) {

                    HttpSession session = request.getSession(true);
                    session.setAttribute("userType", "patient");
                    session.setAttribute("user", patientBean);
                    this.forwardToPage("Your accout was created", "./index.jsp", request,response);
                    return;
                } else {
                    response.sendRedirect("./errorpage.jsp");
                }
            } else if (action.equals("getDoctorAppointments")) {
                String doctorUname = request.getParameter("doctorUname");
                AppointmentDAO ad = new AppointmentDAO();
                ArrayList<AppointmentBean> arr = ad.getDoctorAppointments(doctorUname);
                Collections.sort(arr, new CustomComparator());
                request.setAttribute("appointments",arr);
                RequestDispatcher rd = request.getRequestDispatcher("./doc_appointments.jsp");
                rd.forward(request, response);
                return;
            } else if (action.equals("getPatientAppointments")) {
                HttpSession session = request.getSession(false);
                String userType = (String) session.getAttribute("userType");
                if(userType == null){
                    this.forwardToPage("Login First.", "./errorpage.jsp", request,response);
                    return;
                }
                if(userType != "patient"){
                    this.forwardToPage("Login as Patient first!", "./errorpage.jsp", request,response);
                    return;
                }
                PatientBean pb = (PatientBean) session.getAttribute("user");
                String patientUname = pb.getUname();
                AppointmentDAO ad = new AppointmentDAO();
                ArrayList<AppointmentBean> arr = ad.getPatientAppointments(patientUname);
                Collections.sort(arr, new CustomComparator());
                request.setAttribute("appointments",arr);
                RequestDispatcher rd = request.getRequestDispatcher("./patient_appointments.jsp");
                rd.forward(request, response);
                return;
            } else if (action.equals("saveAppointment")) {
                String doctorUname = request.getParameter("doctorUname");
                String patientUname = request.getParameter("patientUname");
                String startString = request.getParameter("start");
                String endString = request.getParameter("end");

                java.util.Date start = htmlToJavaDateParser.parse(startString);
                java.util.Date end = htmlToJavaDateParser.parse(endString);

                AppointmentBean ab = new AppointmentBean(patientUname,doctorUname,start,end);
                AppointmentDAO ad = new AppointmentDAO();
                DoctorDAO dd = new DoctorDAO();
                if(!dd.usernameAlreadyExists(doctorUname)){
                    this.forwardToPage("Invalid Doctor Username.", "./errorpage.jsp", request,response);
                    return;
                }
                if(ab.getStart().after(ab.getEnd())){
                    this.forwardToPage("Appointment should start before ending.", "./errorpage.jsp", request,response);
                    return;
                }
                ArrayList<AppointmentBean> patientAps = ad.getPatientAppointments(ab.getPatientUname());
                ArrayList<AppointmentBean> doctorAps = ad.getDoctorAppointments(ab.getDoctorUname());
                if(ab.hasClashWith(patientAps)){
                    this.forwardToPage("Appointment has clash with one of your appointments", "./errorpage.jsp", request,response);
                    return;
                }else if(ab.hasClashWith(doctorAps)){
                    this.forwardToPage("Appointment has clash with one of your Doctor's appointments", "./errorpage.jsp", request,response);
                    return;
                }
                if(ad.addAppointment(ab)){
                    this.forwardToPage("Appointment has been added.", "./index.jsp", request,response);
                    return;
                }else{
                    this.forwardToPage("Could not add this appointment", "./errorpage.jsp", request,response);
                    return;
                }
            } else if(action.equals("getDoctorCategories")){
                CategoriesDAO cd = new CategoriesDAO();
                HashMap<Integer,String> categories = cd.getCategories();
                request.setAttribute("categories",categories);
                RequestDispatcher rd = request.getRequestDispatcher("./doc_categories.jsp");
                rd.forward(request, response);
                return;
            } else if(action.equals("getDoctorsByCategory")){
                String keyString = request.getParameter("key");
                int key = Integer.parseInt(keyString);
                DoctorDAO dd = new DoctorDAO();
                ArrayList<DoctorBean> list = dd.getDoctorsByCategory(key);

                request.setAttribute("list",list);
                this.forwardToPage("Doctors List", "./doc_list.jsp", request,response);
                return;
            }else if(action.equals("redirectToSearchDoctors")){
                response.sendRedirect("./search_doctors.jsp");
            }else if(action.equals("searchDoctors")){
                String text = request.getParameter("searchText");
                DoctorDAO dd = new DoctorDAO();
                ArrayList<DoctorBean> list = dd.searchDoctors(text);

                request.setAttribute("list",list);
                this.forwardToPage("Doctors List", "./doc_list.jsp", request,response);
                return;
            } else if(action.equals("goToCreateAppointment")){
                String doctorUname = request.getParameter("doctorUname");
                DoctorDAO dd = new DoctorDAO();
                if(!dd.usernameAlreadyExists(doctorUname)){
                    this.forwardToPage("Invalid Doctor!","./errorpage.jsp",request,response);
                }
                RequestDispatcher rd = request.getRequestDispatcher("./create_appointment.jsp");
                rd.forward(request, response);
                return;
            } else if(action.equals("deleteAppointment")){
                String doctorUname = request.getParameter("doctorUname");
                String patientUname = request.getParameter("patientUname");
                String startString = request.getParameter("start");
                String endString = request.getParameter("end");

                java.util.Date start = htmlToJavaDateParser.parse(startString);
                java.util.Date end = htmlToJavaDateParser.parse(endString);

                AppointmentBean ab = new AppointmentBean(patientUname,doctorUname,start,end);
                AppointmentDAO ad = new AppointmentDAO();
                
                if(ad.deleteAppointment(ab)){
                    this.forwardToPage("Appointment Cancelled!","./index.jsp",request,response);
                }else{
                    this.forwardToPage("Unable to Cancel Appointment!","./errorpage.jsp",request,response);
                }
                return;
            } else if(action.equals("deleteDoctorAppointment")){
                String doctorUname = request.getParameter("doctorUname");
                AppointmentDAO ad = new AppointmentDAO();
                if(ad.deleteDoctorAppointments(doctorUname)){
                    this.forwardToPage("Appointment Cancelled!","./index.jsp",request,response);
                }else{
                    this.forwardToPage("Unable to Cancel Appointments!","./errorpage.jsp",request,response);
                }
                return;
            } else if(action.equals("deleteDoctor")){
                HttpSession session = request.getSession(false);
                String userType = (String) session.getAttribute("userType");
                if(userType == null){
                    this.forwardToPage("Login First.", "./errorpage.jsp", request,response);
                    return;
                }
                if(userType != "admin"){
                    this.forwardToPage("Login as Admin first!", "./errorpage.jsp", request,response);
                    return;
                }
                String doctorUname = request.getParameter("doctorUname");
                DoctorDAO dd = new DoctorDAO();
                if(dd.deleteDoctor(doctorUname)){
                    AppointmentDAO ad = new AppointmentDAO();
                    if(ad.deleteDoctorAppointments(doctorUname)){
                        this.forwardToPage("Doctor Deleted and Appointments Cancelled!","./index.jsp",request,response);
                    }else{
                        this.forwardToPage("Doctor Deleted but Unable to Cancel Appointments!","./errorpage.jsp",request,response);
                    }
                }else{
                    this.forwardToPage("Unable to Delete Doctor!","./errorpage.jsp",request,response);
                }
                return;
            } else {
                response.sendRedirect("./errorpage.jsp");
            }
        } catch (Exception e) {
            request.setAttribute("exception", e);
            this.forwardToPage("Unhandled Exception", "./errorpage.jsp", request,response);
            return;
        }


    }

}