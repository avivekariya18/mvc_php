<?php 
    class Checkout_Model_Resource_Cart_Address extends Core_Model_Resource_Abstract{
        public function _construct(){
            $this->init("cart_address","address_id");
        }
    }
?>