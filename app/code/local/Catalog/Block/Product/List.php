<?php
class Catalog_Block_Product_List extends Core_Block_Template
{
    public $url;
    
    public function __construct()
    {
        
        $product = $this->getLayout()->createBlock('catalog/product_list_product');
        $filter = $this->getLayout()->createBlock('catalog/product_list_filter');

        $this->addChild('product', $product);
        $this->addChild('filter', $filter);
        $this->setTemplate('catalog/product/list.phtml');
    }
    
    // public $url;
    
    public function getFilterData()
    {
        $request = Mage::getModel('core/request');
        $categoryIds = $request->getQuery('category_id'); // Get category_id from query params

        // print($categoryIds); // Check raw value

        // Split category IDs into an array
        $categoryIds = !empty($categoryIds)
            ? (is_string($categoryIds) ? explode(',', $categoryIds) : (is_array($categoryIds) ? $categoryIds : []))
            : [];
        //print_r($categoryIds); // Debug parsed category IDs
        if ($categoryIds) {
            $product = Mage::getModel('catalog/product')
                ->getCollection()
                ->addFieldToFilter('category_id', ['IN' => $categoryIds])
                ->addAttributeToSelect(['color', 'material', 'size']);
        } else {
            $product = Mage::getModel('catalog/product')
                ->getCollection()
                //->select()
                // ->addFieldToFilter('category_id',$category_id)
                //->leftJoin(["cc"=>"catalog_category"]," cc.category_id = main_table.category_id ",["category_name"=>"name"])
                ->addAttributeToSelect(["color", "material", "size"]);
        }
        //     echo "<pre>";
        //    print_r($product);

        $productData = $product->getData();
        // print_r($productData);
        return $productData;
    }

    public function getCategory()
    {
        $categoryModel = Mage::getModel('catalog/category');
        $data = $categoryModel
            ->getCollection()
            ->select(['category_id', 'name'])
            ->addFieldToFilter('parent_id',['NOT IN'=>[0,1]])
            ->getData();

        return $data;
    }
}
