<?php

function readTable($conn, $tableName) {
	if( !$conn ) {
		echo "Connection could not be established.<br/>";
		die( print_r( sqlsrv_errors(), true));
	}

	$sql = "SELECT * FROM ".$tableName."";
    $stmt = $conn->query($sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
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
	/*$keys = array_keys($values);
	for ($x = 0; $x < (sizeof($values)-1); $x++) {
		$sql = $sql.' '.$keys[$x].',';
	} 
	$sql = $sql.' '.$keys[sizeof($values) - 1].') VALUES (';
	for ($x = 0; $x < (sizeof($values)-1); $x++) {
		$sql = $sql.' '.$values[$keys[$x]].',';
	} 
	$sql = $sql.' '.$values[$keys[sizeof($values)-1]].')';
	*/
	for ($x = 0; $x < (sizeof($values)-1); $x++) {
		$sql = $sql." '".$values[$x]."',";
	}
	$sql = $sql." '".$values[sizeof($values)-1]."');";
	echo $sql;
    $stmt = $conn -> query($sql);
    if( $stmt === false) {
        die("Failed to create statement: ");
    }

	//sqlsrv_free_stmt( $stmt);
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
