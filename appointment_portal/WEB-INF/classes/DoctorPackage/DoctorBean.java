package DoctorPackage;

public class DoctorBean{
  private String uname;
  private String name;
  private int cid;
  private String category;
  
  public DoctorBean(){}
  public DoctorBean(String uname,String name){
    this.setUname(uname);
    this.setName(name);
  }

  public void setUname(String uname){this.uname = uname;}
  public void setName(String name){this.name = name;}
  public void setCID(int cid){this.cid = cid;}
  public void setCategory(String category){this.category = category;}
  public String getUname(){return this.uname;}
  public String getName(){return this.name;}
  public int getCID(){return this.cid;}
  public String getCategory(){return this.category;}
}