using System.Collections;
using System.Linq;

namespace ConsultationManager.Models
{
    public interface IPatientsRepository
    {
        public Patient? GetPatient(string email, string password);
        public List<Patient> GetPatients();
        public bool EmailNotAvailable(string email);
        public void AddPatient(Patient patient);
        public void DeletePatient(string email, string deletedBy);
    }
}