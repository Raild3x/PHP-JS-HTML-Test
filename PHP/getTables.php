<?php
include 'sqlCommands.php';
$conn = OpenConnection();
if ($conn) {
    echo getTables($conn);
    CloseConnection($conn);
} else {
    echo "Failed to connect";
}

?>