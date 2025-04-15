<?php

class Checkout_Controller_Order
{
    public function placeorderAction()
    {

        $cartModel = Mage::getSingleton('checkout/session')
            ->getCart();
        $orderModel = Mage::getModel('checkout/Convert_Order')
            ->convert($cartModel);

        $cartModel->setIsActive(0)->save();
        Mage::getModel("core/session")
            ->remove("cart_id");
        $layout = Mage::getBlock('core/layout');
        echo "<pre>";
        print_r($orderModel);

        // print_r($_GET);
        // if($_GET){
        $transectionId = Mage::getModel('core/request')
            ->getQuery('T_id');

        $paymentModel = Mage::getModel('Sale/order_Payment')
            ->setOrderId($orderModel->getOrderId())
            ->setAmount($orderModel->getTotalAmount())
            ->setPaymentMethod($orderModel->getPaymentMethod())
            ->setTransactionId($transectionId)
            ->setStatus('completed')
            ->save();
        // }
        $url = $layout->getUrl("Catalog/product/list");
        header("location:$url");
    }

    public function yourOrderAction()
    {
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('customer/Account_YourOrder')
                ->setTemplate('customer/account/yourorder.phtml');
        $layout->getChild('content')->addChild('yourorder', $view);
        $layout->toHtml();
    }
}
