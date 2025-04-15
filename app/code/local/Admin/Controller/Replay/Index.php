<?php
class Admin_Controller_Replay_Index extends Core_Controller_Admin_Action
{
    public function listAction()
    {
        $list = $this->getLayout()->createBlock('Admin/replay_list')
            ->setTemplate('admin/replay/list.phtml');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->toHtml();
    }
    public function newAction()
    {
        $new = $this->getLayout()->createBlock('Admin/replay_new')
            ->setTemplate('admin/replay/new.phtml');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->toHtml();
    }
    public function ticketsaveAction()
    {
        $post = Mage::getModel('core/request')->getParam('ticket');
        $tisketModal = Mage::getModel('replay/Ticket')
            ->setData($post)
            ->save();
        header('location:http://localhost/mvc_new/admin/replay_Index/list');
    }
    public function commentAction()
    {
        $new = $this->getLayout()->createBlock('Admin/replay_comment')
            ->setTemplate('admin/replay/comment.phtml');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->getChild('head')->addJs('replay/comment.js');
        $this->getLayout()->toHtml();
    }
    public function commentsaveAction(){
        $comment = Mage::getModel('core/request')->getParam('comment');
        $ticketId = Mage::getModel('core/request')->getParam('ticket_id');
        $parentId = Mage::getModel('core/request')->getParam('parent_id');
        if($parentId == 'NULL'){
            $commentModel = Mage::getModel('replay/ticket_comment')
            ->setComment($comment)
            ->setTicketId($ticketId)
            ->save();
        }else{
            $commentModel = Mage::getModel('replay/ticket_comment')
            ->setComment($comment)
            ->setTicketId($ticketId)
            ->setParentId($parentId)
            ->save();
        }

        // Mage::log($commentModel->getData());
        print_r($commentModel->getCommentId());
        
    }
}
