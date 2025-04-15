<?php
class Catalog_Block_Product_List_Product extends Catalog_Block_Product_List
{
    protected $_collection;
    public function __construct()
    {

        $layout = $this->getLayout();

        $Toolbar = $layout->createBlock('Catalog/Grid_Toolbar')
            ->setTemplate('catalog/grid/toolbar.phtml');
        // die;
        $this->addChild('Toolbar', $Toolbar);
        // $this->init();

        $this->setTemplate('catalog/product/list/product.phtml');
    }
    // public function init()
    // {
    //     $this->_collection = Mage::getModel('catalog/product')
    //         ->getCollection();
    //     // echo "<pre>";
    //     // print_r($this);
    //     $this->getChild('Toolbar')->prepareToolbar();
    // }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getProductData()
    {
        $cat = Mage::getSingleton('catalog/filter')->getProductCollection();
        $this->_collection = $cat;
        $this->getChild('Toolbar')->prepareToolbar();
        $productData = $this->_collection->getData();
        foreach ($productData as $product) {

            $product_id = $product->getProductId();
            //print_r($product_id);
            $imageModel = Mage::getModel('catalog/media_gallery')
                ->getCollection()
                ->AddFieldToFilter("product_id", $product_id)
                ->AddFieldToFilter("default_image", "1")
                ->getData();
            // echo "<pre>";
            // $image = $imageModel->getData()[0];
            if (!empty($imageModel) && isset($imageModel[0])) {
                $product->setMainImage($imageModel[0]->getFilePath());
            } else {
                // echo "No default image found for product ID: " . $product_id;
            }

            // print_r($product);
        }


        //print_r($cat);
        //$request = Mage::getModel('core/request');
        // $category_id = $request->getQuery('category_id');
        // $productModel = Mage::getModel('catalog/product');
        // $productQuery = $productModel->getCollection()
        //     ->select(['name', 'price','product_id'])
        //     ->addFieldToFilter('category_id', $category_id)
        //     ->leftJoin(
        //        ["cmg"=>'catalog_media_gallery'] ,
        //         'main_table.product_id = cmg.product_id',
        //         ['file_path' => 'file_path'])
        //     ->groupBy(['main_table.product_id'])
        //     ;
        //  echo "<pre>";



        // $product = Mage::getModel('catalog/product')
        // ->getCollection()
        // ->select('catlog_product.*')
        // ->leftJoin('catlog_category'," catlog_category.category_id = catlog_product.category_id",["category_name"=>"name"])
        // ;

        // $this->url = Mage::getBaseUrl();
        // $data = $product->getData();
        // echo "<pre>";
        // print_r($data);
        // die();

        //cartid, customer_id,total_amount,oder_id
        //order_item,cart_item, product_id, quantity, grant total 
        // echo "<pre>";
        // print_r($productData);
        // die();
        // $this->init();
        // $this->_collection = $productData;
        // $this->getChild('Toolbar')->prepareToolbar();
        

        return $productData;
    }

}
