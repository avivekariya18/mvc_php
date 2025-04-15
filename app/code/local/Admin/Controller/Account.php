<?php
class Admin_Controller_Account extends Core_Controller_Admin_Action 
{
    protected $_allowedAction = [
        'login','loginPost'
    ];
    public function loginAction()
    {
        $layout = $this->getLayout();
        $login = $layout->createBlock('admin/account_login')
                        ->setTemplate('admin/account/login.phtml');
        $layout->getChild('content')->addChild('login',$login);
        $layout->toHtml();
        // $session = Mage::getModel('core/session');
        //  $id = $session->getId();
        //  $session->remove('login');
        // var_dump($id);
        // echo "<pre>";
        // print_r($_SESSION);
        // echo "</pre>";
    }

    public function loginPostAction()
    {
        $session = Mage::getSingleton('core/session');
        $params = $this->getRequest()->getParam('admin_user');
        $adminUser = Mage::getModel('admin/user');
        $adminData = $adminUser->load($params['username'],"username");
        // echo "<pre>";
        // print_r($adminData);
       // die();

        // $params = ['username'=>'admin','password'=>'admin'];
        if($params['username']== $adminData->getUsername() && $params['password_hash']==$adminData->getPasswordHash())
        {
           $session->set('login',$adminData->getAdminId());
           $session->set('id',$adminData->getAdminId());
           $this->redirect("admin/dashboard/list");
        }
        else{
            $session->remove("login");
            $session->remove('id');
            $this->redirect('admin/account/login');
        }
      //  print_r($params);
    }

    public function logoutAction(){
        $sessionModel = Mage::getSingleton('core/session');
        $sessionModel->remove("login");
        $sessionModel->remove("id");
    }
}

?>