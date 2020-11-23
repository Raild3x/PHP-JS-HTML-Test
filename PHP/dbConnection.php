<?php

function openConnection() {
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "1234";
    $db = "csc471";

    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $db) or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}

function CloseConnection($conn) {
    $conn -> close();
}

?>