<?php
$connectionFailure = "Connection could not be established.<br/>";
$statementFailure = "A statement could not be made.<br/>";

function tableExists($conn, $tableName) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	$sql = "DESCRIBE ".$tableName.";";
	$stmt = $conn->query($sql);
	if( $stmt === false) {
		echo $tableName." does not exist.<br/>";
        return false;
    }
	return true;
}

function newTable($conn, $tableName, $values) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}
	if (tableExists($conn, $tableName)) {
		return false;
	}

	$sql = "CREATE TABLE ".$tableName." (".$values.");";
    $stmt = $conn->query($sql);
    if( $stmt === false) {
		die($statementFailure);
    }
	return true;
}

function getTables($conn) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	$sql = "SHOW TABLES;";
    $stmt = $conn->query($sql);
    if( $stmt === false) {
		die($statementFailure);
	}
	$tables = array();
	while($table = $stmt->fetch_array()) { // go through each row that was returned in $result
		array_push($tables, $table[0]);    // print the table that was returned on that row.
	}
	return $tables;
}

function getColumns($conn, $tblName) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ".$tblName.";";
    $stmt = $conn->query($sql);
    if( $stmt === false) {
		die($statementFailure);
	}
	$tables = array();
	while($table = $stmt->fetch_array()) { // go through each row that was returned in $result
		array_push($tables, $table[0]);    // print the table that was returned on that row.
	}
	return $tables;
}

function readTable($conn, $tableName) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	$sql = "SELECT * FROM ".$tableName."";
    $stmt = $conn->query($sql );
    if ($stmt === false) {
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
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	$sql = 'UPDATE '.$tableName.' SET '.$change.' WHERE '.$column.'='.$targetId;
    $stmt = $conn -> query($sql);
    if ($stmt === false) {
        die($statementFailure);
    }
}

function newRow($conn, $tableName, $values) {
	global $connectionFailure, $statementFailure;
	if( !$conn ) {
		die($connectionFailure);
	}

	$sql = 'INSERT INTO '.$tableName.' VALUES (';

	for ($x = 0; $x < (sizeof($values)-1); $x++) {
		$sql = $sql." '".$values[$x]."',";
	}
	$sql = $sql." '".$values[sizeof($values)-1]."');";

	echo $sql; // remove this later

    $stmt = $conn -> query($sql);
    if( $stmt === false) {
        die($statementFailure);
    }
}

function deleteRow($conn, $tableName, $target, $values) {
	global $connectionFailure, $statementFailure;
	if( !$conn ) {
		die($connectionFailure);
	}

	$sql = 'DELETE FROM '.$tableName.' WHERE '.$target.'='.$values;
    $stmt = $conn->query($sql );
    if( $stmt === false) {
        die($statementFailure);
    }
}

?>
