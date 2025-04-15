<?php
Class Customer_Block_Account_Profile_Dashboard extends Core_Block_Template{
    public function __construct()
    {
        $this->setTemplate("customer/account/dashboard.phtml");
    }
    protected $_customerModel =null;
    public function setCustomer($model){
        $this->_customerModel=$model;
        return $this;
    }
    public function getCustomer(){
        return $this->_customerModel;
    }
}
?>