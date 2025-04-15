<?php  
Class Admin_Block_Widget_Grid_Columns_Abstract{
    protected $_data;
    protected $_row;
    protected $_link;
    public function setData($data){
        $this->_data = $data;
    }
    public function getData(){
        return $this->_data;
    }
    public function setrow($row){
        $this->_row = $row;
        return $this;
    }
    public function setlink($link){
        $this->_link = $link;
        return $this;  
    }
    public function getlink(){
        return $this->_link;
    }
    public function render(){
        return '<span>'.$this->getvalue().'</span>';
    }
    public function getvalue(){
        return $this->_row[$this->_data['data_index']];
    }
    public function getFilter(){
        $filter = $this->_data['filter'];
        $block = Mage::getBlock('Admin/Widget_Grid_Filter_'.$filter);
        $block->setData($this->_data);
        return $block;
    }

}

?>