<?php
// project/lib/PayPal/init.php (Paypal_Init Class)
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
 
class Paypal_Init
{
    private $paypal;
 
    public function __construct()
    {
        $this->paypal = new ApiContext(
            new OAuthTokenCredential(
                'AWkpuOJ9kF4McXPr4qlyFYVPLnMWzWPS8yuQWCmvEfkaKR_XmY9-KWfsNO50iljMI_bRscgBubc8O6H8', // Replace with your Client ID
                'EAwkGDcX-ITy6IYiw1rNkB-8aoMTwgjNTNb4BC991opub9a-xmT3a-y0EFUxp9EWSJmOHuFOsUYyzTix'  // Replace with your Client Secret
            )
        );
 
        $this->paypal->setConfig([
            'mode' => 'sandbox', // Use 'live' for production
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ]);
    }
 
    public function payment()
    {
        $payer = new PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');
 
        $amount = new Amount();
        $amount->setTotal('0.01')->setCurrency('USD');
 
        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)->setDescription('Payment for Order #1234');
 
        $redirectUrls = new PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl($this->successUrl())
            ->setCancelUrl($this->cancelUrl());
 
        $payment = new PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);
 
        try {
            $payment->create($this->paypal);
            header("Location: " . $payment->getApprovalLink());
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
 
    public function successUrl()
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . '/payment-success.php'; // Adjust path
    }
 
    public function cancelUrl()
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . '/payment-cancel.php'; // Adjust path
    }
 
    public function success()
    {
        if (!isset($_GET['paymentId']) || !isset($_GET['PayerID'])) {
            die("Payment failed.");
        }
 
        $paymentId = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];
 
        $payment = Payment::get($paymentId, $this->paypal);
        $execute = new PaymentExecution();
        $execute->setPayerId($payerId);
 
        try {
            $result = $payment->execute($execute, $this->paypal);
            echo "Payment successful! Transaction ID: " . $result->id;
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
 
    public function cancel()
    {
        echo "Payment was canceled.";
    }
}
?>