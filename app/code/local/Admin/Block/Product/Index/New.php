<?php 
class Admin_Block_Product_Index_New extends Core_Block_Template{
    public $cat_data=[];
    public $url;
    public function __construct(){
        $this->setTemplate('Admin/product/index/new.phtml');
        
       
    }
    
    public function getProductData(){

        $product_id = Mage::getModel('core/request')->getQuery('edit_id');
        $this->url = Mage::getBaseUrl();
        $catdata = Mage::getModel('catalog/category')->getCollection()
                  ->getData();
        $this->cat_data = $catdata;
        if($product_id != null){
            $product = Mage::getModel('catalog/product')
            ->load($product_id);
        
            // die();
            return $product;
        }else{
            $product = Mage::getModel('catalog/product');
            return $product;
        }
    }

    public function getHtmlField($field,$data){
     
        $field = ucfirst(strtolower($field));
        $className = sprintf("Admin_Block_Html_Elements_%s",$field);
        $element = new $className($data);
      
        return $element->render();
    }

    public function getAttribute()
    {
        $attribute = Mage::getModel('catalog/attribute');
        $data= $attribute->getCollection()->getData();
        // echo "<pre>";
        // print_r($data);
        return $data;
    }
}
?>