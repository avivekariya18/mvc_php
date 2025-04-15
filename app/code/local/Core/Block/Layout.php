<?php
class Core_Block_Layout extends Core_Block_Template
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
        $header = $this->createBlock("page/header");
        $this->addChild('header', $header);
        $message = $this->createBlock('Core/Message');    
        $this->addChild('message',$message);
        $head = $this->createBlock("page/head");
        $this->addChild('head', $head);
        $content = $this->createBlock("page/content");
        $this->addChild('content', $content);
        $footer = $this->createBlock("page/footer");
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
