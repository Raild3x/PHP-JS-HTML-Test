<?php
include 'dbConnection.php';
include 'sqlCommands.php';

// Read data sent over post
$cmd;
$tblName;
$values;

if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
}
if (isset($_POST['tblName'])) {
    $tblName = $_POST['tblName'];
}
if (isset($_POST['values'])) {
    $values = explode(",",$_POST['values']);
}

$conn = OpenConnection();

switch ($cmd) {
    case "new":
        newRow($conn, $tblName, $values);
        break;
    case "select":
        if ($values[0] == "") {
            readTable($conn, $tblName);
        } else {
            select($conn, $tblName, $values);
        }
        break;

    default:
        echo "Invalid cmd passed";
}

CloseConnection($conn);


?>