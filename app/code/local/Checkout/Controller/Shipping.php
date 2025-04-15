<?php

class Checkout_Controller_Shipping
{
    public function indexAction()
    {
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('checkout/shipping_index')
            ->setTemplate('checkout/shipping/index.phtml');
        $layout->getChild('content')->addChild('shipping', $view);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $request = Mage::getModel('core/request');
        $shippingType = $request->getParam('shipping_type');
        $paymentMethod = $request->getParam('payment_method');
        

        $shippingModel = Mage::getModel('checkout/shipping');
        if (array_key_exists($shippingType, $shippingModel->getAllShipping())) {
            $shippingAmount = $shippingModel->CalculateShippingAmount($shippingType);
            $cartModel = Mage::getSingleton('checkout/session')
                ->getCart();
            $totalAmount = $cartModel->getTotalAmount();
            print($totalAmount);
            print("<br>");
            print($shippingAmount);
            var_dump((int)$totalAmount + (int)$shippingAmount);

            $cartModel->setPaymentMethod($paymentMethod)
            ->setShippingMethod($shippingType)
            ->setShippingAmount($shippingAmount)
            ->save();
        }
        if($paymentMethod == 'Paypal'){
            header('location:http://localhost/mvc_new/sale/payment/payment');
            die;
        }
        header("Location: http://localhost/mvc_new/checkout/order/placeorder");
    }
}
