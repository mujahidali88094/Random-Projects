using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace ConsultationManager.Models
{
    public class Consultation
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int Id { get; set; }
        public string PatientEmail { get; set; }
        public string DoctorEmail { get; set; }
        public DateTime Start {get; set;}
        public DateTime End {get; set;}
        public Consultation (string patientEmail, string doctorEmail, DateTime start, DateTime end)
        {
            PatientEmail = patientEmail;
            DoctorEmail = doctorEmail;
            Start = start;
            End = end;
        }
        public bool ConicidesWith(DateTime otherStart, DateTime otherEnd){
            return !(Start < otherStart && End <= otherStart) && !(Start >= otherEnd && End > otherEnd);
        }
    }
}