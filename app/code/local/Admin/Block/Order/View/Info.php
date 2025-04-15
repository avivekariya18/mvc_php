<?php
class Admin_Block_Order_View_Info extends Core_Block_Template
{
    protected $_orderInfo;

    public function __construct()
    {
        $this->setTemplate("admin/order/info.phtml");
    }

    public function orderInfo()
    {
        return $this->getParent()
            ->getOrder();
    }
}
