using System.Diagnostics;
using ConsultationManager.Models;
using Microsoft.AspNetCore.Mvc;

namespace ConsultationManager.Controllers
{
    public class PatientsController : Controller
    {
        IPatientsRepository patientsRepository;
        public PatientsController(IPatientsRepository patientsRepository)
        {
            this.patientsRepository = patientsRepository;            
        }
        public IActionResult Index()
        {
            ViewBag.patients = patientsRepository.GetPatients();
            ViewBag.navLinks = new List<ActionLink>
			{
				new ActionLink("Home", "Index", "Home")
			};
			return View();
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}