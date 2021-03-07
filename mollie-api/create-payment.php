<?php

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Types\PaymentMethod;

// Check method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // If the calling script is so rude as to not use the proper method, don't bother to respond either (but let 'm know it was wrong)
    header( $_SERVER["SERVER_PROTOCOL"] ." 405 Method Not Allowed", true, 405 );
    exit();
}

// Check form input
//customer_id	first_name	last_name	residence	address	postalcode	phonenumber	email_address	username	password	country_id
if (empty($_POST['first-name']) || empty($_POST['last-name']) || empty($_POST['email']) || empty($_POST['residence']) || empty($_POST['address']) || empty($_POST['phonenumber']) || empty($_POST['postalcode'])) {
    header( "Location: ../checkout/checkout.php", true, 303);
    exit();
} else {

    $email = $_POST['email'];

    // Remove all illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate e-mail
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        header( "Location: ../checkout/checkout.php?email=not-valid", true, 303);
        exit();
    }

    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $residence = $_POST['residence'];
    $address = $_POST['address'];
    $phonenumber = $_POST['phonenumber'];
    $postalcode = $_POST['postalcode'];
    $country= $_POST['country'];
}

try {

    //Initialize the Mollie API library with your API key.
    require "initialize.php";
    require_once "../database/connection.php";
    require_once "../inc/functions.php";

    $connection = getDatabaseConnection();
    if (!$connection) {
        header($_SERVER["SERVER_PROTOCOL"], true, 503);
        exit();
    }

    /*
     * Generate a unique order id for this example. It is important to include this unique attribute
     * in the redirectUrl (below) so a proper return page can be shown to the customer.
     */
    $orderID = time();

    /*
     * Determine the url parts to these example files.
     */
    $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);


    /*
     * Payment parameters:
     *   amount        Amount in EUROs. This example creates a € 10,- payment.
     *   description   Description of the payment.
     *   redirectUrl   Redirect location. The customer will be redirected there after the payment.
     *   webhookUrl    Webhook location, used to report when the payment changes state.
     *   metadata      Custom metadata that is stored with the payment.
     */
    session_start();

    $payment = $mollie->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => "27.50", // You must send the correct number of decimals, thus we enforce the use of strings
        ],
        "method" => PaymentMethod::IDEAL,
        "description" => "Order #{$orderID}",
        "redirectUrl" => "https://{$hostname}{$path}/return.php?order_id={$orderID}",
        "webhookUrl" => "https://{$hostname}{$path}/webhook.php",
        "metadata" => [
            "order_id" => $orderID,
        ],
    ]);


    $paymentID = $payment -> id;
    $_SESSION['payment_id'] = $paymentID;

    /*
     * Write the data to the database
     */
    $dateTime = new DateTime();
    $dateTime = $dateTime -> format('Y-m-d H:i:s');

    insertCustomers($connection, 'customers', $first_name, $last_name, $residence, $address, $postalcode, $phonenumber, $email, $country);
    insertOrders($connection, 'orders', $first_name, $email, $dateTime, $payment -> id, $orderID);

    /*
     * Send the customer off to complete the payment.
     * This request should always be a GET, thus we enforce 303 http response code
     */
    header("Location: " . $payment -> getCheckoutUrl(), true, 303);
} catch (ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
}

