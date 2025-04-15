<?php

class Replay_Model_Resource_Ticket_Comment extends Core_Model_Resource_Abstract{
    public function _construct(){
      $this->init("ticket_comment","comment_id");
  
    }
}
?>