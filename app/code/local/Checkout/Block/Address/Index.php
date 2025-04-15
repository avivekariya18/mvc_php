<?php
class Checkout_Block_Address_Index extends Core_Block_Layout{
    public function billinginfo(){
        $cartModel = Mage::getSingleton('checkout/session')
                    ->getCart();
        $addressModel = Mage::getModel('checkout/cart_address')
            ->getCollection()
            ->addFieldToFilter('cart_id',$cartModel->getCartId())
            ->addFieldToFilter('typeofaddress','billing');
        return $addressModel;
    }
    public function shippinginfo(){
        $cartModel = Mage::getSingleton('checkout/session')
                    ->getCart();
        $addressModel = Mage::getModel('checkout/cart_address')
            ->getCollection()
            ->addFieldToFilter('cart_id',$cartModel->getCartId())
            ->addFieldToFilter('typeofaddress','shipping');
            // ->getdata();

        return $addressModel;
    }
    public function getEmail(){
        $cartModel = Mage::getSingleton('checkout/session')
                    ->getCart()
                    ->getEmail();
        return $cartModel;
    }

    }
?>