<?php
Class Customer_Block_Account_Profile_Dashboard_Address extends Core_Block_Template{
    public function __construct()
    {
        $this->setTemplate("customer/account/address.phtml");
    }
    public function getAddress(){
        return $this->getParent()
            ->getCustomer()
            ->getAddressCollection(); 
    }
    public function getsingleaddress($a){
        // print($a);
        //var_dump($a);
        return Mage::getModel('customer/account_address')
            ->load($a);
    }
    public function getRequest(){
        return Mage::getModel('core/request');
    }

}
?>