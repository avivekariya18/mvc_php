<?php  
Class Admin_Block_Widget_Grid_Filter_Delete extends Admin_Block_Widget_Grid_Filter_Abstract{
    protected $_data;
    public function __construct() {
        //$this->setTemplate('admin/widget/filter/delete.phtml');
    }
    public function setdata($data){
        $this->_data =$data;
        return $this;
    }
    
    public function getdata(){
        return $this->_data;
    }

}

?>