<?php  
Class Admin_Block_Widget_Grid_Columns_Link extends Admin_Block_Widget_Grid_Columns_Abstract{
    protected $_data;
    protected $_id;
    public function __construct() {
        //$this->setTemplate('admin/widget/columns/link.phtml');
    }
    public function setdata($data){
        $this->_data =$data;
        return $this;
    }
    public function setid($id){
        $this->_id =$id;
        return $this;
    }
    
    public function getdata(){
        return $this->_data;
    }
    public function getid(){
        return $this->_id;
    }

    
}

?>