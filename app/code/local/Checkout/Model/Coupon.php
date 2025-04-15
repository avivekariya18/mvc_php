<?php 
class Checkout_Model_Coupon extends Core_Model_Abstract{
    protected $_coupon=[
        'coupon1'=>'10%',
        'coupon2'=>'100'
    ];
    public function getAllCoupon(){
        return $this->_coupon;
    }
    public function calculateDiscount($couponCode,$totalPrice){
        $value = $this->_coupon[$couponCode];
        if(substr($value,-1)=='%'){
            $totalDiscount = (($totalPrice *(int)substr($value,0,-1))/100);
        }else{
            $totalDiscount = $value;
        }
        return $totalDiscount;
    }
}