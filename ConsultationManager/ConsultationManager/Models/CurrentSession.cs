using System.ComponentModel;

namespace ConsultationManager.Models
{
    public class CurrentSession
    {
        public static bool GetIsLoggedIn(HttpContext httpContext)
        { return httpContext.Session.GetString("loggedIn") == "YES"; }
        public static void SetIsLoggedIn(bool value, HttpContext httpContext)
        { httpContext.Session.SetString("loggedIn", value ? "YES" : "NO"); }
        public static string GetUsertype(HttpContext httpContext)        
        { return httpContext.Session.GetString("usertype") ?? ""; }
        public static void SetUsertype(string value, HttpContext httpContext)
        { httpContext.Session.SetString("usertype", value); }
        public static string GetEmail(HttpContext httpContext)
        { return httpContext.Session.GetString("email") ?? ""; }
        public static void SetEmail(string value, HttpContext httpContext)
        { httpContext.Session.SetString("email", value); }
        public static string GetPassword(HttpContext httpContext)
        { return httpContext.Session.GetString("password") ?? ""; }
        public static void SetPassword(string value, HttpContext httpContext)
        { httpContext.Session.SetString("password", value); }
    }
}