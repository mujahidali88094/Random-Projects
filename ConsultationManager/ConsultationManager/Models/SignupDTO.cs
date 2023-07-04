using System.ComponentModel.DataAnnotations;

namespace ConsultationManager.Models
{
    public class SignupDTO
    {
        [Required]
        public string email { get; set; }
        [Required]
        public string password { get; set; }
        [Required]
        public string name { get; set; }
        [Required]
        public string usertype { get; set; }
        public string? specialization { get; set; }
        [Required]
        public IFormFile picture { get; set; }
        public override string ToString(){
            return $"email: {email}, password: {password}, name: {name}, usertype: {usertype}, specialization: {specialization}";
        }
    }
}