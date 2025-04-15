<?php
class Catalog_Block_Product_List_Filter extends Catalog_Block_Product_List
{
    public function __construct(){
        $this->setTemplate('catalog/product/list/filter.phtml');
    }
    public function getFilterUrl($filter,$value){
        
    }
}
?>