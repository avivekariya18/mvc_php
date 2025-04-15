<?php
class Cms_Controller_Index extends Core_Controller_Front_Action{

    public function __construct(){
       
    }
    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $home = $layout->createBlock('cms/index')
            ->setTemplate('cms/index.phtml');
        $layout->getChild('content')->addChild('home', $home);
       // $layout->getChild('head')->addCss('admin/product_index/new.css');

        $layout->toHtml();
    }
}
?>
