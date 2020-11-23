<?php
include 'dbConnection.php';

$conn = OpenConnection();

echo "Connected Successfully";

CloseConnection($conn);

?>