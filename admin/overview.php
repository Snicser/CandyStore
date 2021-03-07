<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged-in-user']) || empty($_SESSION['logged-in-user'])) {
    header("Location: ".$_SERVER["SERVER_PROTOCOL"], true, 403);
    exit();
}

// Get the stuff we need
require_once "../database/connection.php";
require_once "../mollie-api/initialize.php";

// Check connection
$connection = getDatabaseConnection();
if (!$connection) {
    header($_SERVER["SERVER_PROTOCOL"], true, 503);
    exit();
}
?>
<!DOCTYPE HTML>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Flavio Schoute">
    <title>FlappiesSnoep | Bestelling overview </title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <header>
        <section>
            <div class="container">
                <a href="dashboard.php">Ga terug</a>
            </div>
        </section>
    </header>

    <main>
        <section>
            <div class="container">
                <ul class="list-group">
                    <?php

                    try {

                        /*
                         * Determine the url parts to these example files.
                         */
                        $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
                        $hostname = $_SERVER['HTTP_HOST'];
                        $path = dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);

                        /*
                         * Get the all payments for this API key ordered by newest.
                         */
                        $payments = $mollie->payments->page();

                        foreach ($payments as $payment) {
                            echo "<li>";
                            echo htmlspecialchars($payment->description) . " : ";
                            echo "<strong>" . htmlspecialchars($payment->id) . "</strong><br>";
                            echo htmlspecialchars($payment->amount->currency) . " " . htmlspecialchars($payment->amount->value) . "<br />";

                            echo "Status: " . htmlspecialchars($payment->status) . "<br />";

                            if ($payment->hasRefunds()) {
                                echo "Payment has been (partially) refunded.<br />";
                            }

                            if ($payment->hasChargebacks()) {
                                echo "Payment has been charged back.<br />";
                            }

                            if ($payment->canBeRefunded() && $payment->amountRemaining->currency === 'EUR' && $payment->amountRemaining->value >= '2.00') {
                                echo " (<a href=\"{$protocol}://{$hostname}{$path}/refund-payment.php?payment_id=" . htmlspecialchars($payment->id) . "\">refund</a>)";
                            }

                            echo "</li>";
                        }

                        /**
                         * Get the next set of Payments if applicable
                         */
                        $nextPayments = $payments->next();

                        if (! empty($nextPayments)) {
                            foreach ($nextPayments as $payment) {
                                echo "<li>";
                                echo "<strong style='font-family: monospace'>" . htmlspecialchars($payment->id) . "</strong><br />";
                                echo htmlspecialchars($payment->description) . "<br />";
                                echo htmlspecialchars($payment->amount->currency) . " " . htmlspecialchars($payment->amount->value) . "<br />";

                                echo "Status: " . htmlspecialchars($payment->status) . "<br />";

                                if ($payment->hasRefunds()) {
                                    echo "Payment has been (partially) refunded.<br />";
                                }

                                if ($payment->hasChargebacks()) {
                                    echo "Payment has been charged back.<br />";
                                }

                                if ($payment->canBeRefunded() && $payment->amountRemaining->currency === 'EUR' && $payment->amountRemaining->value >= '2.00') {
                                    echo " (<a href=\"{$protocol}://{$hostname}{$path}/refund-payment.php?payment_id=" . htmlspecialchars($payment->id) . "\">refund</a>)";
                                }

                                echo "</li>";
                            }
                        }
                    } catch (ApiException $e) {
                        echo "API call failed: " . htmlspecialchars($e->getMessage());
                    }

                    ?>
                </ul>
            </div>
        </section>
    </main>

</body>
</html>

