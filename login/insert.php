<?php

// Get the stuff we need
require_once "../database/connection.php";

// Check connection
$connection = getDatabaseConnection();

$password = $_POST['pwd'];

$hashed = password_hash($password, PASSWORD_DEFAULT, ["options" => 10]);
$q = 'UPDATE `customers` SET `password`=:pwd WHERE `customers`.`customer_id` = 1';
$preStatement = $connection->prepare($q);
$preStatement ->bindParam(':pwd', $hashed);
$preStatement -> execute();







