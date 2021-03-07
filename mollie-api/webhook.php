<?php
/*
 * How to verify Mollie API Payments in a webhook.
 *
 * See: https://docs.mollie.com/guides/webhooks
 */

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // If the calling script is so rude as to not use the proper method, don't bother to respond either (but let 'm know it was wrong)
    header( $_SERVER["SERVER_PROTOCOL"] ." 405 Method Not Allowed", true, 405 );
    exit;
}

try {

    session_start();

    /*
     * Initialize the Mollie API library with your API key.
     *
     * See: https://www.mollie.com/dashboard/developers/api-keys
     */
    require "initialize.php";
    require "create-payment.php";
    require "../database/connection.php";

//    http_response_code(307);

    $connection = getDatabaseConnection();
    if (!$connection) {
        header($_SERVER["SERVER_PROTOCOL"], true, 503);
        exit();
    }

    $query = "UPDATE `orders` SET `is_paid` =  'konijn'";
    $preparedStatement = $connection->prepare($query);
    $preparedStatement->execute();

    $payment = $mollie->payments->get($_POST['id']);

//    header("Non sens header:" . $mollie->payments->get($_POST['id']));

    if (empty($payment) || empty($row)) {
        $query = "UPDATE `orders` SET `is_paid` = `konijn`";
        $preparedStatement = $connection->prepare($query);
        $preparedStatement->execute();
    } else {
        $query = "UPDATE `orders` SET `is_paid` = `?` WHERE `orders`.`payment_id` = $paymentID";
        $preparedStatement = $connection->prepare($query);
        $preparedStatement->execute([$statusUpdate]);
    }
//
//    $payment -> update();
//
//    if ($payment -> isPaid()) {
//        if (isset($_SESSION['payment_id'])) {
//            $paymentID = $_SESSION['payment_id'];
//            print_r($paymentID);
//            print_r($_SESSION);
//            exit();
//        } else {
//            // This is probably not working
//            print_r($_SESSION);
//            exit();
//        }
//    }



//    $paymentID = '';
//
//    if (isset($_SESSION['payment_id'])) {
//        $paymentID = $_SESSION['payment_id'];
//        print_r($paymentID);
//        print_r($_SESSION);
//        exit();
//    } else {
//        // This is probably not working
//        print_r($_SESSION);
//        exit();
//    }
//
//    $payment = $mollie->payments->get($paymentID);


    if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
        /*
         * The payment is paid and isn't refunded or charged back.
         * At this point you'd probably want to start the process of delivering the product to the customer.
         */


        $statusUpdate = $payment->status;




    } elseif ($payment->isOpen()) {
        /*
         * The payment is open.
         */
    } elseif ($payment->isPending()) {
        /*
         * The payment is pending.
         */
    } elseif ($payment->isFailed()) {
        /*
         * The payment has failed.
         */
    } elseif ($payment->isExpired()) {
        /*
         * The payment is expired.
         */
    } elseif ($payment->isCanceled()) {
        /*
         * The payment has been canceled.
         */
    } elseif ($payment->hasRefunds()) {
        /*
         * The payment has been (partially) refunded.
         * The status of the payment is still "paid"
         */
    } elseif ($payment->hasChargebacks()) {
        /*
         * The payment has been (partially) charged back.
         * The status of the payment is still "paid"
         */
    }
} catch (ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
}

