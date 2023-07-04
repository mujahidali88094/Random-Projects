using System.ComponentModel.DataAnnotations;

namespace ConsultationManager.Models
{
    public class ConsultationDTO
    {
        [Required]
        public string doctorEmail { get; set; } 
        [Required]
        public DateTime date { get; set; } 
        [Required]
        public int start { get; set; } 
        [Required]
        public int end { get; set; } 
    }
}