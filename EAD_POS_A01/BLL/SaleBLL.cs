using DAL;
using DTO;

namespace BLL
{
    public class SaleBLL
    {
        SaleDAL saleDAL = new SaleDAL();

        public bool AddSale(Sale sale)
        {
            return saleDAL.AddSale(sale);
        }
        public Sale? GetSale(int orderId)
        {
            return saleDAL.GetSale(orderId);
        }
        public bool UpdateSaleStatus(int orderId, string status)
        {
            return saleDAL.UpdateSaleStatus(orderId, status);
        }
        public bool ItemExistsInASale(int itemId)
        {
            return saleDAL.ItemExistsInASale(itemId);
        }
        public bool AddSaleLineItem(SaleLineItem saleLineItem)
        {
            return saleDAL.AddSaleLineItem(saleLineItem);
        }
        public List<SaleLineItem> GetSaleLineItems(int orderId)
        {
            return saleDAL.GetSaleLineItems(orderId);
        }
        public int GetSalesTotal(int orderId)
        {
            List<SaleLineItem> saleLineItems = saleDAL.GetSaleLineItems(orderId);
            int total = 0;
            foreach (SaleLineItem saleLineItem in saleLineItems)
            {
                total += saleLineItem.Amount;
            }
            return total;
        }
        public bool RemoveSaleLineItem(int orderId, int itemId)
        {
            return saleDAL.RemoveSaleLineItem(orderId, itemId);
        }
        public int GetAvailableSaleId()
        {
            return saleDAL.GetAvailableSaleId();
        }

    }
}