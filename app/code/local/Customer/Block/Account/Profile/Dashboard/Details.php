<?php
Class Customer_Block_Account_Profile_Dashboard_Details extends Core_Block_Template{
    public function __construct()
    {
        $this->setTemplate("customer/account/details.phtml");
    }
    public function getDetail(){
        return $this->getParent()
            ->getCustomer();
    }
    
}
?>