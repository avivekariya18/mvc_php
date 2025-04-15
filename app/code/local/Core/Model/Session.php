<?php
class Core_Model_Session{
    public function __construct()
    {
        @session_start();

    }

    public function getId()
    {
        return session_id();
    }

    public function set($key,$value)
    {
       $_SESSION[$key] = $value;
    }
    public function get($key)
    {
          return  isset($_SESSION[$key])?$_SESSION[$key]:null;
    }

    public function remove($key)
    {
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        };
    }
    public function removemessage($key){
        if(isset($_SESSION['message'][$key])){
            unset($_SESSION['message'][$key]);
        }
        else{
            return "";
        }
    } 
}
?>