package AppointmentPackage;

import PatientPackage.PatientBean;
import DoctorPackage.DoctorBean;
import AppointmentPackage.CustomComparator;
import java.util.*; 
import java.time.*;

public class AppointmentBean {
  private String patientUname;
  private String doctorUname;
  private java.util.Date start;
  private java.util.Date end;

  private String patientName;
  private String doctorName;

  public AppointmentBean(){}
  public AppointmentBean(String p, String d, java.util.Date s, java.util.Date e){
    this.setPatientUname(p);
    this.setDoctorUname(d);
    this.setStart(s);
    this.setEnd(e);
  }

  public String getPatientUname(){return patientUname;}
  public String getDoctorUname(){return doctorUname;}
  public java.util.Date getStart(){return start;}
  public java.util.Date getEnd(){return end;}
  public String getPatientName(){return patientName;}
  public String getDoctorName(){return doctorName;}

  public void setPatientUname(String p){this.patientUname = p;}
  public void setDoctorUname(String p){this.doctorUname = p;}
  public void setStart(java.util.Date p){this.start = p;}
  public void setEnd(java.util.Date p){this.end = p;}
  public void setPatientName(String p){this.patientName = p;}
  public void setDoctorName(String p){this.doctorName = p;}
  
  public String toString(){
    return "Appointment\nPatient: "+this.getPatientUname()
            +"\nDoctor: "+this.getDoctorUname()
            +"\nStarting Time: "+this.getStart()
            +"\nEnding Time:"+this.getEnd()+"\n";
  }

  public boolean hasClashWith(AppointmentBean current){
    if(start.compareTo(current.getStart()) == 0 || end.compareTo(current.getEnd()) == 0)
      return true;
    if(start.compareTo(current.getStart()) > 0 && start.compareTo(current.getEnd()) < 0)
      return true;
    if(end.compareTo(current.getStart()) > 0 && end.compareTo(current.getEnd()) < 0)
      return true;
    return false;
  }
  public boolean hasClashWith(ArrayList<AppointmentBean> aps){
    Collections.sort(aps, new CustomComparator());

    if(aps.size()==1){
      return this.hasClashWith(aps.get(0));
    }

    for(int i=1;i<aps.size();i++){
      AppointmentBean current = aps.get(i-1);
      AppointmentBean next = aps.get(i);

      if(this.hasClashWith(current)){
        return true;
      }

      if(start.after(current.getStart()) && start.before(next.getStart())){
        if(start.before(current.getEnd()) || end.after(next.getStart())){
          return true;
        }
      }
    }
    return false;
  }

}
