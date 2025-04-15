<?php
class Admin_Block_Category_New extends Core_Block_Template
{
    public $cat_data = [];
    public $url;
    public function __construct()
    {
        //$this->setTemplate('Admin/product/index/new.phtml');

    }

    public function getCategoryData()
    {
        $categoryId = Mage::getModel('core/request')
            ->getQuery('id');
        $this->url = Mage::getBaseUrl();
        $catdata = Mage::getModel('catalog/category')
            ->getCollection()
            ->getData();
        $this->cat_data = $catdata;

        // print_r($categoryId);

        if ($categoryId != null) {
            $category = Mage::getModel('catalog/category')
                ->getCollection()
                ->select()
                ->addFieldToFilter('category_id', $categoryId);
            $data = $category->getData();
            // print_r($data);
            // die();
            return $data;
        } else {
            $category = Mage::getModel('catalog/category');
            // print_r($category);
            return $category;
        }
    }
}
