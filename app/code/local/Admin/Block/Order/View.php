<?php
class Admin_Block_Order_View extends Core_Block_Template
{
    protected $_orderModel = null;
    public function __construct()
    {
        $this->setTemplate("admin/order/view.phtml");
    }
    public function setOrder($model)
    {
        $this->_orderModel = $model;
        return $this;
    }
    public function getOrder()
    {
        return $this->_orderModel;
    }
    // public function getOrderitems(){

    //     $request = Mage::getModel('core/request');
    //     $orderId= $request->getQuery('order_id');
    //     $OrderItem = Mage::getModel('sale/order_item')
    //         ->getCollection()
    //         ->addFieldToFilter('order_id',['='=>$orderId])
    //         ->getData();
    //     return $OrderItem;
    // }
    // public function getOrderdetail(){
    //     $request = Mage::getModel('core/request');
    //     $orderId= $request->getQuery('order_id');
    //     $OrderItem = Mage::getModel('sale/order')
    //         ->getCollection()
    //         ->addFieldToFilter('order_id',['='=>$orderId])
    //         ->getData();
    //     return $OrderItem;

    // }

}
