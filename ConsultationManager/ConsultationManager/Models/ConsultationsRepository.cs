using System.Collections;
using System.Linq;

namespace ConsultationManager.Models
{
    public class ConsultationsRepository : IConsultationsRepository
    {
        MasterContext dbContext;
        public ConsultationsRepository() { 
            this.dbContext = new MasterContext();
        } 
        public List<Consultation> GetConsultationsOfPatient(string email)
        {
            var query = from c in dbContext.Consultations
                        where c.PatientEmail == email && c.End >= DateTime.Now
                        select c;

            List<Consultation> consultations = query.ToList();
            consultations.Sort((x, y) => x.Start.CompareTo(y.Start));
            return consultations;
        }
        public List<Consultation> GetConsultationsOfDoctor(string email)
        {
            var query = from c in dbContext.Consultations
                        where c.DoctorEmail == email && c.End >= DateTime.Now
                        select c;

            List<Consultation> consultations = query.ToList();
            consultations.Sort((x, y) => x.Start.CompareTo(y.Start));
            return consultations;
        }
        public List<Consultation> GetAllConsultations()
        {
            var query = from c in dbContext.Consultations
                        where c.End >= DateTime.Now
                        select c;

            List<Consultation> consultations = query.ToList();
            consultations.Sort((x, y) => x.Start.CompareTo(y.Start));
            return consultations;
        }
        public Consultation? GetConsultation(int id){
            var query = from c in dbContext.Consultations
                        where c.Id == id
                        select c;

            List<Consultation> consultations = query.ToList();
            if(consultations.Count == 0){
                return null;
            }
            return consultations[0];
        }
        public bool IsDoctorAvailable(string email, DateTime start, DateTime end)
        {
            var query = from c in dbContext.Consultations
                        where c.DoctorEmail == email
                        select c;

            List<Consultation> consultations = query.ToList();
            foreach (Consultation consultation in consultations)
            {
                if (consultation.ConicidesWith(start, end))
                    return false;
            }
            return true;
        }        
        public bool IsPatientAvailable(string email, DateTime start, DateTime end)
        {
            var query = from c in dbContext.Consultations
                        where c.PatientEmail == email
                        select c;

            List<Consultation> consultations = query.ToList();
            foreach (Consultation consultation in consultations)
            {
                if (consultation.ConicidesWith(start, end))
                    return false;
            }
            return true;
        }
        public void AddConsultation(string doctorEmail, string patientEmail, DateTime start, DateTime end)
        {
            if(start >= end){
                throw new Exception("Start time must be befor End");
            }
            if(!IsDoctorAvailable(doctorEmail, start, end)){
                throw new Exception("Doctor is not available at this time");
            }
            if(!IsPatientAvailable(patientEmail, start, end)){
                throw new Exception("Patient is not available at this time");
            }
            Consultation consultation = new Consultation(patientEmail, doctorEmail, start, end);
            dbContext.Consultations.Add(consultation);
            dbContext.SaveChanges(patientEmail);
        }
        public int CancelAllConsultations(string doctorEmail, string cancelledBy){
            var query = from c in dbContext.Consultations
                        where c.DoctorEmail == doctorEmail
                        select c;

            List<Consultation> consultations = query.ToList();
            int count = consultations.Count;
            foreach (Consultation consultation in consultations)
            {
                dbContext.Consultations.Remove(consultation);
            }
            dbContext.SaveChanges(cancelledBy);
            return count;
        }
        public void CancelConsultation(int id, string cancelledBy){
            var query = from c in dbContext.Consultations
                        where c.Id == id
                        select c;

            Consultation? consultation = query.FirstOrDefault();
            if(consultation == null){
                return;
            }
            dbContext.Consultations.Remove(consultation);
            dbContext.SaveChanges(cancelledBy);
        }
    }
}