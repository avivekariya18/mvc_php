<?php
class Replay_Model_Ticket_Comment extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = "Replay_Model_Resource_Ticket_Comment";
        $this->_collectionClass = "Replay_Model_Resource_Ticket_Comment_Collection";
    }
    protected function _afterSave()
    {
        $commentId = $this->getCommentId();
        $this->load($commentId);
        if($this->getparentId() != null  || $this->getparentId() != ''){
            $childCount = Mage::getModel('replay/ticket_comment')
            ->getcollection()
            ->select(['total'=>'COUNT(*)'])
            ->addFieldToFilter('parent_id', $this->getParentId())
            ->addFieldToFilter('is_active',1)
            ->getfirstItem();
        if($childCount->getTotal() == 0 ){
            Mage::getModel('replay/ticket_comment')
                ->setCommentId($this->getParentId())
                ->setIsActive(0) 
                ->save();
        }
        }
        
    }
}
