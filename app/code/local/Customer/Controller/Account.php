<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Customer_Controller_Account // extends Core_Controller_Customer_Action
{
    protected $_allowedAction = [
        'registration',
        'login',
        'forget',
        'forgetpassword'
    ];

    public function registrationAction()
    {
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('Customer/Account_Registration')
            ->setTemplate('customer/account/registration.phtml');
        $layout->getChild('content')->addChild('registration', $view);
        $layout->toHtml();
    }
    public function loginAction()
    {
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('Customer/Account_Login')
            ->setTemplate('customer/account/login.phtml');
        $layout->getChild('content')->addChild('login', $view);
        $layout->toHtml();
    }
    public function registerCustomerAction()
    {
        $request = Mage::getModel('core/request')
            ->getParams();
        // echo "<pre>";
        // print_r($request);
        // die;
        if ($customerModel = Mage::getModel('Customer/Account')
            ->setData($request['customer'])
            ->save()
        ) {
            Mage::getSingleton('core/message')->addMessage("success", "Your Account Successfully Registered!");
        } else {
            Mage::getSingleton('core/message')->addMessage("error", "Your Account Not Registered, Please Try Again!");
        }
        header('location:http://localhost/mvc_new/Customer/Account/login');
    }
    public function validatAction()
    {
        $request = Mage::getModel('core/request')
            ->getParams();

        $customerModel = Mage::getModel('Customer/Account')
            ->load($request['customer']['email'], 'email');

        if (is_null($customerModel->getData())) {
            Mage::getSingleton('core/message')->addMessage("error", "Email Is Not Regitered");
            header('location:http://localhost/mvc_new/Customer/Account/login');
        } else if ($request['customer']['password'] != $customerModel->getPassword()) {
            Mage::getSingleton('core/message')->addMessage("error", "Invalid Password!");
            header('location:http://localhost/mvc_new/Customer/Account/login');
        } else {
            Mage::getModel('core/Session')
                ->set('customer_id', $customerModel->getCustomerId());
            Mage::getSingleton('core/message')->addMessage("success", "Successfully Login!");
            header('location:http://localhost/mvc_new');
        }
    }
    public function logoutAction()
    {
        Mage::getSingleton('core/session')->remove('customer_id');
        Mage::getSingleton('core/message')->addMessage("success", "Your Account Logout Successfully!");

        header('location:http://localhost/mvc_new');
    }
    public function forgetpasswordAction()
    {
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('Customer/Account_Forgetpassword')
            ->setTemplate('customer/account/forgetpassword.phtml');
        $layout->getChild('content')
            ->addChild('forgetpassword', $view);
        $layout->toHtml();
    }

    public function forgetAction()
    {
        $request = Mage::getModel('core/request');
        $email = $request->getParam('email');

        $customer = Mage::getModel('customer/account')
            ->getCollection()
            ->addFieldToFilter('email', ['=' => $email])
            ->getdata();

        if (empty($customer)) {
            Mage::getSingleton('core/message')->addMessage("error", "Email Id Is Not Registered!");
            header("Location: http://localhost/mvc_new/customer/account/forgetpassword");
        } else {
            $otp = rand(1000, 9999);
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'avivekariya1805@gmail.com';
                $mail->Password = 'gjvr kveo skwb xkdv';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Email Details
                $mail->setFrom('avivekariya1805@gmail.com', 'Avi Patel');
                $mail->addAddress($email);
                $mail->Subject = "Your One-Time Password (OTP)";
                $mail->Body = "Dear User,\n\nYour OTP is: $otp\n\nThis OTP is valid for 10 minutes. Do not share it.";
                if ($mail->send()) {
                    Mage::getSingleton('core/message')->addMessage("success", "OTP Send In Your Mail!");
                } else {
                    Mage::getSingleton('core/message')->addMessage("error", "In Srever Error, Try Again After Some Time!");
                }

                // Store OTP in session
                $session = Mage::getSingleton('core/session');
                $session->set('forgot_password_otp', $otp);
                $session->set('forgot_password_otp_time', time());
                $session->set('forgot_password_email', $email);
                header("Location: http://localhost/mvc_new/customer/account/verifyotp");
            } catch (Exception $e) {
                Mage::getSingleton('core/message')->addMessage("error", "OTP Not Sand Please Check Email Is Valid? , Error : {$e}");
                header("Location: http://localhost/mvc_new/customer/account/forgetpassword");
            }
        }
    }
    public function verifyotpAction()
    {
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('Customer/Account_verifyotp')
            ->setTemplate('customer/account/verifyotp.phtml');
        $layout->getChild('content')
            ->addChild('verifyotp', $view);
        $layout->toHtml();
    }

    public function verifyAction()
    {
        $request = Mage::getModel('core/request');
        $enteredOtp = $request->getParam('otp');


        if (empty($enteredOtp)) {
            Mage::getSingleton('core/message')->addMessage("error", "Please Enter OTP!");
            header("Location: http://localhost/mvc_new/customer/account/verify");
        }

        $session = Mage::getSingleton('core/session');
        $storedOtp = $session->get('forgot_password_otp');
        $otpTime = $session->get('forgot_password_otp_time');
        $email = $session->get('forgot_password_email');

        if (empty($storedOtp) || empty($otpTime) || empty($email)) {
            Mage::getSingleton('core/message')->addMessage("error", "Please Try Again!");
            header("Location: http://localhost/mvc_new/customer/account/forgetpassword");
        }

        if (time() - $otpTime > 600) {
            Mage::getSingleton('core/message')->addMessage("error", "Time Is Over, Please Try Again!");
            header("Location: http://localhost/mvc_new/customer/account/forgetpassword");
        }

        if ($enteredOtp == $storedOtp) {
            Mage::getSingleton('core/message')->addMessage("success", "Email Verified Successfully!");
            header("Location:http://localhost/mvc_new/customer/account/createpassword");
        } else {
            Mage::getSingleton('core/message')->addMessage("error", "Please Enter Valid OTP");
            header("Location: http://localhost/mvc_new/customer/account/verifyotp");
        }
    }
    public function createpasswordAction()
    {
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('Customer/Account_Createpassword')
            ->setTemplate('customer/account/createpassword.phtml');
        $layout->getChild('content')
            ->addChild('createpassword', $view);
        $layout->toHtml();
    }
    public function newPasswordAction()
    {
        $session = Mage::getSingleton('core/session');
        $request = Mage::getModel('core/request');
        $password = $request->getParam('password');
        $email = $session->get('forgot_password_email');

        if (empty($password) || empty($email)) {
            Mage::getSingleton('core/message')->addMessage("error", "Please Try Again, Error In SetPassword!");
            header("Location: http://localhost/mvc_new/customer/account/forgetpassword");
        }

        try {
            $customerModel = Mage::getModel('customer/account')
                ->load($email, 'email');

            $customerData = $customerModel->getData();
            $customerData['password'] = $password;
            if ($setpassword = Mage::getModel('customer/account')
                ->setdata($customerData)
                ->save()
            ) {
                Mage::getSingleton('core/message')->addMessage("success", "Your Password Set Successfully!");
            } else {
                Mage::getSingleton('core/message')->addMessage("error", "New Passeord Does Not Set, Please Try Again!");
            }

            $session->remove('forgot_password_otp');
            $session->remove('forgot_password_otp_time');
            $session->remove('forgot_password_email');

            header("Location: http://localhost/mvc_new/customer/account/login");
        } catch (Exception $e) {
            Mage::getSingleton('core/message')->addMessage("error", "Error In Set Password So Please Try Again!");
            header("Location: http://localhost/emvc_new/customer/account/forgetpassword");
        }
    }
}
