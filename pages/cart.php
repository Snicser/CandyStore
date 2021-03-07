<?php

    session_start();

    require_once ("../database/connection.php");
    require_once ("../inc/functions.php");

    $connection = getDatabaseConnection();
    if (!$connection) {
        ?>
        <div class="col-12 p-3">
            <div class="text-center no-products-found no-database-found d-flex justify-content-center align-items-center">
                <div>
                    <strong><?php die("Er kon geen verbinding gemaakt worden met de database..."); ?></strong>
                </div>
            </div>
        </div>
        <?php
    }

    if (isset($_POST['remove'])) {
        if ($_GET['action'] == 'remove') {
            foreach ($_SESSION['cart'] as $key => $value){
                if($value["product_id"] == $_GET['id']){
                    unset($_SESSION['cart'][$key]);
                    echo '<script>alert("Het product is verwijderd uit je winkelwagentje!");</script>';
                }
            }
        }
    }
?>

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

    <link rel="stylesheet" type="text/css" href="../css/cart.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous"/>

    <script src="../js/app.js" defer></script>
</head>
<body>

    <header class="my-4">
        <section>
            <div class="container">
                <h1 class="mb-0 py-4 text-center welcome-text text-white text-uppercase">Winkel wagentje</h1>
            </div>
        </section>
    </header>

    <div class="pb-5">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

                    <a class="alert-warning btn-go-back" href="../"><i class="fas fa-arrow-left"></i></a>

                    <!-- Shopping cart table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="p-2 px-3 text-uppercase">Productnaam</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">Prijs</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">Aantal</div>
                                    </th>
                                    <th scope="col" class="border-0 bg-light">
                                        <div class="py-2 text-uppercase">Verwijderen</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                $total = 0;
                                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                    $buttonDisable = false;

                                    $product_id = array_column($_SESSION['cart'], 'product_id');

                                    $products = getProducts($connection, 'products');

                                    foreach ($products as $product) {
                                        foreach ($product_id as $id) {
                                            if ($product['product_id'] == $id) {

                                                // It have to be a switch statement - match statement PHP 8 doesn't work for some weird reason
                                                $category;
                                                switch ($product['category_id']) {
                                                    case 0:
                                                        $category = 'zoet';
                                                        break;
                                                    case 1:
                                                        $category = 'zuur';
                                                        break;

                                                    default:
                                                       $category =  "-";
                                                       break;
                                                }

                                                ?>

                                                    <tr>
                                                        <form action="cart.php?action=remove&id=<?php echo $product['product_id']; ?>" id="<?php echo $product['product_id']; ?>" method="POST"></form>
                                                        <th scope="row">
                                                            <div class="p-2">
                                                                <img src="../images/products/<?php echo $product['image_path'] ?>" alt="" width="70" class="img-fluid">
                                                                <div class="ml-3 d-inline-block align-middle">
                                                                    <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle"><?php echo $product['name'] ?></a></h5><span class="text-muted font-weight-normal font-italic d-block">Categorie: <?php echo $category ?></span>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td class="align-middle"><strong>&euro;&nbsp;<?php echo $product['price'] ?></strong></td>
                                                        <td class="align-middle"><label class="mb-0 shadow-sm" for="quantity"><input  class="quantity" type="number" name="quantity" id="quantity" min="1" value="1"></label></td>
                                                        <td class="align-middle"><button type="submit" name="remove" form="<?php echo $product['product_id']; ?>" class="border-0 cart-product-remove"><i class="fa fa-trash"></i></button></td>
                                                        <input type="hidden" id="cart-price" value="<?php echo $product['price'] ?>">
                                                    </tr>
                                                <?php
                                                $total = $total + (double) $product['price'];
                                            }
                                        }
                                    }

                                } else {
                                    $buttonDisable = true;
                                    ?>
                                    <div class="alert alert-warning alert-dismissible fade show empty-cart-animation d-flex align-items-center" role="alert">
                                        <a class="alert-warning btn-go-back" href="../"><i class="fas fa-arrow-left"></i></a>&nbsp;
                                        <strong>Holy guacamole!</strong>&nbsp;Er zitten geen producten in je winkelwagentje!
                                    </div>
                                    <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row py-5 p-4 bg-white rounded shadow-sm">
                <div class="col-lg-6">
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
                    <div class="p-4">
                        <div class="input-group mb-4 border rounded-pill p-2">
                            <input name="coupon-code" type="text" placeholder="Bon gebruiken" aria-describedby="button-addon3" class="form-control border-0">
                            <div class="input-group-append border-0">
                                <?php
                                    if ($buttonDisable) {
                                        echo '<button id="button-addon3" type="button" class="btn btn-checkout shadow-none px-4 rounded-pill" disabled><i class="fa fa-gift mr-2"></i>Gebruiken</button>';
                                    } else {
                                        echo '<button id="button-addon3" type="button" class="btn btn-checkout shadow-none px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Gebruiken</button>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Overzicht</div>
                    <div class="p-4">
                        <ul class="list-unstyled mb-4">
                            <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Subtotaal</strong><strong>&euro;&nbsp;390.00</strong></li>
                            <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                                <h5 class="font-weight-bold">&euro;&nbsp;<?php echo $total ?></h5>
                            </li>
                        </ul>

                        <?php
                            if ($buttonDisable) {
                                echo '<a href="#" class="btn btn-checkout shadow-none rounded-pill py-2 btn-block disabled" aria-disabled="true" role="button" >Verder naar bestellen</a>';
                            } else {
                                echo '<a href="../checkout/checkout.php" class="btn btn-checkout shadow-none rounded-pill py-2 btn-block" role="button" >Verder naar bestellen</a>';
                            }

                        ?>

                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
