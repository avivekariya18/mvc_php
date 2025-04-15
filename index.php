<?php
include_once("../mvc_new/app/code/local/autoload.php");
include_once("../mvc_new/app/Mage.php");
error_reporting(E_ALL);
define("DS", DIRECTORY_SEPARATOR);
date_default_timezone_set('Asia/Kolkata');
Mage::getSingleton('core/session');
Mage::init();
?>