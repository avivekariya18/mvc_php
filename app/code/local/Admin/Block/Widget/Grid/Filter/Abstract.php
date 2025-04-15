<?php  
Class Admin_Block_Widget_Grid_Filter_Abstract{
    protected $_data;
    protected $_row;
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
    public function render(){
        return '';
    }
}
?>