<?php
class Mage
{
    private static $registry = [];
    public static function init()
    {
        $front = new Core_Controller_Front();
        $front->init();
    }

    public static function getModel($className)
    {
        $class = str_replace("/", "_Model_", $className);
        $class = ucwords($class, '_');
        // echo $class;
        return new $class;
    }

    public static function getBlock($className)
    {
        $class = str_replace("/", "_Block_", $className);
        $class = ucwords($class, '_');
        // echo $class;
        return new $class;
    }

    public static function getBaseDir()
    {
        return "C:/xampp/htdocs/mvc_new/";
    }

    public static function getBaseUrl()
    {
        return "http://localhost/mvc_new/";
    }


    public static function log($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }


    public static function getSingleton($className)
    {
        $class = str_replace("/", "_Model_", $className);
        $class = ucwords($class, '_');
        if (isset(self::$registry[$class])) {
            return self::$registry[$class];
        } else {
            return self::$registry[$class] = new $class;
        }
    }

    public static function getBlockSingleton($className)
    {
        $class = str_replace("/", "_Block_", $className);
        $class = ucwords($class, '_');
        if (isset(self::$registry[$class])) {
            return self::$registry[$class];
        } else {
            return self::$registry[$class] = new $class;
        }
    }

    public static function dispatchEvent($event, $data)
    {

        $base_url = Mage::getBaseDir();
        $file_url = $base_url . "app/Event.xml";
        $xml = simplexml_load_file($file_url) or die("Error: Cannot load XML");
        foreach ($xml->$event->model as $model) {

            $model_arr = explode("::", $model);
            $obj = new $model_arr[0];
            $function = $model_arr[1];

            $obj->$function($data);
            die;
        }
    }
}
