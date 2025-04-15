<?php
class Core_Controller_Customer_Action extends Core_Controller_Front_Action
{
    protected $_allowedAction = [];
    
    public function __construct()
    {
        $this->_init();
    }
    public function getLayout(){
        return Mage::getBlockSingleton('core/Layout');
    }
    protected function _init()
    {
        $isLogin = $this->getSession()->get('customer_id');
        // $id = $this->getSession()->get('id');
       // print($isLogin);
         //print($isLogin);
         //print($this->getSession()->getId());
        // //echo $isLogin;
        //echo $this->getRequest()->getActionName();
        //echo "123";c
        if (!in_array($this->getRequest()->getActionName(), $this->_allowedAction)) {
            if (!empty($isLogin)) {
                // $this->redirect("admin/product_index/list");
            } else {
                //die();
                $this->redirect("customer/account/login");
            }
        }
    }
}
