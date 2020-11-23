<?php

function readTable($database, $tableName) {
	$serverName = "Frankenstein\\ASN_SQL"; //serverName\instanceName

	// Since UID and PWD are not specified in the $connectionInfo array,
	// The connection will be attempted using Windows Authentication.
	$connectionInfo = array( "Database"=> $database);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	
	if( !$conn ) {
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}

	$sql = "SELECT * FROM ".$tableName."";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
	$count = 0;
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
		$contents[$count] = $row;
		$count++;
    }

	sqlsrv_free_stmt( $stmt);
	return $contents;
}

function updateTable($database, $tableName, $change, $column, $targetId) {
	$serverName = "Frankenstein\\ASN_SQL"; //serverName\instanceName

	// Since UID and PWD are not specified in the $connectionInfo array,
	// The connection will be attempted using Windows Authentication.
	$connectionInfo = array( "Database"=> $database);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	
	if( !$conn ) {
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}

	$sql = 'UPDATE '.$tableName.' SET '.$change.' WHERE '.$column.'='.$targetId;
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

	sqlsrv_free_stmt( $stmt);
}

function newRow($database, $tableName, $values) {
	$serverName = "Frankenstein\\ASN_SQL"; //serverName\instanceName

	// Since UID and PWD are not specified in the $connectionInfo array,
	// The connection will be attempted using Windows Authentication.
	$connectionInfo = array( "Database"=> $database);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	
	if( !$conn ) {
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}

	$keys = array_keys($values);
	$sql = 'INSERT INTO '.$tableName.' (';
	for ($x = 0; $x < (sizeof($values)-1); $x++) {
		$sql = $sql.' '.$keys[$x].',';
	} 
	$sql = $sql.' '.$keys[sizeof($values) - 1].') VALUES (';
	for ($x = 0; $x < (sizeof($values)-1); $x++) {
		$sql = $sql.' '.$values[$keys[$x]].',';
	} 
	$sql = $sql.' '.$values[$keys[sizeof($values)-1]].')';
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

	sqlsrv_free_stmt( $stmt);
}

function deleteRow($database, $tableName, $target, $value) {
	$serverName = "Frankenstein\\ASN_SQL"; //serverName\instanceName

	// Since UID and PWD are not specified in the $connectionInfo array,
	// The connection will be attempted using Windows Authentication.
	$connectionInfo = array( "Database"=> $database);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	
	if( !$conn ) {
		echo "Connection could not be established.<br />";
		die( print_r( sqlsrv_errors(), true));
	}

	$sql = 'DELETE FROM '.$tableName.' WHERE '.$target.'='.$values;
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

	sqlsrv_free_stmt( $stmt);
}

?>
