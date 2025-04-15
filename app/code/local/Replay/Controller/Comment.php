<?php

class Replay_Controller_Comment  extends Core_Controller_Customer_Action
{
    
    public function newAction()
    {
        $new = $this->getLayout()->createBlock('Replay/Comment_New')
            ->setTemplate('replay/comment/new.phtml');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->toHtml();
        //echo "<pre>";
    }

}
?>