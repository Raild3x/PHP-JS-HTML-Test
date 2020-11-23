<?php

include 'dbConnection.php';
include 'sqlCommands.php';

$conn = OpenConnection();
if ($conn) {

    tableExists("user");
    tableExists("freeUser");

    echo "Connected Successfully";
    CloseConnection($conn);
} else {
    echo "Failed to Connect";
}



?>