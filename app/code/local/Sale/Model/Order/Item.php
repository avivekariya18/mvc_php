<?php 
class Sale_Model_Order_Item extends Core_Model_Abstract{
    public function init()
    {
       $this->_resourceClassName = "Sale_Model_Resource_Order_Item";
       $this->_collectionClass = "Sale_Model_Resource_Order_Item_Collection";
    }
    public function getProduct(){
        $product = Mage::getModel('catalog/product')
            ->load($this->getProductId());
        return $product;
    }
}