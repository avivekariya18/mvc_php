<?php 
class Sale_Model_Order_Payment extends Core_Model_Abstract{
    public function init(){
        $this->_resourceClassName ="Sale_Model_Resource_Order_Payment";
        $this->_collectionClass = "Sale_Model_Resource_Order_Payment_Collection";
     }
}
?>