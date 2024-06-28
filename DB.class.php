<?php

class DB {

    private $conn;

    function __construct(){
        $this->conn = new mysqli($_SERVER['DB_SERVER'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB']);
        //$this->conn = new mysqli("localhost", "rxv7131", "Barkeeper3-ribbons", $_SERVER['DB']);

        if($this->conn->connect_error){
            echo "Connection failed: ".mysqli_connect_error();
            echo '<script>console.log("connection error"); </script>';
            die();
        }
    }

    function getConn(){
        return $this->conn;
    }

}