<!DOCTYPE HTML>
<html lang="nl">
<head>
    <title>Snoepwinkel</title>

    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Styles -->
    <link rel="preload" type="text/css" href="../css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"></noscript>
    <link rel="stylesheet" type="text/css" href="../css/login.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous"/>

</head>
<body class="d-flex align-items-center">

    <?php

    // Get the stuff we need
    require_once "../database/connection.php";
    require_once "../inc/functions.php";

    // Start or continue session
    session_start();

    // Check connection
    $connection = getDatabaseConnection();
    if (!$connection) {
        header($_SERVER["SERVER_PROTOCOL"], true, 503);
        exit();
    }

    // Check if login button is pressed
    if (isset($_POST['login'])) {

        // Check if form is not empty
        if (empty($_POST['username']) || empty($_POST['password'])) {
            header('Location: '.htmlspecialchars($_SERVER["PHP_SELF"]), true, 303);
        } else {

            // Get the data from the form input
            $name = $_POST['username'];
            $password = $_POST['password'];

            // Check if name and password is correct, if so login is success otherwise the get a message
            if (checkUserLogin($connection, 'customers', $name, $password)) {
                $_SESSION['logged-in-user'] = $name;
                header('Location: ../admin/dashboard.php', true, 303);
            } else {
                header('Location: '.htmlspecialchars($_SERVER["PHP"]).'?login=failed', true, 303);
            }
        }
    }

    ?>

    <form class="form-signin m-auto w-100" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" accept-charset="UTF-8">

        <div class="text-center mb-4">
            <img class="img-fluid" src="../images/shop-logo.png" alt="Shop logo" width="50%">
        </div>

        <?php

        // Check if URL return login=failed to display error message
        if (isset($_GET['login'])) {
            if ($_GET['login'] == 'failed') {
                echo '<div class="alert alert-warning text-center" role="alert">Verkeerde gebruikersnaam of wachtwoord!</div>';
            }
        }

        ?>

        <div class="form-label-group">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required="" autofocus="">
            <label for="username">Username</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
            <label for="password">Password</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Onthoud mij
            </label>
        </div>

        <button class="btn btn-lg btn-login b-0" type="submit" name="login" id="login">Inloggen</button>

        <div class="my-3">
            <a class="btn-go-back position-relative" href="../">← Ga naar Snoepwinkel</a>
        </div>
    </form>


<!--    <form action="insert.php" method="post">-->
<!--        <input type="text" id="pwd" name="pwd">-->
<!--        <button type="submit">Verzenden</button>-->
<!--    </form>-->

</body>
</html>
