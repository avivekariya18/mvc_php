<?php 
class Checkout_Model_Session extends Core_Model_Session{
    public function getCart()
    {
        
       $cartId =  $this->get('cart_id');
      $cartId = (is_null($cartId))?0:$cartId;
       $cart = Mage::getModel('checkout/cart')
               ->load($cartId); 

      // print_r($_SESSION);
      // $this->get('customer_id');
       if(!$cart->getCartId())
       {
        //echo "123";
         $cart->setCustomerId($this->get('customer_id'))
            //   ->setCreatedAt(time())
            //   ->setUpdatedAt(time())
              ->save();
        $this->set('cart_id',$cart->getCartId()) ;
       // print_r($cart);
       // die;
        

       // always return model
       // cart model pr addproduct funtion (product_id,quantity)->mage::getmodel(checkout/cartitem)
       //cart  model ->before_save ->total amount , price product mathi lavaavani, quantity add karavani
       //cartmodel->getitemcollection()->checkoutsession
       //cartitem-model->getProduct()-object return ->protected variable ma store 
       //here make else condition 
       }
       return $cart;
    }
}
?>