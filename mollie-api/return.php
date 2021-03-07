<!DOCTYPE HTML>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Flavio Schoute">
    <title>Bedankt voor je bestelling!</title>
</head>
<body>
    <?php

    // Start or continue session
    session_start();

    // Clear the cart
    foreach ($_SESSION['cart'] as $key => $value){
        unset($_SESSION['cart'][$key]);
    }

    echo 'Bedankt voor je bestelling! We gaan er zo snel mogelijk mee aan de slag.';
    echo '<a href="../index.php">Klik hier om terug te gaan naar de hoofdpagina!</a>';
    ?>
</body>
</html>









