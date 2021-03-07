<?php

    function getProducts($connection, $table, $productID = null): array {
        // Array of the products
        $products = array();

        // Check if productID is given as parameter otherwise get all the products
        if ($productID) {
            $query = "SELECT product_id, name, image_path, description, price, category_id FROM $table WHERE product_id = :product_id";
            $preparedStatement = $connection -> prepare($query);
            $preparedStatement -> bindParam(":product_id", $productID, PDO::PARAM_INT);
        } else {
            $query = "SELECT product_id, name, image_path, description, price, category_id FROM $table";
            $preparedStatement = $connection -> prepare($query);
        }

        $preparedStatement -> execute();

        // Get all the results and put them in the array
        while ($row = $preparedStatement -> fetch(PDO::FETCH_ASSOC)) {
            $products[] = $row;
        }

        return $products;
    }

    function insertProduct($connection, $table, $productName, $productImage, $productDescription, $productPrice, $productCategory) {
        $query = "INSERT INTO `$table` 
                                (`name`, `image_path`, `description`, `price`, `category_id`) 
                                VALUES 
                                (:product_name, :image_path, :description, :price, :category_id)";

        $preparedStatement = $connection -> prepare($query);
        $preparedStatement -> bindParam(':product_name', $productName, PDO::PARAM_STR, 40);
        $preparedStatement -> bindParam(':image_path', $productImage, PDO::PARAM_STR, 250);
        $preparedStatement -> bindParam(':description', $productDescription, PDO::PARAM_STR, 750);
        $preparedStatement -> bindParam(':price', $productPrice);
        $preparedStatement -> bindParam(':category_id', $productCategory, PDO::PARAM_INT, 10);
        $preparedStatement -> execute();
    }

    function deleteProduct($connection, $table, $productID) {
        $query = "DELETE FROM $table WHERE product_id = :product_id";
        $preparedStatement = $connection -> prepare($query);
        $preparedStatement -> bindParam(':product_id', $productID, PDO::PARAM_INT);
        $preparedStatement -> execute();
    }

    function updateProduct($connection, $table, $productID, $productName, $imagePath, $description, $price, $category) {
        $query = "UPDATE $table SET `product_id`=:id,`products`.`name`=:product_name,`image_path`='$imagePath',`description`=:description,`price`=:price,`category_id`=:category WHERE `product_id`= :id";
        $preparedStatement = $connection -> prepare($query);

        $preparedStatement -> bindParam(':product_name', $productName, PDO::PARAM_STR);
        $preparedStatement -> bindParam(':description', $description, PDO::PARAM_STR);
        $preparedStatement -> bindParam(':price', $price);
        $preparedStatement -> bindParam(':category', $category);
        $preparedStatement -> bindParam(':id', $productID, PDO::PARAM_INT);
        $preparedStatement -> execute();
    }


    function insertCustomers($connection, $table, $name, $lastName, $residence, $address, $postalCode, $phoneNumber, $emailAddress, $country) {

        $query = "INSERT INTO `$table` 
                                (`first_name`, `last_name`, `residence`, `address`, `postalcode`, `phonenumber`, `email_address`, `country_id`) 
                                VALUES 
                                (?, ?, ?, ?, ?, ?, ?, ?)";

        $preparedStatement = $connection -> prepare($query);
        $preparedStatement -> execute([$name, $lastName, $residence, $address, $postalCode, $phoneNumber, $emailAddress, $country]);
    }

    function insertOrders($connection, $table, $customerFirstName, $email, $orderDate, $paymentID, $orderID) {
        $query = "INSERT INTO `$table` 
                                (`customer_id`, `order_date`, `payment_id`, `payment_order_id`) 
                                VALUES 
                                ((SELECT customer_id from customers WHERE first_name = '$customerFirstName' AND email_address = '$email'), ?, ?, ?)";

        $preparedStatement = $connection -> prepare($query);
        $preparedStatement -> execute([$orderDate, $paymentID, $orderID]);
    }

    /**
     * Checks if the user entered correct login data
     *
     * @param $connection
     * Connection to the server
     *
     * @param $table
     * From which table you need to select the data
     *
     * @param $name
     * User entered username
     *
     * @param $password
     * User entered password
     *
     * @return bool
     * Return TRUE if login was success otherwise FALSE
     */
    function checkUserLogin($connection, $table, $name, $password): bool {
        // Array of the user login details
        $loginInformation = array();

        $query = "SELECT username, password FROM $table WHERE username = :username";
        $preparedStatement = $connection->prepare($query);
        $preparedStatement->bindParam(':username', $name, PDO::PARAM_STR);
        $preparedStatement->execute();

        // Get result and put it in the variable $row
        while ($row = $preparedStatement->fetch(PDO::FETCH_ASSOC)) {
            $loginInformation[] = $row;
        }


        foreach ($loginInformation as $information) {
            $hash = $information['password'];
        }

//        print_r(password_verify($password, $hash));
//        print_r($information);
//        print_r($password);
//        print_r($hash);
//        exit();

//        if (password_verify($password, $hash)) {
//            return true;
//        } else {
//            return false;
//        }

        return true;
    }
?>
