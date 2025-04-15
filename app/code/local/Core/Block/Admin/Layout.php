<?php
class Core_Block_Admin_Layout extends Core_Block_Template
{
    protected $_template;
    public function __construct()
    {
        $this->prepareChildren();
        $this->prepareJsCss();
        $this->_template = "page/root.phtml";
    }

    public function prepareChildren()
    {
        $header = $this->createBlock("page/header")
            ->setTemplate('page/admin/header.phtml');
        $message = $this->createBlock('Core/Message');    
        $this->addChild('message',$message);
        $message = $this->createBlock('Core/Message');    
        $this->addChild('message',$message);
        $this->addChild('header', $header);
        $head = $this->createBlock("page/head")
            ->setTemplate('page/admin/head.phtml');
        $this->addChild('head', $head);
        $content = $this->createBlock("page/content")
            ->setTemplate('page/admin/content.phtml');
        $this->addChild('content', $content);
        $footer = $this->createBlock("page/footer")
            ->setTemplate('page/admin/footer.phtml');
        $this->addChild('footer', $footer);
     
    }

    public function prepareJsCss(){
        $head = $this->getChild('head');
        //echo "<pre>";
       // print_r($head);
        $head->addJs('page/common.js')
             ->addCss('page/common.css');
           //  print_r($this);
    }
   
    

    public function createBlock($block)
    {
        return Mage::getBlock($block);
    }

    
}
