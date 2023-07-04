namespace ConsultationManager.Models
{
    public class DoctorsRepository : IDoctorsRepository
    {
        MasterContext dbContext;
        public DoctorsRepository()
        {
            this.dbContext = new MasterContext();
        }
        public List<Doctor> GetDoctors() { return dbContext.Doctors.ToList(); }
        public Doctor? GetDoctor(string email, string password)
        {
            return dbContext.Doctors.FirstOrDefault(doctor => doctor.Email== email && doctor.Password == password);
        }
        public bool EmailNotAvailable(string email)
        {
            return dbContext.Doctors.Any(doctor => doctor.Email.Equals(email));
        }
        public void AddDoctor(Doctor doctor)
        {
            dbContext.Doctors.Add(doctor);
            dbContext.SaveChanges("system");
        }
        public bool DeleteDoctor(string email, string deletedBy)
        {
            Doctor? doctor = dbContext.Doctors.FirstOrDefault(doctor => doctor.Email == email);
            if (doctor == null) 
                return false;
            dbContext.Doctors.Remove(doctor);
            dbContext.SaveChanges(deletedBy);
            return true;
        }
        public List<Doctor> GetDoctorsBySpecialization(string specialization)
        {
            //return dbContext.Doctors.ToList().FindAll(doctor => doctor.Specialization.Equals(specialization));
            var query = from doctor in dbContext.Doctors
                        where doctor.Specialization.ToLower().Contains(specialization.ToLower())
                        select doctor;
            return query.ToList();
        }
    }
}