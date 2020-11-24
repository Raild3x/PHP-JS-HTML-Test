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
    $values = explode("|",$_POST['values']);
}


$conn = OpenConnection();

switch ($cmd) {
    case "new":
        newRow($conn, $tblName, $values);
        break;
    case "select":
        if (sizeof($values) == 2) {
            readTable($conn, $values[0], $values[1]);
        } else {
            $columns = $values[1];
            $conditions = $values[2];
            $tables = $values[0];
            select($conn, $tables, $columns, $conditions);
        }
        break;
    case "update":
        updateTable($conn, $tblName, $values[0], $values[1]);
        break;
    default:
        echo "Invalid cmd passed";
}

CloseConnection($conn);


?>