<?php

include 'dbConnection.php';
include 'sqlCommands.php';

$conn = OpenConnection();
if ($conn) {

    tableExists($conn, "user");
    tableExists($conn, "freeUser");

    echo "Connected Successfully";
    CloseConnection($conn);
} else {
    echo "Failed to Connect";
}



?>