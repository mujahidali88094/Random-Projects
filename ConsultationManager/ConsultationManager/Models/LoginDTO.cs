using System.ComponentModel.DataAnnotations;

namespace ConsultationManager.Models
{
    public class LoginDTO
    {
        [Required]
        public string email { get; set; }
        [Required]
        public string password { get; set; }
        [Required]
        public string usertype { get; set; }
    }
}