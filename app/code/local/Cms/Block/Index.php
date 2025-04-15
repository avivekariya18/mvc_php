<?php
class Cms_Block_Index extends Core_Block_Template{
  
    public function getProductList()
    {
       $productModel = Mage::getModel('catalog/product');
       $productData = $productModel->getCollection()
                                   ->select(['name','price','product_id'])
                                   ->leftJoin(["cmg"=>'catalog_media_gallery'],' main_table.product_id = cmg.product_id ',["file_path"=>"file_path"])
                                   ->addFieldToFilter('cmg.default_image',1)
                                   ->limit(10);
       $data = $productData->getData();

       return $data;
    }
}
?>