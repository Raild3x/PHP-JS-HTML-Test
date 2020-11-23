<?php
include 'dbConnection.php';
include 'sqlCommands.php';

// Read data sent over post

$tblName = $_POST['tblName'];
$values = $_POST['values'];

if (isset($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
}
if (isset($_POST['tblName'])) {
    $tblName = $_POST['tblName'];
}
if (isset($_POST['values'])) {
    $values = explode(" ",$_POST['values']);
}


$conn = OpenConnection();

$newRowCmds = array("new row");
foreach ($newRowCmds as $val) {
    if ($val == $cmd) {
        newRow($conn, $tblName, $values);
        echo "Successfully added new row";
    }
} 

CloseConnection($conn);

echo "Failed Query";

?>