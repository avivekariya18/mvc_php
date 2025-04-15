<?php 
    class Sale_Model_Resource_Order_Address extends Core_Model_Resource_Abstract{
        public function _construct(){
            $this->init("order_address","address_id");
        }
    }
?>