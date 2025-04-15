<?php 
class Sale_Model_Resource_Order_Item extends Core_Model_Resource_Abstract{
    public function _construct(){
        $this->init("order_item","item_id");
    
      }
}
?>