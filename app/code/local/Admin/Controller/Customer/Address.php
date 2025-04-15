<?php
class Admin_Controller_Customer_Address extends Core_Controller_Admin_Action{
 
    public function newAction(){
        $layout = $this->getLayout();
        $new = $layout->createBlock('Admin/Customer_Address_New')
        ->setTemplate('Admin/customer/address/new.phtml');
        $layout->getChild('content')->addChild('new', $new);
        $layout->toHtml();
    }

    public function listAction(){
        $layout = $this->getLayout();
        $list = $layout->createBlock('Admin/customer_address_list')
        ->setTemplate('Admin/customer/address/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }
    public function saveAction(){
        $layout = $this->getLayout();
        $save = $layout->createBlock('Admin/customer_address_save')
        ->setTemplate('Admin/customer/address/save.phtml');
        $layout->getChild('content')->addChild('save', $save);
        $layout->toHtml();
    }
    public function deleteAction(){
        $layout = $this->getLayout();
        $delete = $layout->createBlock('Admin/customer_address_delete')
        ->setTemplate('Admin/customer/address/delete.phtml');
        $layout->getChild('content')->addChild('delete', $delete);
        $layout->toHtml();
    }
}
?>