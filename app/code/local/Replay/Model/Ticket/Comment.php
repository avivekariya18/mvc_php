<?php
class Replay_Model_Ticket_Comment extends Core_Model_Abstract
{
    public function init()
    {
       $this->_resourceClassName = "Replay_Model_Resource_Ticket_Comment";
       $this->_collectionClass = "Replay_Model_Resource_Ticket_Comment_Collection";
    }
}
?>