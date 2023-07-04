using System.ComponentModel.DataAnnotations;

namespace ConsultationManager.Models
{
    public class ActionLink
    {
        public string Action { get; set; } = "Index";
        public string? Controller { get; set; }
        public string Text { get; set; } = "Link";
        public ActionLink() { }
        public ActionLink(string text, string action, string controller)
        {
            Action = action;
            Controller = controller;
            Text = text;
        }
    }
}