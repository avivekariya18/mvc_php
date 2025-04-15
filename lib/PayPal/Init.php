<?php
include '/lib/PayPal/autoload.php';
// include '../MVC_New/lib/PayPal/vendor/autoload.php';
class Paypal_Init
{
    // public function __construct()
    // {
    //     echo "123";
    // }
    public static function payment($cartId, $total_amount)
    {
        $paypal = new PayPal\Rest\ApiContext(
            new PayPal\Auth\OAuthTokenCredential(
                'AWkpuOJ9kF4McXPr4qlyFYVPLnMWzWPS8yuQWCmvEfkaKR_XmY9-KWfsNO50iljMI_bRscgBubc8O6H8',  // Replace with your actual Client ID
                'EAwkGDcX-ITy6IYiw1rNkB-8aoMTwgjNTNb4BC991opub9a-xmT3a-y0EFUxp9EWSJmOHuFOsUYyzTix' // Replace with your actual Client Secret
            )
        );

        $paypal->setConfig([
            'mode' => 'sandbox', // Use 'live' for production
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ]);

        $payer = new PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new PayPal\Api\Amount();
        $amount->setTotal($total_amount)->setCurrency('USD');

        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)->setDescription('Payment for cart_id : ' . $cartId);

        $redirectUrls = new PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl('http://localhost/mvc_new/sale/payment/success/')
            ->setCancelUrl('http://localhost/mvc_new/sale/payment/cancle/');

        $payment = new PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($paypal);
            header("Location: " . $payment->getApprovalLink());
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    public static function success()
    {
        $paypal = new PayPal\Rest\ApiContext(
            new PayPal\Auth\OAuthTokenCredential(
                'AWkpuOJ9kF4McXPr4qlyFYVPLnMWzWPS8yuQWCmvEfkaKR_XmY9-KWfsNO50iljMI_bRscgBubc8O6H8',  // Replace with your actual Client ID
                'EAwkGDcX-ITy6IYiw1rNkB-8aoMTwgjNTNb4BC991opub9a-xmT3a-y0EFUxp9EWSJmOHuFOsUYyzTix' // Replace with your actual Client Secret
            )
        );

        $paypal->setConfig([
            'mode' => 'sandbox', // Use 'live' for production
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ]);
        if (!isset($_GET['paymentId']) || !isset($_GET['PayerID'])) {
            die("Payment failed.");
        }

        $paymentId = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];

        $payment = PayPal\Api\Payment::get($paymentId, $paypal);
        $execute = new PayPal\Api\PaymentExecution();
        $execute->setPayerId($payerId);

        try {
            $result = $payment->execute($execute, $paypal);
            header("Location: http://localhost/mvc_new/checkout/order/placeorder/?T_id={$result->id}");
            //echo "Payment successful! Transaction ID: " . $result->id;
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
    public static function cancel()
    {
        echo "Payment was canceled.";
    }
    // public static function refund($saleId, $amount = null, $currency = 'USD')
    // {
    //     $paypal = new \PayPal\Rest\ApiContext(
    //         new \PayPal\Auth\OAuthTokenCredential(
    //             'AWkpuOJ9kF4McXPr4qlyFYVPLnMWzWPS8yuQWCmvEfkaKR_XmY9-KWfsNO50iljMI_bRscgBubc8O6H8',
    //             'EAwkGDcX-ITy6IYiw1rNkB-8aoMTwgjNTNb4BC991opub9a-xmT3a-y0EFUxp9EWSJmOHuFOsUYyzTix'
    //         )
    //     );

    //     $paypal->setConfig([
    //         'mode' => 'sandbox',
    //         'http.ConnectionTimeOut' => 30,
    //         'log.LogEnabled' => true,
    //         'log.FileName' => 'PayPal.log',
    //         'log.LogLevel' => 'DEBUG'
    //     ]);

    //     try {
    //         // Get the sale object by ID
    //         $sale = \PayPal\Api\Payment::get($saleId, $paypal);

    //         // Create refund request
    //         $refundRequest = new \PayPal\Api\RefundRequest();

    //         if ($amount !== null) {
    //             $amt = new \PayPal\Api\Amount();
    //             $amt->setCurrency($currency)
    //                 ->setTotal($amount); // Partial refund
    //             $refundRequest->setAmount($amt);
    //         }

    //         // Execute refund
    //         $refundedSale = $sale->refund($refundRequest, $paypal);

    //         echo "Refund successful! Refund ID: " . $refundedSale->getId();
    //     } catch (Exception $ex) {
    //         echo "Refund failed: " . $ex->getMessage();
    //     }
    // }
    public function refund($paymentId,$refundAmount)
    {
        $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AWkpuOJ9kF4McXPr4qlyFYVPLnMWzWPS8yuQWCmvEfkaKR_XmY9-KWfsNO50iljMI_bRscgBubc8O6H8', // Replace with your Client ID
                'EAwkGDcX-ITy6IYiw1rNkB-8aoMTwgjNTNb4BC991opub9a-xmT3a-y0EFUxp9EWSJmOHuFOsUYyzTix' // Replace with your Client Secret
            )
        );

        $paypal->setConfig([
            'mode' => 'sandbox', // Change to 'live' in production
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'DEBUG'
        ]);

        // if (!isset($_GET['paymentId'], $_GET['amount'])) {
        //     die("Invalid request. paymentId and amount are required.");
        // }

        // $paymentId = $_GET['paymentId'];
        // $refundAmount = $_GET['amount']; // Amount to refund
        // $paymentId = 'PAYID-M7YTVFQ6P5864725L133635T';
        // $refundAmount = 800300.00; // Amount to refund

        try {
            $payment = \PayPal\Api\Payment::get($paymentId, $paypal);
            $transactions = $payment->getTransactions();

            if (empty($transactions)) {
                die("No transactions found for payment ID: " . $paymentId);
            }

            $relatedResources = $transactions[0]->getRelatedResources();

            if (empty($relatedResources)) {
                die("No related resources found for payment ID: " . $paymentId);
            }

            $sale = $relatedResources[0]->getSale();

            if (!$sale) {
                die("No sale object found for payment ID: " . $paymentId);
            }

            $refund = new \PayPal\Api\Refund();
            $amount = new \PayPal\Api\Amount();
            $amount->setCurrency('USD')->setTotal($refundAmount); // Change USD if needed
            $refund->setAmount($amount);

            $refundedSale = $sale->refund($refund, $paypal);

            echo "Refund successful. Refund ID: " . $refundedSale->getId();
            // Optionally, redirect or display a success message.
            // header("Location: http://localhost/ecommerecemvc/checkout/order/refundSuccess?refundID=".$refundedSale->getId());
            return 1;
        } catch (Exception $ex) {
            echo "Refund error: " . $ex->getMessage();
            // Optionally, handle the error and redirect.
            // header("Location: http://localhost/ecommerecemvc/checkout/order/refundError?error=".$ex->getMessage());
            return 0;

        }
    }
}
