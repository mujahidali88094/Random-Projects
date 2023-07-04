using System.Collections;
using System.Linq;

namespace ConsultationManager.Models
{
    public class PatientsRepository : IPatientsRepository
    {
        MasterContext dbContext;
        public PatientsRepository() { 
            this.dbContext = new MasterContext();
        } 
        public Patient? GetPatient(string email, string password)
        {
            //return dbContext.Patients.FirstOrDefault(patient => patient.Email == email && patient.Password == password);
            
            var query = from p in dbContext.Patients
                        where p.Email.Equals(email) && p.Password.Equals(password)
                        select p;

            List<Patient> patients = query.ToList();
            return patients.FirstOrDefault();

        }
        public List<Patient> GetPatients()
        {
            return dbContext.Patients.ToList();
        }
        public bool EmailNotAvailable(string email)
        {
            return dbContext.Patients.Any(patient => patient.Email.Equals(email));
        }
        public void AddPatient(Patient patient)
        {
            dbContext.Patients.Add(patient);
            dbContext.SaveChanges("system");
        }
        public void DeletePatient(string email, string deletedBy)
        {
            Patient? patient = dbContext.Patients.FirstOrDefault(patient => patient.Email == email);
            if (patient != null)
            {
                dbContext.Patients.Remove(patient);
                dbContext.SaveChanges(deletedBy);
            }
        }
    }
}