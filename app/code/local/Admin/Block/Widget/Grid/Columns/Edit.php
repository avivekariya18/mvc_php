<?php  
Class Admin_Block_Widget_Grid_Columns_Edit extends Admin_Block_Widget_Grid_Columns_Abstract{
    // protected $_data;
    // protected $_row;
    // public function __construct() {
    //     //$this->setTemplate('admin/widget/filter/edit.phtml');
    // }
    // public function setdata($data){
    //     $this->_data =$data;
    //     return $this;
    // }
    // public function getdata(){
    //     return $this->_data;
    // }
    public function render(){
        $callback = $this->_data['callback'];
        return '<a href="'.$this->getlink()->$callback($this->_row).'">'.$this->_data['lable'].'</a>';
    }
}
?>