<?php  
Class Admin_Block_Widget_Grid_Columns_Delete extends Admin_Block_Widget_Grid_Columns_Abstract{
    public function render(){
        $callback = $this->_data['callback'];
        return '<a href="'.$this->getlink()->$callback($this->_row).'">'.$this->_data['lable'].'</a>';
    }
}

?>