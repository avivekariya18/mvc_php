<?php 
class Catalog_Block_Category_List extends Core_Block_Template{
    public function __construct(){
       
      //  $this->setTemplate('catalog/category/list.phtml');
    }

    public function getCategories(){
        $category = Mage::getModel('catalog/category')
        ->getCollection();
        $data = $category->getData();
        //echo "<pre>";
        //print_r($data);
        return $data;
    }
}
?>