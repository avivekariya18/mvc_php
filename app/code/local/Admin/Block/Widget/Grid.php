<?php  
Class Admin_Block_Widget_Grid extends Core_Block_Template{
    protected $_collection;
    protected $_columns =[] ;
    public function __construct() {
        $this->setTemplate('admin/widget/grid.phtml');
        $this->addChild('Toolbar',Mage::getBlock('Admin/Grid_Toolbar'));
        // $this->toHtml();
        
    }
    public function addColumns($name,$data){
        $filter = $data['filter'];
        $block = Mage::getBlock('Admin/Widget_Grid_Columns_'.$filter);
        $block->setData($data);
        $block->setLink($this);
        $this->_columns[$name] = $block;
    }
    public function setCollection($collection){
        $this->_collection = $collection;
        return $this->_collection;
    }
    public function getCollection(){
        return $this->_collection;
    }
    public function getColumns(){
        return $this->_columns;
    }
    public function renderFilter($columnName){
        $data = $this->_columns [$columnName];
        $filter = $data['filter'];
        $block = Mage::getBlock('Admin/Widget_Grid_Filter_'.$filter);
        $block->setdata($data)
            ->toHtml();
    }
    public function renderValue($columnName,$id){
        $data = $this->_columns [$columnName];
        $filter = $data['columns'];
        $block = Mage::getBlock('Admin/Widget_Grid_Columns_'.$filter);
        $block->setdata($data)
            ->setid($id)
            ->toHtml();   
    }



}

?>


