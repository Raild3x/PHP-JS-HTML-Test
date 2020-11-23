<?php
$connectionFailure = "Connection could not be established.<br/>";
$statementFailure = "A statement could not be made.<br/>";

function tableExists($conn, $tableName) {
	global $connectionFailure, $statementFailure;
	if( !$conn ) {
		echo $connectionFailure;
		return false;
	}

	$sql = "DESCRIBE ".$tableName.";";
	$stmt = $conn->query($sql);
	if( $stmt === false) {
		echo $statementFailure;
        return false;
    }
	echo $tableName." exists.";
	return true;
}

function newTable($conn, $tableName, $values) {
	global $connectionFailure, $statementFailure;
	if( !$conn ) {
		echo "Connection could not be established.<br/>";
		return false;
	}

	$sql = "CREATE TABLE ".$tableName." (".$values.");";
    $stmt = $conn->query($sql);
    if( $stmt === false) {
		echo $statementFailure;
        return false;
    }
	return true;
}

function readTable($conn, $tableName) {
	global $connectionFailure, $statementFailure;
	if( !$conn ) {
		die($connectionFailure)
	}

	$sql = "SELECT * FROM ".$tableName."";
    $stmt = $conn->query($sql );
    if( $stmt === false) {
        die($statementFailure);
    }
	$count = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
		$contents[$count] = $row;
		$count++;
    }

	//sqlsrv_free_stmt( $stmt);
	return $contents;
}

function updateTable($conn, $tableName, $change, $column, $targetId) {
	if( !$conn ) {
		echo "Connection could not be established.<br /> ";
		die( print_r( sqlsrv_errors(), true));
	}

	$sql = 'UPDATE '.$tableName.' SET '.$change.' WHERE '.$column.'='.$targetId;
    $stmt = $conn->query($sql );
    if( $stmt === false) {
        die("Statement is false. ");
    }

	//sqlsrv_free_stmt( $stmt);
}

function newRow($conn, $tableName, $values) {
	if( !$conn ) {
		echo "Connection could not be established.<br />";
		die();
	}

	$sql = 'INSERT INTO '.$tableName.' VALUES (';

	for ($x = 0; $x < (sizeof($values)-1); $x++) {
		$sql = $sql." '".$values[$x]."',";
	}
	$sql = $sql." '".$values[sizeof($values)-1]."');";

	echo $sql; // remove this later

    $stmt = $conn -> query($sql);
    if( $stmt === false) {
        die("Failed to create statement: ");
    }
}

function deleteRow($conn, $tableName, $target, $values) {
	if( !$conn ) {
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}

	$sql = 'DELETE FROM '.$tableName.' WHERE '.$target.'='.$values;
    $stmt = $conn->query($sql );
    if( $stmt === false) {
        die("Statement is false.");
    }

	//sqlsrv_free_stmt( $stmt);
}

?>
