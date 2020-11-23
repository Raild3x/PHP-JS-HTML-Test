<?php
include 'dbConnection.php';
include 'sqlCommands.php';

// Read data sent over post

if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
}
if (isset($_POST['tblName'])) {
    $tblName = $_POST['tblName'];
}
if (isset($_POST['values'])) {
    $values = explode(",",$_POST['values']);
}

$success = false;
$conn = OpenConnection();

switch ($cmd) {
    case "new":
        newRow($conn, $tblName, $values);
        break;
    case "select":
        break;

    default:
        echo "Invalid cmd passed";
}

CloseConnection($conn);

if (!$success) {
    echo "Failed Query";
}


?>