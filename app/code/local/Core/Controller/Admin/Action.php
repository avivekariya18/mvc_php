<?php
class Core_Controller_Admin_Action extends Core_Controller_Front_Action
{
    protected $_allowedAction = [];
    protected $_roleAllowedAction = ['dashboard','replay'];

    public function __construct()
    {
        $this->_init();
    }
    public function getLayout()
    {
        return Mage::getBlockSingleton('core/admin_Layout');
    }
    protected function _init()
    {
        $isLogin = $this->getSession()->get('login');
        $id = $this->getSession()->get('id');
        // print($isLogin);
        //print($isLogin);
        //print($this->getSession()->getId());
        // //echo $isLogin;
        //echo $this->getRequest()->getActionName();
        //echo "123";c
        if (!in_array($this->getRequest()->getActionName(), $this->_allowedAction)) {
            if ($isLogin === $id && !empty($isLogin)) {
                $adminId  = Mage::getSingleton('admin/user')
                    ->load($id);

                $roleId = Mage::getSingleton('admin/role')
                    ->load($adminId->getRoleId());
                    
                $json = json_decode($roleId->getPermissions(), true)['menu'];
                foreach ($json as $value) {
                    $this->_roleAllowedAction[] = $value;
                }
                $controller = $this->getRequest()->getControllerName();
                $controllername = explode('_', $controller);
                // echo '<pre>';
                // print_r($this->_roleAllowedAction);
                // print_r($controllername[0]);
                if (!in_array($controllername[0], $this->_roleAllowedAction)) {
                    // echo "123";
                    $this->redirect("admin/account/login");
                    //header('location:http://localhost/mvc_new/admin/dashboard/list');
                }
                // $this->redirect("admin/product_index/list");
            } else {
                //die();
                $this->redirect("admin/account/login");
            }
        }
    }
}
