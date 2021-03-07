<!DOCTYPE HTML>
<html lang="nl">
<head>
    <title>Snoepwinkel</title>

    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Koop je favoriete snoep bij FlappiesSnoep! Alleen vandaag 30% korting!">

    <!-- Styles -->
    <link rel="preload" type="text/css" href="css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"></noscript>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous"/>

    <script type="text/javascript" src="js/app.js" defer></script>
    <script type="text/javascript" src="js/modal.js" defer></script>

</head>
<body class="candy-store-bg-image">

    <header class="my-4">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <img  class="img-fluid mx-auto d-block" src="images/shop-logo.png" alt="Logo">
                    </div>
                </div>
            </div>
        </section>
    </header>

    <main>
        <section>
            <div class="container product-overview-bg-color my-4 p-3">

                <div class="category-container py-4 justify-content-between">
                    <button type="button" class="border-0 btn-category active m-2">New</button>
                    <button type="button" class="border-0 btn-category m-2">Zoet</button>
                    <button type="button" class="border-0 btn-category m-2">Zuur</button>
                    <button type="button" class="border-0 btn-category m-2">Drop</button>
                    <button type="button" class="border-0 btn-category m-2">Koek</button>
                </div>

                <?php
                    session_start();


                    if (isset($_POST['add-product'])){


                        if(isset($_SESSION['cart'])){

                            $item_array_id = array_column($_SESSION['cart'], "product_id");

                            if(in_array($_POST['product_id'], $item_array_id)){
                                ?>

                                <div class="alert alert-warning alert-dismissible mb-0 already-in-cart active" role="alert">
                                    <strong>Holy guacamole!</strong>&nbsp;Je hebt dit product al in je winkelwagentje!
                                </div>

                                <?php

                            }else {

                                $count = count($_SESSION['cart']);
                                $item_array = array(
                                    'product_id' => $_POST['product_id']
                                );

                                $_SESSION['cart'][$count] = $item_array;
                            }

                        }else{

                            $item_array = array(
                                'product_id' => $_POST['product_id']
                            );

                            // Create new session variable
                            $_SESSION['cart'][0] = $item_array;
                        }
                    }


                ?>

                <div class="row no-gutters align-items-stretch">

                    <?php

                        require_once ("database/connection.php");
                        require_once ('inc/functions.php');

                        $connection = getDatabaseConnection();
                        if (!$connection) {
                            ?>
                                <div class="col-12 p-3">
                                    <div class="text-center no-products-found no-database-found d-flex justify-content-center align-items-center">
                                        <div>

                                            <?php
                                                include 'pages/footer.php';
                                                includeFooter('algemene-voorwaarden.pdf#page=1&pagemode=bookmarks', 'pages/contact.php', "fixed-bottom");
                                            ?>

                                            <strong><?php die("Er kon geen verbinding gemaakt worden met de database..."); ?></strong>

                                        </div>
                                    </div>
                                </div>
                            <?php
                        }

                        $products = getProducts($connection, 'products');

                        if (empty($products)) {
                            ?>
                            <div class="col-12 p-3">
                                <div class="text-center no-products-found no-database-found d-flex justify-content-center align-items-center">
                                    <div>
                                        <strong><?php die("Geen producten gevonden..."); ?></strong>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        foreach ($products as $product) {
                            ?>
                            <div class="col-12 col-sm-6 col-lg-4 p-3">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                    <div class="product-image" onclick="modal.show('<?php echo $product['product_id'] ?>', '<?php echo $product['name']?>', '<?php echo $product['image_path']?>', '<?php echo $product['description']?>')" style="background-image: url('images/products/<?php echo $product['image_path']?>');"></div>

                                    <div class="product-information my-3">
                                        <div class="product-name my-3"><strong><?php echo $product['name']?></strong></div>

                                        <button type="submit" name="add-product" class="border-0 add-to-cart-button btn-block">
                                            <div class="price-container d-flex justify-content-between">

                                                <span class="price">€<?php echo $product['price'] ?></span>

                                                <div class="float-right d-flex align-items-center">
                                                    <span class="add-to-cart-text">Toevoegen</span><i class="fas fa-shopping-cart"></i>
                                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id'] ?>">
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <?php
                        }
                    ?>

                </div>
            </div>
        </section>

        <section>

            <a href="pages/cart.php" target="_blank">
                <div class="cart-contents position-fixed">

                    <?php
                    if (isset($_SESSION['cart'])) {
                        $count = count($_SESSION['cart']);
                        echo "<span class=\"product-count text-dark position-absolute\" id=\"product-count\">$count</span>";
                    } else {
                        echo "<span class=\"product-count text-dark position-absolute\" id=\"product-count\">0</span>";
                    }
                    ?>
                </div>
            </a>
        </section>
    </main>

    <!-- Include footer with PHP -->
    <?php include 'pages/footer.php';
        includeFooter('algemene-voorwaarden.pdf#page=1&pagemode=bookmarks', 'pages/contact.php');
    ?>

</body>
</html>
