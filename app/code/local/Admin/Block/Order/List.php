<?php
class Admin_Block_Order_List extends Admin_Block_Widget_Grid
{
    protected $_collection;
    public function __construct()
    {
        $this->addColumns('order_id', [
            'render' => 'number',
            'filter' => 'Number',
            'data_index' => 'order_id',
            'lable' => 'order id',
        ]);
        $this->addColumns('customer_id', [
            'render' => 'number',
            'filter' => 'Number',
            'data_index' => 'customer_id',
            'lable' => 'customer id',
        ]);
        $this->addColumns('order_status', [
            'render' => 'Dropdown',
            'filter' => 'Dropdown',
            'filter_option' => ['pending','shipped','delivered','cancelled'],
            'columns' => 'Dropdown',
            'data_index' => 'order_status',
            'lable' => 'order status',
            
        ]);
        $this->addColumns('email', [
            'render' => 'text',
            'filter' => 'Text',
            'data_index' => 'email',
            'lable' => 'email',
        ]);
        $this->addColumns('total_amount', [
            'render' => 'number',
            'filter' => 'Number',
            'data_index' => 'total_amount',
            'lable' => 'total amount',
        ]);
        $this->addColumns('view', [
            //'render' => 'http://localhost/mvc_new/admin/order/view/?order_id=',
            'filter' => 'view',
            'columns' => 'Link',
            'callback' => 'getviewurl',
            'primary_key' => 'order_id',
            'data_index' => 'view',
            'lable' => 'view',
        ]);
        // $this->addColumns('delete', [
        //     'render' => 'http://localhost/mvc_new/admin/order/delete/?id=',
        //     'filter' => 'delete',
        //     'columns' => 'Link',
        //     'primary_key' => 'category_id',
        //     'data_index' => 'delete',
        //     'lable' => 'delete',
        // ]);

        $this->setCollection( Mage::getModel('sale/order')
        ->getCollection());
        parent :: __construct();

        $this->init();
    }
    public function init()
    {
        $layout = $this->getLayout();
        $toolbar_block = $layout->createBlock("Admin/grid_toolbar")
            ->setTemplate("admin/grid/toolbar.phtml");

        $product = Mage::getModel("sale/order");
        $this->addChild("toolbar", $toolbar_block);

        $this->_collection = $product->getCollection();

        $toolbar_block->prepareToolbar();
    }
    public function getviewurl($data){
        return $this->getUrl('*/*/view').'/?order_id='.$data['order_id'];
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
    // }
    // public function getOrderData()
    // {
    //     // $orderData = Mage::getModel("sale/order")
    //     //     ->getCollection()
    //     //     ->getData();
    //     return $this->getCollection()->getData();
    // }
    // public function init()
    // {
    //     $this->_collection = Mage::getModel('sale/order')
    //         ->getCollection();
    //     // echo "<pre>";
    //     // print_r($this);
    //     $this->getChild('Toolbar')->prepareToolbar();
    // }
    // public function getCollection()
    // {
    //     return $this->_collection;
    // }
}
