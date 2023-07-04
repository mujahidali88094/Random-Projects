using System.Diagnostics;
using ConsultationManager.Models;
using Microsoft.AspNetCore.Mvc;

namespace ConsultationManager.Controllers
{
    public class ConsultationsController : Controller
    {
        IConsultationsRepository consultationsRepository;
        IDoctorsRepository doctorsRepository;
        public ConsultationsController(IConsultationsRepository consultationsRepository, IDoctorsRepository doctorsRepository)
        {
            this.consultationsRepository = consultationsRepository;
            this.doctorsRepository = doctorsRepository;
        }
        public IActionResult Index()
        {
			ViewBag.navLinks = new List<ActionLink>();
			ViewBag.navLinks.Add(new ActionLink("Home", "Index", "Home"));
            if(CurrentSession.GetIsLoggedIn(HttpContext) && CurrentSession.GetUsertype(HttpContext)=="patient"){
                ViewBag.navLinks.Add(new ActionLink("Only Yours", "PatientOnly", "Consultations"));
                ViewBag.navLinks.Add(new ActionLink("Create New", "CreateNew", "Consultations"));
            }else if(CurrentSession.GetIsLoggedIn(HttpContext) && CurrentSession.GetUsertype(HttpContext)=="doctor"){
                ViewBag.navLinks.Add(new ActionLink("Only Yours", "Doctor", "Consultations"));
            }
            List<Consultation> consultations = consultationsRepository.GetAllConsultations();
            ViewBag.doctors = doctorsRepository.GetDoctors();
            return View(consultations);
        }
        public IActionResult Doctor(string email)
        {
            if(email == null || email == ""){
                email = CurrentSession.GetEmail(HttpContext);
            } 
			ViewBag.navLinks = new List<ActionLink>();
			ViewBag.navLinks.Add(new ActionLink("Home", "Index", "Home"));
            List<Consultation> consultations = consultationsRepository.GetConsultationsOfDoctor(email);
			return View(consultations);
        }
        public IActionResult PatientOnly()
        {
            if(CurrentSession.GetIsLoggedIn(HttpContext) && CurrentSession.GetUsertype(HttpContext)=="patient"){
                ViewBag.navLinks = new List<ActionLink>();
                ViewBag.navLinks.Add(new ActionLink("Home", "Index", "Home"));
                List<Consultation> consultations = consultationsRepository.GetConsultationsOfPatient(CurrentSession.GetEmail(HttpContext));
                return View(consultations);
            }else{
                TempData["heading"] = "Error";
                TempData["message"] = "You are not logged in as a patient!";
                return RedirectToAction("Index", "Info");
            }
        }
        public IActionResult CreateNew(){
            if(CurrentSession.GetIsLoggedIn(HttpContext) && CurrentSession.GetUsertype(HttpContext)=="patient"){
                ViewBag.navLinks = new List<ActionLink>();
                ViewBag.navLinks.Add(new ActionLink("Home", "Index", "Home"));
                ViewBag.navLinks.Add(new ActionLink("Consultations", "Index", "Consultations"));

                ViewBag.doctors = doctorsRepository.GetDoctors();
                return View();
            }else{
                TempData["heading"] = "Error";
                TempData["message"] = "You are not logged in as a patient!";
                return RedirectToAction("Index", "Info");
            }
        }
        [HttpPost]
        public IActionResult CreateConsultation(ConsultationDTO consultationDTO){
            if(!ModelState.IsValid){
                TempData["heading"] = "Error";
                TempData["message"] = "Invalid Data Received!";
                return RedirectToAction("Index", "Info");
            }
            if(!(CurrentSession.GetIsLoggedIn(HttpContext) && CurrentSession.GetUsertype(HttpContext)=="patient")){
                TempData["heading"] = "Error";
                TempData["message"] = "You are not logged in as a patient!";
                return RedirectToAction("Index", "Info");
            }
            try{
                // if(date < DateOnly.FromDateTime(DateTime.Now)){
                //     throw new Exception("Date cannot be in the past!");
                // }
                if(consultationDTO.date < DateTime.Now){
                    throw new Exception("Date cannot be in the past!");
                }
                DateTime startDateTime = new DateTime(consultationDTO.date.Year, consultationDTO.date.Month, consultationDTO.date.Day, consultationDTO.start, 0, 0);
                DateTime endDateTime = new DateTime(consultationDTO.date.Year, consultationDTO.date.Month, consultationDTO.date.Day, consultationDTO.end, 0, 0);
                string patientEmail = CurrentSession.GetEmail(HttpContext);
                consultationsRepository.AddConsultation(consultationDTO.doctorEmail, patientEmail, startDateTime, endDateTime);
                TempData["heading"] = "Success";
                TempData["message"] = "Consultation Added!";
            }catch(Exception e){
                TempData["heading"] = "Error";
                TempData["message"] = e.Message;
            }
            return RedirectToAction("Index", "Info");
        }
        public IActionResult CancelAll(string email){
            if(!CurrentSession.GetIsLoggedIn(HttpContext)){
                TempData["heading"] = "Error";
                TempData["message"] = "You are not logged in!";
                return RedirectToAction("Index", "Info");
            }
            if(CurrentSession.GetUsertype(HttpContext)=="patient"){
                TempData["heading"] = "Error";
                TempData["message"] = "A patient cannot cancel all the consultations of a doctor!";
                return RedirectToAction("Index", "Info");
            }
            int count = consultationsRepository.CancelAllConsultations(email, CurrentSession.GetEmail(HttpContext));
            TempData["heading"] = "Success";
            TempData["message"] = count+" consultations cancelled!";
            return RedirectToAction("Index", "Info");
        }
        public IActionResult Cancel(int id){
            if(!CurrentSession.GetIsLoggedIn(HttpContext)){
                TempData["heading"] = "Error";
                TempData["message"] = "You are not logged in!";
                return RedirectToAction("Index", "Info");
            }
            string email = CurrentSession.GetEmail(HttpContext);
            Consultation? consultation = consultationsRepository.GetConsultation(id);
            if(consultation==null){
                TempData["heading"] = "Error";
                TempData["message"] = "Consultation not found!";
                return RedirectToAction("Index", "Info");
            }
            if(email == consultation.PatientEmail || email == consultation.DoctorEmail){
                consultationsRepository.CancelConsultation(id, email);
                TempData["heading"] = "Success";
                TempData["message"] = "Consultation cancelled!";
                return RedirectToAction("Index", "Info");
            }else{
                TempData["heading"] = "Error";
                TempData["message"] = "You are not authorized to cancel this consultation!";
                return RedirectToAction("Index", "Info");
            }
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}