<?php
include 'dbConnection.php';
include 'sqlCommands.php';

// Read data sent over post
$cmd = $_POST['cmd'];
$tblName = $_POST['tblName'];
$values = $_POST['values'];

$conn = OpenConnection();

$newRowCmds = array("new row");
foreach ($newRowCmds as $val) {
    if ($val == $cmd) {
        newRow($conn, $tblName, $values);
        echo "Successfully added new row";
        die();
    }
} 

echo "Failed Query";

?>