<?php
class Customer_Controller_Account_Address extends Core_Controller_Customer_Action
{

    public function saveAddressAction()
    {
        $address = Mage::getModel('core/request')
            ->getParams()['address'];
        $customerId = Mage::getSingleton('core/session')
            ->get('customer_id');
        $address['customer_id'] = $customerId;
        if (Mage::getModel('customer/account_address')
            ->setData($address)
            ->save()
        ) {
            if ($address['address_id']) {
                Mage::getSingleton('core/message')->addMessage("success", "Your Address updated Successfully!");
            }else{
                Mage::getSingleton('core/message')->addMessage("success", "Your Address Add Successfully!");
            }
        }else{
            Mage::getSingleton('core/message')->addMessage("error", "Your Address Not Add Or Not Updated");
        }
        header("Location: http://localhost/mvc_new/customer/account_profile/dashboard");
    }

    // public function deleteAddressAction()
    // {
    //     $address = Mage::getModel('core/request')
    //         ->getQuery('address_id');
    //     Mage::getModel('customer/account_address')
    //         ->load($address)
    //         ->delete();
    //     header("Location: http://localhost/mvc_new/customer/account_profile/dashboard");
    // }
    public function deleteAddressAction()
    {
        $address = Mage::getModel('core/request')
            ->getQuery('address_id');
        $deletedata = Mage::getModel('customer/account_address')->getCollection()
            ->addFieldToFilter('address_id', ['=' => $address])
            ->addFieldToFilter('default_address', ['=' => 1])
            ->getdata();
        if ($deletedata) {
            Mage::getSingleton('core/message')->addMessage("error", "This Address Is Default So Not Deleted!");
            header("Location: http://localhost/mvc_new/customer/account_profile/dashboard");
        } else {
            if (Mage::getModel('customer/account_address')
                ->load($address)
                ->delete()
            ) {
                Mage::getSingleton('core/message')->addMessage("success", "Your Address Deleted Successfully!");
            } else {
                Mage::getSingleton('core/message')->addMessage("error", "Your Address Not updated!");
            }
            header("Location: http://localhost/mvc_new/customer/account_profile/dashboard");
        }
    }

    public function setdefaultAction()
    {
        $addressId = Mage::getModel('core/request')->getQuery('address_id');
        $customerId = Mage::getModel('core/session')->get('customer_id');
        $addressModel = Mage::getModel('customer/account_address');


        $addressData = $addressModel->getCollection()
            ->addFieldToFilter('customer_id', $customerId);
        $address = $addressData->addFieldToFilter('default_address', 1)->getData()[0];
        $addressModel->setDefaultAddress(0)
            ->setAddressId($address->getAddressId())
            ->save();


        $addressData = $addressModel->getCollection()
            ->addFieldToFilter('customer_id', $customerId);
        $address = $addressData->addFieldToFilter('address_id', $addressId)->getData()[0];
        if ($addressModel->setDefaultAddress(1)
            ->setAddressId($address->getAddressId())
            ->save()
        ) {
            Mage::getSingleton('core/message')->addMessage("success", "Your Default Address Change Successfully!");
        } else {
            Mage::getSingleton('core/message')->addMessage("error", "Default Address Not Change");
        }

        header("Location: http://localhost/mvc_new/customer/account_profile/dashboard");
    }
}
