<?php
class Catalog_Model_Media_Gallery extends Core_Model_Abstract
{
    public function init(){
        $this->_resourceClassName ="Catalog_Model_Resource_Media_Gallery";
        $this->_collectionClass = "Catalog_Model_Resource_Media_Gallery_Collection";
     }
}
?>