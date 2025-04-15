<?php
class Admin_Model_Session extends Core_Model_Session
{
  public function getRole()
  {
 
    $adminId =  $this->get('id');
    $admin = Mage::getModel('admin/user')
               ->load($adminId);
    $role = Mage::getModel('admin/role')
               ->load($admin->getRoleId());      
    return $role;
  }
}