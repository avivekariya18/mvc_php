<?php

class Admin_Controller_Category extends Core_Controller_Admin_Action{

    public function listAction(){

        $layout = $this->getLayout();
        $list = $layout->createBlock('admin/category_list');
        //  ->setTemplate('admin/category/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addCss('catalog/category/list.css');
        $layout->toHtml();
    }

    public function NewAction()
    {
        $layout = $this->getLayout();
        $new = $layout->createBlock('admin/category_new')
        ->setTemplate('admin/category/new.phtml');
        $layout->getChild('content')->addChild('new',$new);
        $layout->getChild('head')->addCss('catalog/category/new.css');
        $layout->toHtml();
    }
    public function saveAction()
    {
        $request = Mage::getModel('core/request');
        $category = Mage::getModel('catalog/category');
        $layout = $this->getLayout();
        $data = $request->getParam('catalog_category');
       
        
        $category->setData($data);
        //  print_r($product);
        $category->save();
       
        $url = $layout->getUrl("*/*/list");

        header("Location: $url");
        exit();
    }

    public function deleteAction()
    {
        $request = Mage::getModel('core/request');
        $deleteId = $request->getQuery('id');
        $layout = $this->getLayout();
        
        $categoryModel = Mage::getModel('catalog/category');
        $data = $categoryModel->load($deleteId);
        $data->delete();
        $url = $layout->getUrl("*/*/list");
        header("Location: $url");
        exit();
    }
    public function exportCsvAction()
    {
        Mage::getModel('Admin/Csv')
            ->exportCsv(Mage::getModel("catalog/category"));
    }
}

?>