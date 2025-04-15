<?php
class Customer_Block_Account_YourOrder extends Core_Block_Template
{
    public function getOrder()
    {
        $cartModel = Mage::getSingleton('checkout/session')
            ->get('customer_id');

        $accountModel = Mage::getSingleton('customer/account')
            ->load($cartModel)
            ->getEmail();

        $orderModel = Mage::getSingleton('sale/order')
            // ->getResource()
            // ->load($accountModel,'email');
            ->getCollection()
            ->addFieldToFilter('email', ['=' => $accountModel])
            ->getData();
        // ->getCustomerId();
        // echo "<pre>";
        // print_r($accountModel);
        // print_r($orderModel);
        return $orderModel;
    }
    public function getProduct($orderId)
    {
        return Mage::getSingleton('sale/order_item')
            ->getCollection()
            ->addFieldToFilter('order_id', ['=' => $orderId])
            ->getData();
    }
    public function getproductdetails($productId)
    {
        return Mage::getModel('catalog/product')
            ->load($productId);
    }
    public function getorderpaymentstatus($orderId) {
        return Mage::getModel('sale/order_payment')
            ->load($orderId, 'order_id')
            ->getStatus();
    }
}
