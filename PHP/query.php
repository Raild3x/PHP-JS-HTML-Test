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
        if ($values.count() == 0){
            echo "Reading full table";
            readTable($conn, $tblName);
        } else {
            echo "Reading table selection.";
            select($conn, $tblName, $values);
        }
        break;

    default:
        echo "Invalid cmd passed";
}

CloseConnection($conn);


?>