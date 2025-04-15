<?php
class Core_Controller_Front{
    public function init(){
     
        $request = Mage::getModel("core/request");
       // $actionName = $request->getActionName();
     //  print_r($request);
        $controller =  sprintf("%s_Controller_%s", $request->getModuleName(), $request->getControllerName());
        $controller =  ucwords($controller,"_");
       // echo $controller;
        $class= new $controller();
       // print_r($request);
        // die();
        $actionName = $request->getActionName().'Action';

        $class->$actionName();

    }

    
}
?>