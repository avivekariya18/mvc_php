<?php
class Admin_Block_Product_Index_List extends Admin_Block_Widget_Grid
{
    protected $_collection;
    public function __construct()
    {
        $this->addColumns('product_id', [
            'render' => 'number',
            'filter' => 'Number',
            'data_index' => 'product_id',
            'lable' => 'product id',
        ]);
        $this->addColumns('Name', [
            'render' => 'text',
            'filter' => 'Text',
            'data_index' => 'name',
            'lable' => 'name',
        ]);
        // $this->addColumns('Description', [
        //     'render' => 'text',
        //     'filter' => 'Text',
        //     'data_index' => 'description',
        //     'lable' => 'description',
        // ]);
        $this->addColumns('sku', [
            'render' => 'text',
            'filter' => 'Text',
            'data_index' => 'sku',
            'lable' => 'sku',
        ]);
        $this->addColumns('price', [
            'render' => 'number',
            'filter' => 'Number',
            'data_index' => 'price',
            'lable' => 'price',
        ]);
        $this->addColumns('stock_quantity', [
            'render' => 'number',
            'filter' => 'Number',
            'data_index' => 'stock_quantity',
            'lable' => 'stock quantity',
        ]);
        $this->addColumns('category_name', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'category_name',
            'lable' => 'category name',
        ]);
        $this->addColumns('edit', [
            //'render' => 'http://localhost/mvc_new/admin/product_Index/new/?id=',
            'filter' => 'edit',
            'columns' => 'Link',
            'callback' => 'getediturl',
            'primary_key' => 'product_id',
            'data_index' => 'edit',
            'lable' => 'edit',
        ]);
        $this->addColumns('delete', [
            //'render' => 'http://localhost/mvc_new/admin/product_Index/delete/?id=',
            'filter' => 'delete',
            'columns' => 'Link',
            'callback' => 'getdeleteurl',
            'primary_key' => 'product_id',
            'data_index' => 'delete',
            'lable' => 'delete',
        ]);

        $this->setCollection( Mage::getModel('catalog/product')
        ->getCollection());
        parent :: __construct();

        $this->init();
    }
    public function init()
    {
        $layout = $this->getLayout();
        $toolbar_block = $layout->createBlock("Admin/grid_toolbar")
            ->setTemplate("admin/grid/toolbar.phtml");

        $product = Mage::getModel("catalog/product");
        $this->addChild("toolbar", $toolbar_block);

        $this->_collection = $product->getCollection()
            ->leftJoin(["cc" => "catalog_category"], " cc.category_id = main_table.category_id ", ["category_name" => "name"])
            ->addAttributeToSelect(["color", "material", "size"]);

        $toolbar_block->prepareToolbar();
    }
    public function getediturl($data){
        return $this->getUrl('*/*/new').'/?edit_id='.$data['product_id'];
    }
    public function getdeleteurl($data){
        return $this->getUrl('*/*/delete').'/?delete_id='.$data['product_id'];
    }

    public function listdata()
    {
        return $this->getCollection()
            ->getData();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    // public $url;
    // protected $_collection;
    // public function __construct()
    // {
    //     $layout = $this->getLayout();

    //     $Toolbar = $layout->createBlock('Admin/Grid_Toolbar')
    //         ->setTemplate('Admin/grid/toolbar.phtml');
    //     // die;
    //     $this->addChild('Toolbar', $Toolbar);
    //     $this->init();
    //     // $this->setTemplate('admin/product/index/list.phtml');
    // }
    // public function getProducts()
    // {
    //     $product = Mage::getModel('catalog/product')
    //         ->getCollection()
    //         // ->select()
    //         ->leftJoin(["cc" => "catalog_category"], " cc.category_id = main_table.category_id ", ["category_name" => "name"])
    //         ->addAttributeToSelect(["color", "material", "size"]);
    //     $this->url = Mage::getBaseUrl();
    //     $data = $product->getData();
    //     // echo "<pre>";
    //     echo "<pre>";
    //     print_r($data);
    //     // die();
    //     return $data;
    // }
    // public function init()
    // {
    //     $this->_collection = Mage::getModel('catalog/product')
    //         ->getCollection();
    //     // echo "<pre>";
    //     // print_r($this);
    //     $this->getChild('Toolbar')->prepareToolbar();
    // }
    // public function getCollection()
    // {
    //     return $this->_collection;
    // }
    // public function listdata()
    // {
    //     return $this->getCollection()
    //         ->leftJoin(["cc" => "catalog_category"], " cc.category_id = main_table.category_id ", ["category_name" => "name"])
    //         ->addAttributeToSelect(["color", "material", "size"])
    //         ->getData();
    // }
    // // public function __construct()
    // // {

    // // }
    
}
