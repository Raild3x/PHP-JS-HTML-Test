<?php

include 'dbConnection.php';

$conn = OpenConnection();
if ($conn) {
    echo "Connected Successfully";
    CloseConnection($conn);
} else {
    echo "Failed to Connect";
}



?>