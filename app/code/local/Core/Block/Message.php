<?php
 
class Core_Block_Message extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('page/message.phtml');
    }
    public function getModel(){
        return Mage::getSingleton('core/message');
    }
}
?>  