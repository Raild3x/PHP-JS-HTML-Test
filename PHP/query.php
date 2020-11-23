<?php
include 'dbConnection.php';
include 'sqlCommands.php';

// Read data sent over post
$cmd = $_POST['cmd'];
$tblName = $_POST['tblName'];
$values = $_POST['values'];

$conn = OpenConnection();

$newRowCmds = array("new row");
for ($i = 0; $i < (sizeof($newRowCmds)-1); $i++) {
    if ($newRowCmds[$i] === $cmd) {
        newRow($conn, $tblName, $values);
        echo "Successfully added new row"
        break;
    }
} 

echo "Failed Query";

?>