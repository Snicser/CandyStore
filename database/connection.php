<?php

    require_once('credentials.php');

    define("DBNAME", "candy_store");

    function getDatabaseConnection(): ?PDO {
        static $connection;

        if ($connection) return $connection; // Reuse  existing connection

        try {
            $connection = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException) {
            // Ignore
        }

        return $connection;
    }

?>
