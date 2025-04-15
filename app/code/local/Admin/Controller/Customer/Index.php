<?php
class Admin_Controller_Customer_Index extends Core_Controller_Admin_Action{

    public function newAction(){
        $layout = $this->getLayout();
        $new = $layout->createBlock('Admin/Customer_index_New')
        ->setTemplate('Admin/customer/index/new.phtml');
        $layout->getChild('content')->addChild('new', $new);
        $layout->toHtml();
    }

    public function listAction(){
        $layout = $this->getLayout();
        $list = $layout->createBlock('Admin/customer_index_list')
        ->setTemplate('Admin/customer/index/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }
    public function saveAction(){
        $layout = $this->getLayout();
        $save = $layout->createBlock('Admin/customer_index_save')
        ->setTemplate('Admin/customer/index/save.phtml');
        $layout->getChild('content')->addChild('save', $save);
        $layout->toHtml();
    }
    public function deleteAction(){
        $layout = $this->getLayout();
        $delete = $layout->createBlock('Admin/customer_index_delete')
        ->setTemplate('Admin/customer/index/delete.phtml');
        $layout->getChild('content')->addChild('delete', $delete);
        $layout->toHtml();
    }
}
?>