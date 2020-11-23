<?php
include 'dbConnection.php';
include 'sqlCommands.php';

if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
}

if (isset($_POST['tblName'])) {
    $tblName = $_POST['tblName'];
}

$conn = OpenConnection();
if ($conn) {
    switch($cmd) {
        case "tables":
            echo json_encode(getTables($conn));
            break;
        case "columns":
            echo json_encode(getColumns($conn, $tblName));
            break;
        default:
            echo "Invalid command given. <br/>";
    }
        
    CloseConnection($conn);
} else {
    echo "Failed to connect";
}

?>