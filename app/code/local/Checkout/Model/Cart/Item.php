<?php 
class Checkout_Model_Cart_Item extends Core_Model_Abstract{
    public function init()
    {
       $this->_resourceClassName = "Checkout_Model_Resource_Cart_Item";
       $this->_collectionClass = "Checkout_Model_Resource_Cart_Item_Collection";
    }

    protected function _beforeSave()
    {
       $product = $this->getProduct();
       $product_price = (float) $product->getPrice();
      // print_r($product_price);
       $quantity =(int) $this->getProductQuantity();
     //  print_r($quantity);
       $sub_total =($product_price * $quantity);
     //  print_r($sub_total);
       $this->setPrice($product_price)
            ->setSubTotal($sub_total);
           

       // print_r($this);
    }

    public function getProduct(){
        //  $_product = Mage::getModel('catalog/product')->load($this->getProductId());
         return Mage::getModel('catalog/product')->load($this->getProductId());
    }
}
?>