<?php
class Checkout_Model_Convert_Order
{
    public function convert($model)
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'] ??
            $_SERVER['HTTP_X_FORWARDED_FOR'] ??
            $_SERVER['HTTP_X_FORWARDED'] ??
            $_SERVER['HTTP_FORWARDED_FOR'] ??
            $_SERVER['HTTP_FORWARDED'] ??
            $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

        // Convert localhost IPv6 (::1) to IPv4 (127.0.0.1)
        if ($ip === '::1') {
            $ip = '127.0.0.1';
        }

        // Validate IP
        $ip = filter_var(trim(explode(",", $ip)[0]), FILTER_VALIDATE_IP) ?: "Invalid IP";


        $data = $model->getData();
        echo "<pre>";
        unset($data['cart_id']);
        // print_r($data);
        // print_r($ip);
        // die;
        $orderModel = Mage::getModel('sale/order')
            ->setData($data)
            ->setOrderIp($ip)
            ->setOrderNumber($model->getCartId())
            ->save();

        $ItemData = $model->getItemCollection()
            ->getData();
        // print_r($ItemData);
        foreach($ItemData as $singelObj){
            $singledata = $singelObj->getData();
            unset($singledata['item_id']);
            unset($singledata['cart_id']);
            
            $itemdata = Mage::getModel('sale/order_item')
                ->setData($singledata)
                ->setOrderId($orderModel->getOrderId())
                ->save();
        }

        $billingData = $model->getBillingAddress()
            ->getData();
        // print_r($ItemData);
        foreach($ItemData as $singelObj){
            $singledata = $singelObj->getData();
            unset($singledata['item_id']);
            unset($singledata['cart_id']);
            
            $itemdata = Mage::getModel('sale/order_item')
                ->setData($singledata)
                ->setOrderId($orderModel->getOrderId())
                ->save();
        
                $billingData = $model->getBillingAddress()->getfirstItem()->getData(); 
                unset($billingData['created_at']);
                unset($billingData['updated_at']);
                unset($billingData['address_id']);
                unset($billingData['cart_id']);
                Mage::getModel('sale/order_address')
                    ->setData($billingData)
                    ->setOrderId($orderModel->getOrderId())
                    ->setTypeofaddress('billing')
                    ->save();
                $shippingData = $model->getShippingAddress()->getfirstItem()->getData();
                unset($shippingData['created_at']);
                unset($shippingData['updated_at']);
                unset($shippingData['address_id']);
                unset($shippingData['cart_id']);
                Mage::getModel('sale/order_address')
                    ->setData($shippingData)    
                    ->setOrderId($orderModel->getOrderId())
                    ->setTypeofaddress('shipping')
                    ->save();
        
                return $orderModel;
        }
    }
}
