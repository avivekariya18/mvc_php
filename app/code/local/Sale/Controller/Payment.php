<?php
class Sale_Controller_Payment
{
    public function paymentAction()
    {
        $cartModel = Mage::getSingleton('checkout/session')->getCart();
        // echo "<pre>";
        // print_r();
        // die;
        $paypal = new Paypal_Init();
        $paypal->payment($cartModel->getCartId(), $cartModel->getTotalAmount());
    }
    public function successAction()
    {
        $paypal = new Paypal_Init();
        $paypal->success();
    }
    public function cancleAction()
    {
        $paypal = new Paypal_Init();
        $paypal->cancel();
    }
    public function refundAction()
    {
        $orderId = Mage::getModel('core/request')
            ->getQuery('order_id');
            
        $paymentModel = Mage::getModel('sale/order_payment')
            ->load($orderId, 'order_id');
        // echo "<pre>";
        // print_r($paymentModel);
        if ($paymentModel->getPaymentMethod() == 'Paypal') {
            $paypal = new Paypal_Init();
            $status = $paypal->refund($paymentModel->getTransactionId(), $paymentModel->getAmount());
            if ($status) {
                $paymentModel->setStatus('refund')
                    ->save();
                Mage::getSingleton('core/message')->addMessage('success', 'refund successfully!');
            } else {
                Mage::getSingleton('core/message')->addMessage('error', 'refund unsuccessfully!');
            }
        } else {
            if ($paymentModel->setStatus('refund')
                ->save()
            ) {
                Mage::getSingleton('core/message')->addMessage('success', 'refund successfully!');
            } else {
                Mage::getSingleton('core/message')->addMessage('error', 'refund unsuccessfully!');
            }
        }
        header('location:http://localhost/mvc_new/checkout/order/yourOrder');
    }
}
