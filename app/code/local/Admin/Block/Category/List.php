<?php

class Admin_Block_Category_List extends Admin_Block_Widget_Grid
{
    protected $_collection;
    public function __construct()
    {
        $this->addColumns('category_id', [
            'render' => 'number',
            'filter' => 'Number',
            'data_index' => 'category_id',
            'lable' => 'category id',
        ]);
        $this->addColumns('Name', [
            'render' => 'text',
            'filter' => 'Text',
            'data_index' => 'name',
            'lable' => 'category name',
        ]);
        $this->addColumns('Description', [
            'render' => 'text',
            'filter' => 'Text',
            'data_index' => 'description',
            'lable' => 'category description',
        ]);
        $this->addColumns('parentId', [
            'render' => 'number',
            'filter' => 'Number',
            'data_index' => 'parent_id',
            'lable' => 'parent id ',
        ]);
        $this->addColumns('edit', [
            //'render' => 'http://localhost/mvc_new/admin/category/new/?id=',
            'filter' => 'edit',
            'columns' => 'Link',
            'callback' => 'getediturl',
            'primary_key' => 'category_id',
            'data_index' => 'edit',
            'lable' => 'edit',
        ]);
        $this->addColumns('delete', [
            //'render' => 'http://localhost/mvc_new/admin/category/delete/?id=',
            'filter' => 'delete',
            'columns' => 'Link',
            'callback' => 'getdeleteurl',
            'primary_key' => 'category_id',
            'data_index' => 'delete',
            'lable' => 'delete',
        ]);

        $this->setCollection( Mage::getModel('catalog/category')
        ->getCollection());
        parent :: __construct();

        $this->init();
    }
    public function init()
    {
        $layout = $this->getLayout();
        $toolbar_block = $layout->createBlock("Admin/grid_toolbar")
            ->setTemplate("admin/grid/toolbar.phtml");

        $product = Mage::getModel("catalog/category");
        $this->addChild("toolbar", $toolbar_block);

        $this->_collection = $product->getCollection();

        $toolbar_block->prepareToolbar();
    }
    public function getediturl($data){
        return $this->getUrl('*/*/new').'/?id='.$data['category_id'];
    }
    public function getdeleteurl($data){
        return $this->getUrl('*/*/delete').'/?id='.$data['category_id'];
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
}

// class Admin_Block_Category_List extends Core_Block_Template
// {
//   public $url;
//   protected $_collection;
//   public function __construct()
//   {
//     $layout = $this->getLayout();

//     $Toolbar = $layout->createBlock('Admin/Grid_Toolbar')
//       ->setTemplate('Admin/grid/toolbar.phtml');
//     // die;
//     $this->addChild('Toolbar', $Toolbar);
//     $this->init();
//     //  $this->setTemplate('catalog/category/list.phtml');
//   }

//   public function getCategories()
//   {
//     // $category = Mage::getModel('catalog/category')
//     //   ->getCollection();

//     $this->url = Mage::getBaseUrl();
//     // $data = $category->getData();
//     //echo "<pre>";
//     //print_r($data);
//     return $this->getCollection()->getData();
//   }
//   public function init()
//   {
//     $this->_collection = Mage::getModel('catalog/category')
//       ->getCollection();
//     // echo "<pre>";
//     // print_r($this);
//     $this->getChild('Toolbar')->prepareToolbar();
//   }
//   public function getCollection()
//   {
//     return $this->_collection;
//   }
// }
