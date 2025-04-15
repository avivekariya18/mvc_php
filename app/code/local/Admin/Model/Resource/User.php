<?php
class Admin_Model_Resource_User extends Core_Model_Resource_Abstract
{
    public function _construct(){
        $this->init("admin_user","admin_id");
    
      }
}
?>