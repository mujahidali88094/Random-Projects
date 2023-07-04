namespace ConsultationManager.Models
{
    public interface IConsultationsRepository
    {
        public List<Consultation> GetConsultationsOfPatient(string email);
        public List<Consultation> GetConsultationsOfDoctor(string email);
        public List<Consultation> GetAllConsultations();
        public Consultation? GetConsultation(int id);
        public bool IsDoctorAvailable(string email, DateTime start, DateTime end);      
        public bool IsPatientAvailable(string email, DateTime start, DateTime end);
        public void AddConsultation(string doctorEmail, string patientEmail, DateTime start, DateTime end);
        public int CancelAllConsultations(string doctorEmail, string cancelledBy);
        public void CancelConsultation(int id, string cancelledBy);
    }
}