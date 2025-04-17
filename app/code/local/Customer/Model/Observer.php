<?php
class Customer_Model_Observer
{
    protected $_data = [];
    public function productSave($data)
    {
        $this->_data = $data;
        echo '<pre>';
        print_r($this->_data);
        echo '</pre>';
        
    }
}
