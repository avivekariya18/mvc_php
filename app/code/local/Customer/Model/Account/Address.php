<?php
class Customer_Model_Account_Address extends Core_Model_Abstract{
    
    public function init(){
       $this->_resourceClassName ="Customer_Model_Resource_Account_Address";
       $this->_collectionClass = "Customer_Model_Resource_Account_Address_Collection";
    }
}
?>