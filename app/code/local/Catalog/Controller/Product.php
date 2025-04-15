<?php

class Catalog_Controller_Product
{

    public function listAction()
    {
        $request = Mage::getModel('core/request');

        $layout = Mage::getBlockSingleton('core/layout');
        //$layout->removeChild('header');
        $list = $layout->createBlock('catalog/product_list');
        if($request->isAjax())
        {
            $layout->removeChild('header');
            $layout->removeChild('footer');
            $list->removeChild('filter');
        }
            
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addCss('catalog/list.css');
        $layout->getChild('head')->addJs('catalog/list.js');
        $layout->toHtml();
    }
    
    public function viewAction()
    {
        $product = Mage::getModel('catalog/product');
        //echo "<pre>";
        //print_r($product);
        $model = $product->getResource();
        //print_r($model);
        $layout = Mage::getBlock('core/layout');
        $view = $layout->createBlock('catalog/product_view')
            ->setTemplate('catalog/product/view.phtml');
        $layout->getChild('content')->addChild('view', $view);
        $layout->toHtml();
    }

    public function testAction()
    {
        //  echo "<pre>";
        //  $collection = Mage::getModel('catalog/filter')->getProductCollection();
        //  $query = $collection->prepareQuery();
        //  print($query);
         
        //  print_r($collection);
    
        // $cart = Mage::getSingleton('checkout/session')
        //     ->getcart()
        //     ->getItemCollection()
        //     ->select(['sum(main_table.sub_total)'=>'subTotal','item_id']);

        // Mage::log($cart->prepareQuery());
       

        // $checkout = Mage::getModel('checkout/cart')->getCollection()->getData();
        // print_r($checkout);
        // $paypal = new ApiContext(
        //     new OAuthTokenCredential(
        //         'AWkpuOJ9kF4McXPr4qlyFYVPLnMWzWPS8yuQWCmvEfkaKR_XmY9-KWfsNO50iljMI_bRscgBubc8O6H8',  // Replace with your actual Client ID
        //         'EAwkGDcX-ITy6IYiw1rNkB-8aoMTwgjNTNb4BC991opub9a-xmT3a-y0EFUxp9EWSJmOHuFOsUYyzTix' // Replace with your actual Client Secret
        //     )
        // );
        $paypal = new Paypal_Init();
        $paypal->payment();
    }
}
