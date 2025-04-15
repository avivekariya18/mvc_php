<?php 
class Catalog_Block_Product_View extends Core_Block_Template{
    // protected function _construct(){
       
    //     $this->setTemplate('catalog/product/view.phtml');
    // }

    public function getOneProduct()
    {
        $request = Mage::getModel('core/request');
        $productId = $request->getQuery('product_id');
        
        $productModel = Mage::getModel('catalog/product');
        // $productQuery = $productModel->getCollection()
        //                              ->select()
        //                              ->addFieldToFilter("product_id", $productId)
        //                              ->LeftJoin('catalog_product_attribute','catalog_product.product_id = catalog_product_attribute.product_id',[])
        //                              ->join('catalog_attribute','catalog_attribute.attribute_id = catalog_product_attribute.attribute_id',[]);
        $collection = Mage::getModel('catalog/product')
        ->load($productId);

         
        //   echo "<pre>";
        //   print_r($collection);   
                               
       return $collection;
    }

    public function getAttribute()
    {
        $attributeModel = Mage::getModel('catalog/attribute');
        $attributeData = $attributeModel->getCollection()
                                        ->getData();
        return $attributeData;
    }
}
?>