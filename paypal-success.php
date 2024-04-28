
<?php

use Symfony\Component\HttpFoundation\Session\Session;

include 'header.php'; ?>

<?php

if (array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)) {
    $transaction = $gateway->completePurchase(array(
        'payer_id' => $_GET['PayerID'],
        'transactionReference' => $_GET['paymentId'],
    ));
    $response = $transaction->send();
    if ($response->isSuccessful()) {
        $arr_body = $response->getData();

        $payment_id = $arr_body['id'];
        $payer_id = $arr_body['payer']['payer_info']['payer_id'];
        $payer_email = $arr_body['payer']['payer_info']['email'];
        $amount = $arr_body['transactions'][0]['amount']['total'];
        $currency = "USD";
        $payment_status = $arr_body['state'];
        // Insert into database

        exit;
    } else {
        $_SESSION['error_message'] = $response->getMessage();
    }
} else {
    header('location: ./paypal-cancel.php ');
}

?>