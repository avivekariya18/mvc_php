<?php
class Core_Controller_Front_Action{
     
    public function getRequest()
    {
        return Mage::getSingleton('core/request');
    }

    public function getSession()
    {
        
       return Mage::getSingleton('core/session');
    }

    public function redirect($url)
    {
        
         header("Location: ".Mage::getBaseUrl().$url);
         return $this;
    }
}
?>