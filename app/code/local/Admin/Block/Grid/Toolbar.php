<?php
class Admin_Block_Grid_Toolbar extends Core_Block_Template
{
    protected $_limit = 10;
    protected $_page = 1;
    protected $_collection;

    public function __construct() {}
    public function prepareToolbar()
    {
        // echo "123";
        $page = $this->getRequest()->getQuery("page");
        $limit = $this->getRequest()->getQuery("limit");
        // print($this->_page);
        if (is_numeric($page)) {
            // echo $this->_page;
            $this->_page = $page;
        }
        if (is_numeric($limit)) {
            $this->_limit = intval($limit);
            // echo $this->_limit;
        }

        $this->_collection = clone $this->getParent()
            ->getCollection();
        $this->getParent()
            ->getCollection()
            ->limit($this->_limit, ($this->_page - 1) * $this->_limit)
            // ->prepareQuery();
            ->getData();
    }
    public function getTotalRecords()
    {
        return count($this->_collection->getData());
    }
}
