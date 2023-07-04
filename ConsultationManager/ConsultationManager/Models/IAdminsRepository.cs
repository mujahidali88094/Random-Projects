using System.Collections;

namespace ConsultationManager.Models
{
    public interface IAdminsRepository
    {
        public Admin? GetAdmin(string email, string password);
        public List<Admin> GetAdmins();
        public void AddAdmin(Admin admin);
    }
}