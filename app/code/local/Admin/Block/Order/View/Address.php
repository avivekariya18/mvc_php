<?php
class Admin_Block_Order_View_Address extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate("admin/order/address.phtml");
    }

    public function getAddress()
    {
        $address = $this->getParent()
            ->getOrder()
            ->getAddressCollection();
        return $address->getData();
    }
}
