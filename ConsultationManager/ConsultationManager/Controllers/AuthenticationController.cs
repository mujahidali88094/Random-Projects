using System.Diagnostics;
using ConsultationManager.Models;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;

namespace ConsultationManager.Controllers
{
    public class AuthenticationController : Controller
    {
        IDoctorsRepository doctorsRepository;
        IPatientsRepository patientsRepository;
        IAdminsRepository adminsRepository;
        public AuthenticationController(IDoctorsRepository doctorsRepository, IPatientsRepository patientsRepository, IAdminsRepository adminsRepository)
        {
            this.doctorsRepository = doctorsRepository;
            this.patientsRepository = patientsRepository;
            this.adminsRepository = adminsRepository;
        }
        public IActionResult Index()
        {
            return LoginPage();
        }
        public IActionResult LoginPage()
        {
            if(CurrentSession.GetIsLoggedIn(HttpContext))
                return RedirectToAction("Index", "Home");
            return View();
        }
        public IActionResult SignupPage()
        {
            if(CurrentSession.GetIsLoggedIn(HttpContext))
                return RedirectToAction("Index", "Home");
            return View();
        }
        [HttpPost]
        public IActionResult Signup(SignupDTO signupDTO)
        {
            // var errors = ModelState.Where(x => x.Value.Errors.Any())
            //     .Select(x => new { x.Key, x.Value.Errors });
            // foreach(var error in errors.ToList()){
            //     Console.WriteLine(error.ToString());
            // }
            // Console.WriteLine(ModelState.ToString());
            if(!ModelState.IsValid){
                TempData["heading"] = "Error";
                TempData["message"] = "Invalid Data Received!";
                return RedirectToAction("Index", "Info");
            }

            if (CurrentSession.GetIsLoggedIn(HttpContext))
            {
                TempData["heading"] = "Error";
                TempData["message"] = "You are Already Logged In!";
                return RedirectToAction("Index", "Info");
            }
            if (signupDTO.usertype == "doctor")
            {
                if (doctorsRepository.EmailNotAvailable(signupDTO.email))
                {
                    TempData["heading"] = "Error";
                    TempData["message"] = "Email Already Taken!";
                    return RedirectToAction("Index", "Info");
                }
                string pictureName = Utilities.UploadFile(signupDTO.picture, "Uploads");
                doctorsRepository.AddDoctor(new Doctor { Email = signupDTO.email, Name = signupDTO.name, Password = signupDTO.password, Picture = pictureName, Specialization = signupDTO.specialization });
            }
            else if(signupDTO.usertype == "patient")
            {
                if(patientsRepository.EmailNotAvailable(signupDTO.email))
                {
                    TempData["heading"] = "Error";
                    TempData["message"] = "Email Already Taken!";
                    return RedirectToAction("Index", "Info");
                }
                string pictureName = Utilities.UploadFile(signupDTO.picture, "Uploads");
                patientsRepository.AddPatient(new Patient { Email = signupDTO.email, Name = signupDTO.name, Password = signupDTO.password, Picture = pictureName });
                
            }
            return RedirectToAction("LoginPage");
        }
        [HttpPost]
        public IActionResult SignupAjax(SignupDTO signupDTO)
        {
            // var errors = ModelState.Where(x => x.Value.Errors.Any())
            //     .Select(x => new { x.Key, x.Value.Errors });
            // foreach(var error in errors.ToList()){
            //     Console.WriteLine(error.ToString());
            // }
            // Console.WriteLine(ModelState.ToString());
            // Console.WriteLine(signupDTO);
            if(!ModelState.IsValid){
                return BadRequest("Invalid Data Received!");
            }
            if (CurrentSession.GetIsLoggedIn(HttpContext))
            {
                return BadRequest("You are Already Logged In");
            }
            if (signupDTO.usertype == "doctor")
            {
                if (doctorsRepository.EmailNotAvailable(signupDTO.email))
                {
                    return BadRequest("Email Already Taken!");
                }
                string pictureName = Utilities.UploadFile(signupDTO.picture, "Uploads");
                doctorsRepository.AddDoctor(new Doctor { Email = signupDTO.email, Name = signupDTO.name, Password = signupDTO.password, Picture = pictureName, Specialization = signupDTO.specialization });
            }
            else if(signupDTO.usertype == "patient")
            {
                if(patientsRepository.EmailNotAvailable(signupDTO.email))
                {
                    return BadRequest("Email Already Taken!");
                }
                string pictureName = Utilities.UploadFile(signupDTO.picture, "Uploads");
                patientsRepository.AddPatient(new Patient { Email = signupDTO.email, Name = signupDTO.name, Password = signupDTO.password, Picture = pictureName });
                
            }
            return Ok();
        }
        [HttpPost]
        public IActionResult Login(LoginDTO loginDTO)
        {
            if(!ModelState.IsValid){
                TempData["heading"] = "Error";
                TempData["message"] = "Invalid Data Received!";
                return RedirectToAction("Index", "Info");
            }
            string email = loginDTO.email;
            string password = loginDTO.password;
            string usertype = loginDTO.usertype;

            if (CurrentSession.GetIsLoggedIn(HttpContext))
            {
                TempData["heading"] = "Error";
                TempData["message"] = "You are Already Logged In!";
                return RedirectToAction("Index", "Info");
            }
            if(usertype == "patient")
            {
                Patient? patient = patientsRepository.GetPatient(email, password);
                if(patient == null)
                {
                    TempData["heading"] = "Error";
                    TempData["message"] = "Invalid Credentials!";
                    return RedirectToAction("Index", "Info");
                }
            }else if (usertype == "doctor")
            {
                Doctor? doctor = doctorsRepository.GetDoctor(email, password);
                if (doctor == null)
                {
                    TempData["heading"] = "Error";
                    TempData["message"] = "Invalid Credentials!";
                    return RedirectToAction("Index", "Info");
                }
            }else if (usertype == "admin")
            {
                Admin? admin = adminsRepository.GetAdmin(email, password);
                if (admin == null)
                {
                    TempData["heading"] = "Error";
                    TempData["message"] = "Invalid Credentials!";
                    return RedirectToAction("Index", "Info");
                }
            }
            CurrentSession.SetIsLoggedIn(true, HttpContext);
            CurrentSession.SetEmail(email, HttpContext);
            CurrentSession.SetPassword(password, HttpContext);
            CurrentSession.SetUsertype(usertype,HttpContext);
            return RedirectToAction("Index", "Home");
        }
        public IActionResult Logout()
        {
            CurrentSession.SetIsLoggedIn(false, HttpContext);
            CurrentSession.SetEmail("", HttpContext);
            CurrentSession.SetPassword("", HttpContext);
            CurrentSession.SetUsertype("", HttpContext);

            return RedirectToAction("LoginPage");
        }
        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}