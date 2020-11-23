<?php
include 'sqlCommands.php';
$conn = OpenConnection();
if ($conn) {
    echo "TESTESTEST";
    echo json_encode(getTables($conn));
    CloseConnection($conn);
} else {
    echo "Failed to connect";
}

?>