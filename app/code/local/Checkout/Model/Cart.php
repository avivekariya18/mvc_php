<?php
class Checkout_Model_Cart extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName = "Checkout_Model_Resource_Cart";
        $this->_collectionClass = "Checkout_Model_Resource_Cart_Collection";
    }

    public function addProduct($product_id, $quantity)
    {

        //echo "<pre>";

        $cartDatas = $this->getItemCollection()
            ->getData();
       // print_r($cartDatas);
        
        $flag = 0;

        foreach($cartDatas as $cartData)
        {
            if ($cartData->getProductId() == $product_id) {
                $item_id = $cartData->getItemId();
                $quantity = $cartData->getProductQuantity() + $quantity;
                $flag = 1;
            }
        }
        if($flag) {
            Mage::getModel('checkout/cart_item')
                ->setItemId($item_id)
                ->setProductId($product_id)
                ->setProductQuantity($quantity)
                ->save();
        } else {
            Mage::getModel('checkout/cart_item')
                ->setProductId($product_id)
                ->setCartId($this->getCartId())
                ->setProductQuantity($quantity)
                ->save();
        }

        //   print_r($cartItem);
        //  print_r($this);
        // print_r($this);
        return $this;
    }



    protected function _beforeSave()
    {
        //  echo "<pre>";
        //print_r($this);
        $cartItemData = $this->getItemCollection()
                             ->getData();

        $totalAmount = 0;
        foreach ($cartItemData as $cartItem) {
            //  print_r($cartItem->getSubTotal());
            $totalAmount = (int)$cartItem->getSubTotal() + $totalAmount;
        }
        $totalAmount = $totalAmount - (int)$this->getCouponDiscount();
        $totalAmount = $totalAmount + (int)$this->getShippingAmount();

        $this->setTotalAmount($totalAmount);

        $now = new DateTime();
        $this->setUpdatedAt($now->format('Y-m-d H:i:s'));
    }

    public function getItemCollection()
    {
        return Mage::getModel('checkout/cart_item')
                ->getCollection()
                ->addFieldToFilter('cart_id', $this->getCartId());
    }

    public function getAddressCollection(){
        return Mage::getModel('checkout/cart_address')
                ->getCollection()
                ->addFieldToFilter('cart_id', $this->getCartId());
    }

    public function getShippingAddress(){
        return $this->getAddressCollection()
                ->addFieldToFilter('typeofaddress','shipping');
    }

    public function getBillingAddress(){
        return $this->getAddressCollection()
                ->addFieldToFilter('typeofaddress','billing');
    }

    public function removeItem($item_id)
    {
        $cartDatas = $this->getItemCollection()
            ->getData();
        echo "<pre>";
        print_r($cartDatas);
        foreach ($cartDatas as $cartData) {
            if ($cartData->getItemId() == $item_id) {
                $cartData->delete();
            }
        }
       // print_r($this);

        return $this;
    }

    public function updateItem($item_id,$quantity)
    {
        $cartDatas = $this->getItemCollection()
                          ->getData();
        // echo "<pre>";
        // print_r($cartDatas);
        foreach ($cartDatas as $cartData) {
            if ($cartData->getItemId() == $item_id) {
               $cartData->setProductQuantity($quantity)
                        ->save(); 
            }
        }
       // print_r($this);

        return $this;
    }


}
