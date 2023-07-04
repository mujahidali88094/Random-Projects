using System.ComponentModel.DataAnnotations;

namespace ConsultationManager.Models
{
    public class Doctor
    {
        [Key]
        public string Email { get; set; } = string.Empty;
        public string Password { get; set; } = string.Empty;
        public string Name { get; set; } = string.Empty;
        public string Picture { get; set; } = string.Empty;
        public string Specialization { get; set; } = string.Empty;
    }
}