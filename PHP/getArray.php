<?php
include 'dbConnection.php';
include 'sqlCommands.php';

$cmd;
$tblName;

if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
    echo "AAAAAAAAAAAA";
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
            echo "!INVALID COMMAND GIVEN! ".$cmd."<br/>";
    }
        
    CloseConnection($conn);
} else {
    echo "Failed to connect";
}

?>