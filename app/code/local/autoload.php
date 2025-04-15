<?php

class Varien_Object{
    protected $_data=[];
    public function __construct($data)
    {
        $this->_data[]= $data;
    }
}

spl_autoload_register(function ($className) {
	$classPath = str_replace("_", "/", $className);
    @include $classPath . '.php';
});

spl_autoload_register(function ($className) {
	$classPath = str_replace("_", "/", $className);
    // echo $classPath;
    @include getcwd().'/lib/'. $classPath . '.php';
});
@include getcwd().'/lib/PayPal/autoload.php';
// include "../../../lib/PayPal/autoload.php";
?>