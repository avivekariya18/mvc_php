<?php

class Customer_Model_Resource_Account extends Core_Model_Resource_Abstract{
    public function _construct(){
      $this->init("customer","customer_id");
    }
}
?>