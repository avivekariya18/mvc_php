<?php 
class Checkout_Block_Cart_Index extends Core_Block_Template{
    public function getItem()
    {
        $cart_model = Mage::getSingleton("checkout/session")->getCart();
        // $cart_item_data = $cart_model->getItemCollection()->getData();
        return $cart_model->getItemCollection()->getData();
    }

    public function getTotalAmount()
    {
        // $cart_model = Mage::getSingleton("checkout/session")->getCart();
        return Mage::getSingleton("checkout/session")->getCart();
    }


}
?>