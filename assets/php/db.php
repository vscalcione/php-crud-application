<?php

    function create_db(){
        $serverName = "localhost";
        $username = "root";
        $password = "";
        $dbName = "bookstore";

        // create connection
        $connection = mysqli_connect($serverName, $username, $password);

        // Check Connection
        if (!$connection){
            die("Connection Failed : " . mysqli_connect_error());
        }

        // create Database
        $sql = "CREATE DATABASE IF NOT EXISTS $dbName";

        if(mysqli_query($connection, $sql)){
            $connection = mysqli_connect($serverName, $username, $password, $dbName);

            $sql = " CREATE TABLE IF NOT EXISTS books(".
                                "id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,".
                                "book_name VARCHAR (25) NOT NULL,".
                                "book_publisher VARCHAR (20),".
                                "book_price FLOAT".
                            ");";

            if(mysqli_query($connection, $sql)){
                return $connection;
            }else{
                echo "Cannot Create table...!";
            }

        }else{
            echo "Error while creating database ". mysqli_error($connection);
        }
    }