<?php
class Replay_Model_Ticket extends Core_Model_Abstract
{
    public function init()
    {
       $this->_resourceClassName = "Replay_Model_Resource_Ticket";
       $this->_collectionClass = "Replay_Model_Resource_Ticket_Collection";
    }
}
?>