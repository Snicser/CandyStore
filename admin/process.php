<?php

    // Get the stuff we need
    require_once "../database/connection.php";
    require_once "../inc/functions.php";

    // Check connection
    $connection = getDatabaseConnection();
    if (!$connection) {
        header($_SERVER["SERVER_PROTOCOL"], true, 503);
        exit();
    }

    // Default values
    $id = 0;
    $name = '';
    $image =  '';
    $description = '';
    $price = '';
    $category = '';
    $update = false;

    // Check if save button is clicked
    if (isset($_POST['save'])) {

        // Check if the form is empty if so redirect to dashboard
        if (empty($_POST['product-name']) || empty($_POST['product-image']) || empty($_POST['product-description']) || empty($_POST['product-price'])) {
            header("Location: dashboard.php", true, 303);
        } else {

            // Get the data from the form input
            $name = $_POST['product-name'];
            $image = $_POST['product-image'];
            $description = $_POST['product-description'];
            $price = $_POST['product-price'];
            $category = $_POST['product-category'];

            // Insert product into the database
            insertProduct($connection, 'products', $name, $image, $description, $price, $category);

            // Alert admin that the product has been added and redirect back to dashboard
            echo '<script>alert("Nieuw product toegevoegt!")</script>';
            header("Location: dashboard.php", true, 303);
        }

    }

    // Check if delete button is clicked
    if (isset($_GET['delete'])) {
        // Get product ID and delete product from database
        $productID = $_GET['delete'];
        deleteProduct($connection, 'products', $productID);

        // Alert admin that the product has been deleted and redirect back to dashboard
        echo '<script>alert("Product verwijderd!")</script>';
        header("Location: dashboard.php", true, 303);
    }

    // Check if edit button is clicked
    if (isset($_GET['edit'])) {
        // Get product ID and delete product from database
        $productID = $_GET['edit'];

        // Get products - don't need to check because otherwise to will never get printed in the dashboard so that's why we dont check $product
        $products = getProducts($connection, 'products', $productID);

        foreach ($products as $product) {
            $id = $product['product_id'];
            $name = $product['name'];
            $image = $product['image_path'];
            $description = $product['description'];
            $price = $product['price'];
            $category = $product['category_id'];
        }

        $update = true;
    }

    // Check if the update button is clicked
    if (isset($_POST['update'])) {

        // Check if the form is empty if so redirect to dashboard
        if (empty($_POST['product-name']) || empty($_POST['product-image']) || empty($_POST['product-description']) || empty($_POST['product-price'])) {
            header("Location: dashboard.php", true, 303);
        } else {

            // Get the data from the form input
            $id = $_POST['product-id'];
            $name = $_POST['product-name'];
            $image = $_POST['product-image'];
            $description = $_POST['product-description'];
            $price = $_POST['product-price'];
            $category = $_POST['product-category'];

            // Update product
            updateProduct($connection, 'products', $id, $name, $image, $description, $price, $category);

            // Alert admin that the product has been added and redirect back to dashboard
            header("Location: dashboard.php", true, 303);
        }
    }

?>
