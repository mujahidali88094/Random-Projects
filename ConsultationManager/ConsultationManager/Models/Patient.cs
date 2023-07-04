using System.ComponentModel.DataAnnotations;

namespace ConsultationManager.Models
{
    public class Patient
    {
        [Key]
        public string Email { get; set; } = string.Empty;
        public string Password { get; set; } = string.Empty;
        public string Name { get; set; } = string.Empty;
        public string Picture { get; set; } = string.Empty;

        public override string ToString()
        {
            return $"Patient: {this.Name}, {this.Email}";
        }
    }
}