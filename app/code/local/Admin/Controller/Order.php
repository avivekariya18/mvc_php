<?php
class Admin_Controller_Order extends Core_Controller_Admin_Action
{
    public function listAction()
    {
        $layout =  $this->getLayout();
        $view = $layout->createBlock('admin/order_list');
            // ->setTemplate('admin/order/list.phtml');
        $layout->getChild('content')->addChild('list', $view);
        $layout->toHtml();
    }
    public function viewAction()
    {
        $orderId = Mage::getModel('core/request')->getQuery('order_id');
        $order = Mage::getModel('sale/order')->load($orderId);


        $layout = $this->getLayout();
        $viewOrder = $layout->createBlock("admin/order_view");


        $layout->getChild("content")->addChild("order", $viewOrder);
        $viewOrder->setOrder($order);

        $orderInfo = $layout->createBlock("admin/order_view_info");
        $layout->getChild("content")->getChild("order")->addChild("order_info", $orderInfo);
        // $orderInfo->setOrderInfo($viewOrder);

        $orderAddressinfo = $layout->createBlock("admin/order_view_address");
        $layout->getChild("content")->getChild("order")->addChild("order_address", $orderAddressinfo);
        // $orderAddressinfo->setOrderAddress($viewOrder);

        $orderIteminfo = $layout->createBlock("admin/order_view_item");
        $layout->getChild("content")->getChild("order")->addChild("order_item", $orderIteminfo);
        // $orderIteminfo->setOrderItem($viewOrder);

        $layout->toHtml();
    }
    public function updateStatusAction()
    {
        $request = Mage::getModel('core/request')
            ->getParams();
        $orderModel = Mage::getModel('sale/order')
            ->setOrderId($request['order_id'])
            ->setOrderStatus($request['order_status'])
            ->save();
        header('location:http://localhost/mvc_new/admin/order/list');
    }
    public function exportCsvAction()
    {
        Mage::getModel('Admin/Csv')
            ->exportCsv(Mage::getModel("sale/Order"));
    }
}
