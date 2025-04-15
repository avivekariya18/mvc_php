<?php
class Admin_Block_Html_Elements_Radio
{
    protected $_data = [];
    public function __construct($data)
    {
        $this->_data = $data;
    }

    public function render()
    {
        $html = "<input type ='radio' ";
        if (isset($this->_data['id'])) {
            $html .= sprintf("id='%s'", $this->_data['id']);
        }
        if (isset($this->_data['name'])) {
            $html .= sprintf("name ='%s'", $this->_data['name']);
        }
        if (isset($this->_data['value'])) {
            $html .= sprintf("value ='%s'", $this->_data['value']);
        }
        $html .= "/>";
        return $html;
    }
}
