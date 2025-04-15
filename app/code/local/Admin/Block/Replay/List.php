<?php
class Admin_Block_Replay_List extends Core_Block_Template
{
    public function getAllTicket(){
        return Mage::getModel('replay/ticket')->getCollection()->getData();
    }
}