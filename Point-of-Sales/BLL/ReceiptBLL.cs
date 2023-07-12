using DAL;
using DTO;

namespace BLL
{
    public class ReceiptBLL
    {
        ReceiptDAL receiptDAL = new ReceiptDAL();
        public bool AddReceipt(Receipt receipt)
        {
            return receiptDAL.AddReceipt(receipt);
        }
        public List<Receipt> GetReceipts(int orderId)
        {
            return receiptDAL.GetReceipts(orderId);
        }
        public int GetAmountPaid(int orderId)
        {
            List<Receipt> receipts = receiptDAL.GetReceipts(orderId);
            int amountPaid = 0;
            foreach (Receipt receipt in receipts)
            {
                amountPaid += receipt.Amount;
            }
            return amountPaid;
        }
        
    }
}