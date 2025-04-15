<?php
class Core_Block_Template{
    protected $_child = [];
    protected $_template;
    protected $_parent = null;

    public function toHtml()
    {
       include(Mage::getBaseDir()."app/design/frontend/template/".$this->_template);
    }
    public function getRequest(){
        return Mage::getModel('core/request');
    }
    public function setParent($a){
        $this->_parent = $a;
        return $this;
    }

    public function getParent(){
        return $this->_parent;
    }

    public function addChild($key,$block){
        $block->setParent($this);
        $this->_child[$key] = $block;
        // $this->_child[$key]->_parent = $this;
        // echo"<pre>";
        // print_r($this);
    //    die;
       return $this;
    }

    public function removeChild($key){
        if(isset($this->_child[$key]))
        {
            unset($this->_child[$key]) ;
        }
       
        return $this;
    }
    public function getChild($key){
       return isset($this->_child[$key]) ? $this->_child[$key] :"";
    }

    public function getChildHtml($key){
        if($key == '' && count($this->_child))
        {  
            $html = "";
            foreach($this->_child as $child){
                $html .= $child->toHtml();
            }
            return $html;
        }
        return isset($this->_child[$key]) ? $this->_child[$key]->toHtml() :"";
    }

    public function setTemplate($template){
        $this->_template = $template;
        return $this;
    }

    public function getUrl($url){
        $request = Mage::getModel("core/request");
        $_url = [];
        $url = explode("/",$url);
        $_url[] = $url[0] == "*"? $request->getModuleName():$url[0];
        $_url[] = $url[1] == "*"? $request->getControllerName():$url[1];
        $_url[] = $url[2] == "*"? $request->getActionName():$url[2];
        return Mage::getBaseUrl().implode("/",$_url);
    }

    public function getLayout()
    {
        return Mage::getBlockSingleton('core/layout');
    } 
}
?>