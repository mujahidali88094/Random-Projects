using System.Diagnostics;
using ConsultationManager.Models;
using Microsoft.AspNetCore.Mvc;

namespace ConsultationManager.Controllers
{
    public class DoctorsController : Controller
    {
        IDoctorsRepository doctorsRepository;
        public DoctorsController(IDoctorsRepository doctorsRepository)
        {
            this.doctorsRepository = doctorsRepository;
        }
        public IActionResult Index(string specialization)
        {
            if(specialization == null || specialization == "")
                ViewBag.doctors = doctorsRepository.GetDoctors();
            else
                ViewBag.doctors = doctorsRepository.GetDoctorsBySpecialization(specialization);
            ViewBag.navLinks = new List<ActionLink>
			{
				new ActionLink("Home", "Index", "Home")
			};
			return View();
        }
        public IActionResult GetDoctors(string specialization)
        {
            // Console.WriteLine("Specialization is "+specialization);
            return Json(doctorsRepository.GetDoctorsBySpecialization(specialization));
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}