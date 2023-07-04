using System.ComponentModel.DataAnnotations;

namespace ConsultationManager.Models
{
    public class Admin
    {
        [Key]
        public string Email { get; set; } = string.Empty;
        public string Password { get; set; } = string.Empty;
        public string Name { get; set; } = string.Empty;
    }
}