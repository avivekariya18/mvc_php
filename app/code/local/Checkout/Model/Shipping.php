<?php
class Checkout_Model_Shipping extends Core_Model_Abstract
{
    protected $_shipping = [
        "express"=>"300",
        "standard"=>'200',
        "pickup"=>'0'
    ];
    public function getAllShipping(){
        return $this->_shipping;
    }
    public function CalculateShippingAmount($shippingType){
        // $value = $this->_shipping[$shippingType];
        //     $shippingAmount = $value;
            return $this->_shipping[$shippingType];
        }
}
?>