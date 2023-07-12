using BLL;
using DTO;

namespace PL
{
    internal class ReceiptUI
    {
        SaleBLL saleBll = new SaleBLL();
        CustomerBLL customerBll = new CustomerBLL();
        ReceiptBLL receiptBll = new ReceiptBLL();

        public void ReceivePayment()
        {
            Console.Write("Sale ID: ");
            int saleId = UI.ReadIntFromConsole();
            Sale? sale = saleBll.GetSale(saleId);
            if(sale == null)
            {
                Console.WriteLine("Sale not found");
                return;
            }
            if (sale.Status == "Paid")
            {
                Console.WriteLine("Already paid");
                return;
            }
            Customer? customer = customerBll.GetCustomer(sale.CustomerId);
            if (customer == null)
            {
                Console.WriteLine("Customer not found");
                return;
            }
            Console.WriteLine("Customer Name: " + customer.Name);
            int salesTotal = saleBll.GetSalesTotal(sale.OrderId);
            Console.WriteLine("Total Sales Amount: " + salesTotal);
            int amountPaid = receiptBll.GetAmountPaid(sale.OrderId);
            Console.WriteLine("Amount Paid: " + amountPaid);
            int remainingAmount = salesTotal - amountPaid;
            Console.WriteLine("Remaining Amount: " + remainingAmount);
            Console.Write("Amount to be Paid: ");
            int amountToBePaid = UI.ReadIntFromConsole();
            if (amountToBePaid == 0)
            {
                Console.WriteLine("Amount to be paid cannot be zero");
                return;
            }

            if (amountToBePaid > remainingAmount)
            {
                Console.WriteLine("Amount to be paid is greater than remaining amount");
                return;
            }

            receiptBll.AddReceipt(new Receipt{
                OrderId = sale.OrderId, 
                Amount = amountToBePaid,
                Date = DateTime.Now.Date
            });
            customerBll.DecreaseAmountPayable(sale.CustomerId,amountToBePaid);
            if (amountToBePaid == remainingAmount)
                saleBll.UpdateSaleStatus(sale.OrderId, "Paid");
            else
                saleBll.UpdateSaleStatus(sale.OrderId, "Partially Paid");

            Console.WriteLine("Receipt Saved");
            
        }
    }
}
