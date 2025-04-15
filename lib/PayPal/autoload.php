<?php 
spl_autoload_register(function ($className) {
	$classPath = str_replace("_", "/", $className);
    // echo $classPath;
    @include getcwd().'/lib/psr/log/'. $classPath . '.php';
});
?>