<?php

class Catalog_Controller_Category{

    public function listAction(){

        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/category_list')
         ->setTemplate('catalog/category/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addCss('catalog/category/list.css');
        $layout->toHtml();
    }


    public function NewAction()
    {
        $layout = Mage::getBlock('core/layout');
        $new = $layout->createBlock('catalog/category_new')
        ->setTemplate('catalog/category/new.phtml');
        $layout->getChild('content')->addChild('new',$new);
        $layout->getChild('head')->addCss('catalog/category/new.css');
        $layout->toHtml();
    }
    public function saveAction()
    {
        $request = Mage::getModel('core/request');
        $category = Mage::getModel('catalog/category');
        $layout = Mage::getBlock('core/layout');
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
        $deleteId = $request->getQuery('delete_id');
        $layout = Mage::getBlock('core/layout');
        
        $categoryModel = Mage::getModel('catalog/category');
        $data = $categoryModel->load($deleteId);
        $data->delete();
        $url = $layout->getUrl("*/*/list");
        header("Location: $url");
        exit();
    }
}

?>