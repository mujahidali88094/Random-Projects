using System.Collections;

namespace ConsultationManager.Models
{
    public class AdminsRepository : IAdminsRepository
    {
        MasterContext dbContext;
        public AdminsRepository()
        {
            this.dbContext = new MasterContext();
        }
        public Admin? GetAdmin(string email, string password)
        {
            return dbContext.Admins.FirstOrDefault(admin => admin.Email == email && admin.Password == password);
        }
        public List<Admin> GetAdmins()
        {
            return dbContext.Admins.ToList();
        }
        public void AddAdmin(Admin admin)
        {
            dbContext.Admins.Add(admin);
            dbContext.SaveChanges();
        }
    }
}