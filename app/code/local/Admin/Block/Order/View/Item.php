<?php
class Admin_Block_Order_View_Item extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("admin/order/item.phtml");
    }

    public function getItems()
    {

        return $this->getParent()
            ->getOrder()
            ->getItemCollection()
            ->getData();
    }
}
