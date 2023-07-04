using System.ComponentModel;
using ConsultationManager.Models;

namespace ConsultationManager.Controllers
{
    public class Utilities
    {
        public static string UploadFile(IFormFile file, string destination)
        {
            string fullDestination = Path.Combine("wwwroot",destination);
            if (!Directory.Exists(fullDestination))
            {
                Directory.CreateDirectory(fullDestination);
            }
            if (file.Length > 0)
            {
                //var filePath = Path.GetTempFileName();
                // string newFileName = Path.GetFileNameWithoutExtension(Path.GetFileName(filePath));
                string newFileName = Guid.NewGuid().ToString().Substring(0,8);
                string extension = Path.GetExtension(file.FileName);
                newFileName += extension;
                using (var stream = File.Create(Path.Combine(fullDestination, newFileName)))
                {
                    file.CopyTo(stream);
                }
                return Path.Combine(destination, newFileName);
            }
            return "";
        }
    }
}