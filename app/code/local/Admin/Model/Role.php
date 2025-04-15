<?php
class Admin_Model_Role extends Core_Model_Abstract
{
    public function init()
    {
       $this->_resourceClassName = "Admin_Model_Resource_Role";
       $this->_collectionClass = "Admin_Model_Resource_Role_Collection";
    }
}
?>