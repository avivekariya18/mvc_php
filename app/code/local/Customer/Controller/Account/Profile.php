<?php
class Customer_Controller_Account_Profile extends Core_Controller_Customer_Action
{
    public function dashboardAction()
    {
        $customerId = Mage::getSingleton('core/session')
            ->get('customer_id');

        $customer = Mage::getModel('customer/account')->load($customerId);

        $layout = Mage::getBlock("core/layout");
        $viewCustomer = $layout->createBlock("customer/account_profile_dashboard");


        $layout->getChild("content")->addChild("dashboard", $viewCustomer);
        $viewCustomer->setCustomer($customer);

        $dashboardDetails = $layout->createBlock("customer/account_profile_dashboard_details");
        $layout->getChild("content")->getChild("dashboard")->addChild("dashboard_details", $dashboardDetails);

        $dashboardAddress = $layout->createBlock("customer/account_profile_dashboard_address");
        $layout->getChild("content")->getChild("dashboard")->addChild("dashboard_address", $dashboardAddress);

        $layout->toHtml();
    }

    public function saveAction()
    {
        $request = Mage::getModel('core/request')->getParam('customer');
        // echo "<pre>";
        // print_r($request);
        // die;
        if (Mage::getModel('customer/account')->setData($request)
            ->save()
        ) {
            Mage::getSingleton('core/message')->addMessage("success", "Your Account updated Successfully!");
        }else{
            Mage::getSingleton('core/message')->addMessage("error", "Your Account Not updated!");
        }
        header('location:http://localhost/mvc_new/customer/account_profile/dashboard');
    }
}
