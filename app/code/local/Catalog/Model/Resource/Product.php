<?php

class Catalog_Model_Resource_Product extends Core_Model_Resource_Abstract{
    public function _construct(){
      $this->init("catalog_product","product_id");
  
    }
}
?>