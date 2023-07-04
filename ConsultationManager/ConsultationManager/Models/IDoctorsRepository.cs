namespace ConsultationManager.Models
{
    public interface IDoctorsRepository
    {
        public List<Doctor> GetDoctors();
        public Doctor? GetDoctor(string email, string password);
        public bool EmailNotAvailable(string email);
        public void AddDoctor(Doctor doctor);
        public bool DeleteDoctor(string email, string deletedBy);
        public List<Doctor> GetDoctorsBySpecialization(string specialization);
    }
}