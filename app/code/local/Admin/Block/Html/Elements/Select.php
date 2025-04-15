<?php
class Admin_Block_Html_Elements_select
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }

    public function render()
    {
        $html = "<select ";
        if (isset($this->_data['name'])) {
            $html .= sprintf("name='%s'", $this->_data['name']);
        }
        $html .= ">";
       
        if(isset($this->_data['value']) && is_array($this->_data['value'])){
           foreach($this->_data['value'] as $value){
            $selected = (isset($this->_data['selected']) && $this->_data['selected'] == $value) ? " selected" : "";
            $html .= sprintf("<option value = '%s' %s> %s </option>",$value,$selected,$value);
           } 
        }
        $html .= "</select>";
        return $html;
    }
}