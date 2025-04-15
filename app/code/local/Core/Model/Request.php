<?php
class Core_Model_Request
{
    protected $_moduleName = "";
    protected $_controllerName = "";
    protected $_actionName = "";
    protected $_baseUrl = "http://localhost/mvc_new/";
    protected $_baseDir = 'C:\xampp\htdocs\mvc_new';
    public function __construct()
    {
        // echo "222";
        // die();
        $uri = $this->getRequestUri();
        $uri = array_filter(explode("/", $uri));
        //echo "<pre>";
        // print_r($uri);
        $this->_moduleName = isset($uri[0]) ? $uri[0] : 'cms';
        $this->_controllerName = isset($uri[1]) ? $uri[1] : 'index';
        $this->_actionName = isset($uri[2]) ? $uri[2] : 'index';
        //   echo "<pre>";
        //  print_r($this);
        // // $this->getActionName();
        //  die();
        //  echo "</pre>";
    }
    public function getRequestUri()
    {
        $strurl = $_SERVER['REQUEST_URI'];
        $strurl = str_replace("/mvc_new/", "", $strurl);

        return $strurl;
    }
    public function getModuleName()
    {
        return $this->_moduleName;
    }
    public function getControllerName()
    {
        return $this->_controllerName;
    }
    public function getActionName()
    {
        //print_r($this->_actionName) ;
        // echo "111";
        // die();
        return $this->_actionName;
    }


    public function getQuery($field=null)
    {
        if($field === null)
        {
            return $_GET;
        }
        if (isset($_GET[$field])) {
            return $_GET[$field];
        } else {
            return "";
        }
    }

    public function getParam($field)
    {
        if (isset($_POST[$field])) {
            return $_POST[$field];
        } else {
            return "";
        }
    }

    public function getParams()
    {
        return $_POST;
    }

    public function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet()
    {
       return $_SERVER['REQUEST_METHOD'] === 'GET';
    } 
}
