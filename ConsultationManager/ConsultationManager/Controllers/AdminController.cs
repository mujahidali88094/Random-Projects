using System.Diagnostics;
using ConsultationManager.Models;
using Microsoft.AspNetCore.Mvc;

namespace ConsultationManager.Controllers
{
    public class AdminController : Controller
    {
        IDoctorsRepository doctorsRepository;
        public AdminController(IDoctorsRepository doctorsRepository){
            this.doctorsRepository = doctorsRepository;
        }
        ConsultationsRepository consultationsRepository = new();
        public IActionResult Index()
        {
            bool isAdmin = CurrentSession.GetIsLoggedIn(HttpContext) && CurrentSession.GetUsertype(HttpContext).Equals("admin");
            if(!isAdmin){
                TempData["heading"] = "Error";
                TempData["message"] = "Only Admins can access this page!";
                return RedirectToAction("Index", "Info");
            }
            ViewBag.doctors = doctorsRepository.GetDoctors();
            ViewBag.navLinks = new List<ActionLink>
			{
				new ActionLink("Home", "Index", "Home")
			};
			return View();
        }
        public IActionResult DeleteDoctor(string email)
        {
            bool isAdmin = CurrentSession.GetIsLoggedIn(HttpContext) && CurrentSession.GetUsertype(HttpContext).Equals("admin");
            if(!isAdmin){
                TempData["heading"] = "Error";
                TempData["message"] = "Only Admins can delete a doctor!";
                return RedirectToAction("Index", "Info");
            }
            bool removed = doctorsRepository.DeleteDoctor(email, CurrentSession.GetEmail(HttpContext));
            if(!removed){
                TempData["heading"] = "Error";
                TempData["message"] = "Doctor Not Found!";
                return RedirectToAction("Index", "Info");
            }
            consultationsRepository.CancelAllConsultations(email, CurrentSession.GetEmail(HttpContext));
            TempData["heading"] = "Success";
            TempData["message"] = "Successfully removed the doctor and his/her consultations!";
            return RedirectToAction("Index", "Info");
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}