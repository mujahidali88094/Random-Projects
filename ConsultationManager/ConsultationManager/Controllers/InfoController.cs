using System.Diagnostics;
using ConsultationManager.Models;
using Microsoft.AspNetCore.Mvc;

namespace ConsultationManager.Controllers
{
    public class InfoController : Controller
    {
        public IActionResult Index() {
            ViewBag.heading = TempData["heading"]?.ToString();
            ViewBag.heading = ViewBag.heading ?? "Info"; 
            ViewBag.message = TempData["message"]?.ToString();
            ViewBag.message = ViewBag.message ?? "";
            return View();
        }
    }
}