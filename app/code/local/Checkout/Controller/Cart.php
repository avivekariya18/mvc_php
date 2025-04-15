<?php

class Checkout_Controller_Cart
{

    public function indexAction()
    {
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('checkout/cart_index')
            ->setTemplate('checkout/cart/index.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }

    public function updateAction()
    {

        $request = Mage::getModel('core/request')->getParams();
        $item_id = $request['item_id'];
        $quantity = $request['quantity'];
        // Mage::getSingleton('checkout/session')->getCart()
        //     ->updateItem($item_id, $quantity)
        //     ->save();
        if (Mage::getSingleton('checkout/session')->getCart()
            ->updateItem($item_id, $quantity)
            ->save()
        ) {
            // echo "123";
            Mage::getSingleton('core/message')->addMessage("success", "product Update successfully!");
            // Mage::getSingleton('core/message')->addMessage("warning", "product add successfully");
        } else {
            Mage::getSingleton('core/message')->addMessage("error", "product Does not updated!");
        }
        header("Location: http://localhost/mvc_new/checkout/cart/index ");
    }

    public function removeAction()
    {

        $delete_id = Mage::getModel("core/request")->getQuery('item_id');
        if (Mage::getSingleton('checkout/session')->getCart()
            ->removeItem($delete_id)
            ->save()
        ) {
            Mage::getSingleton('core/message')->addMessage("success", "product remove successfully!");
        } else {
            Mage::getSingleton('core/message')->addMessage("error", "product does not removed!");
        }
        header("Location: http://localhost/mvc_new/checkout/cart/index");
    }

    public function addAction()
    {
        $requestData = Mage::getModel('core/request')
            ->getParam('cart');

        $product_id = $requestData['product_id'];
        $quantity =  $requestData['quantity'];

        //print_r($product_id);
        //print_r($quantity);

        $cart = Mage::getSingleton('checkout/session')->getCart();

        if ($cart->addProduct($product_id, $quantity)->save()) {
            Mage::getSingleton('core/message')->addMessage("success", "product Add successfully!");
        }

        header("Location: http://localhost/mvc_new/checkout/cart/index ");
    }

    public function couponAction()
    {
        $request = Mage::getModel('core/request')
            ->getParams();
        print_r($request);
        // die;
        $couponCode = $request['coupon_code'];
        $totalPrice = $request['total_price'];
        $couponModel = Mage::getModel('checkout/coupon');
        if (array_key_exists($couponCode, $couponModel->getAllCoupon())) {
            $totalDiscount = $couponModel->calculateDiscount($couponCode, $totalPrice);
            if ($cartModal = Mage::getSingleton('checkout/session')
                ->getcart()
                ->setTotalAmount($totalPrice - $totalDiscount)
                ->setCouponCode($couponCode)
                ->setCouponDiscount($totalDiscount)
                ->save()
            ) {
                Mage::getSingleton('core/message')->addMessage("success", "Coupon code successfully Applied!");
            }
        } else {
            Mage::getSingleton('core/message')->addMessage("error", "Coupon Code is not Valid!");
        }
        header("Location: http://localhost/mvc_new/checkout/cart/index ");
    }

    public function addressAction()
    {
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('checkout/cart_address')
            ->setTemplate('checkout/cart/address.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }

    public function saveAddressAction()
    {
        $request = Mage::getModel('core/request')
            ->getParams();
        echo "<pre>";
        print_r($request);
        $cartId = Mage::getSingleton('checkout/session')
            ->getCart()
            ->setEmail($request['email'])
            ->save()->getCartId();
        $result1 = array_merge($request['personal'], $request['billing']);
        $result1['cart_id'] = $cartId;
        $result1['typeofaddress'] = 'billing';

        $addressModel = Mage::getModel('checkout/cart_address');
        $addressModel->setData($result1)
            ->save();

        $result1 = array_merge($request['personal'], $request['shipping']);
        $result1['cart_id'] = $cartId;
        $result1['typeofaddress'] = 'shipping';
        $addressModel->setData($result1)
            ->save();

        header("Location: http://localhost/mvc_new/checkout/cart/shipping ");
    }




    public function testAction() {}
}
