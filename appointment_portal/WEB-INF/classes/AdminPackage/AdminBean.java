package AdminPackage;

public class AdminBean{
  private String uname;
  private String name;

  public AdminBean(){}
  public AdminBean(String uname,String name){
    this.setUname(uname);
    this.setName(name);
  }

  public void setUname(String uname){this.uname = uname;}
  public void setName(String name){this.name = name;}
  public String getUname(){return this.uname;}
  public String getName(){return this.name;}
}