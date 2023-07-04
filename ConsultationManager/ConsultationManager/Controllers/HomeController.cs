using System.Diagnostics;
using ConsultationManager.Models;
using Microsoft.AspNetCore.Mvc;

namespace ConsultationManager.Controllers
{
  public class HomeController : Controller
  {
    public IActionResult Index()
    {
      // ViewBag.email = CurrentSession.GetEmail(HttpContext);
      ViewBag.navLinks = new List<ActionLink>
      {
        new ActionLink("Doctors", "Index", "Doctors"),
                new ActionLink("Patients", "Index", "Patients"),
                new ActionLink("Consultations", "Index", "Consultations")
            };
        if(CurrentSession.GetIsLoggedIn(HttpContext))
        {
            if(CurrentSession.GetUsertype(HttpContext) == "admin")
            {
                ViewBag.navLinks.Add(new ActionLink("Admin Interface", "Index", "Admin"));
            }
        }
      return View();
    }

    [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
    public IActionResult Error()
    {
      return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
    }
  }
}