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
		//echo $tableName." does not exist.<br/>";
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
		die($statementFailure.$conn->error);
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
		die($statementFailure.$conn->error);
	}
	$tables = array();
	while($table = $stmt->fetch_array()) { // go through each row that was returned in $result
		array_push($tables, $table[0]);
	}
	return $tables;
}

function getColumns($conn, $tblName) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	$sql = "DESCRIBE ".$tblName.";"; //"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ".$tblName.";";
    $stmt = $conn->query($sql);
    if( $stmt === false) {
		die($statementFailure.$conn->error);
	}
	$cols = array();
	while($row = $stmt->fetch_array()) {
		$cols[$row['Field']] = $row['Type'];
	}
	return $cols;
}

function readTable($conn, $tableName, $columns) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	if ($columns == "all" || $columns == "") {
		$columns = "*";
	}

	$sql = "SELECT ".$columns." FROM ".$tableName.";";
    $stmt = $conn->query($sql);
    if ($stmt === false) {
        die($statementFailure.$conn->error);
    }
	
	$count = 0;
    while($row = $stmt->fetch_assoc()) {
		echo "| ";
		foreach ($row as $field => $value) {
			echo $field.": ".$value." | ";
		}
		$count++;
		echo "<hr>";
	}
	echo "Displaying ".$count." results from the ".$tableName." Table";
}

function select($conn, $tableName, $columns, $conditions) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	if ($columns == "all" || $columns == "") {
		$columns = "*";
	}

	$sql = "SELECT ".$columns." FROM ".$tableName." WHERE ".$conditions.";";
    $stmt = $conn->query($sql);
    if ($stmt === false) {
        die($statementFailure.$conn->error);
    }
	
	$count = 0;
    while($row = $stmt->fetch_assoc()) {
		echo "| ";
		foreach ($row as $field => $value) {
			echo $field.": ".$value." | ";
		}
		$count++;
		echo "<hr>";
	}
	echo "Displaying ".$count." results from the ".$tableName." Table";
}

function updateTable($conn, $tableName, $columns, $conditions) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}

	$sql = 'UPDATE '.$tableName.' SET '.$columns.' WHERE '.$conditions;
    $stmt = $conn -> query($sql);
    if ($stmt === false) {
        die($statementFailure.$conn->error);
	}

	echo "Successfully updated results from the ".$tableName." Table<hr>";
	select($conn, $tableName, "*", $conditions);
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

	//echo $sql; // remove this later

    $stmt = $conn -> query($sql);
    if( $stmt === false) {
        die("newRow: ".$statementFailure.$conn->error);
	}
	//echo "</br> New row successfully added to ".$tableName;
}

function deleteRow($conn, $tableName, $condition) {
	global $connectionFailure, $statementFailure;
	if( !$conn ) {
		die($connectionFailure);
	}

	$sql = 'DELETE FROM '.$tableName.' WHERE '.$condition;
    $stmt = $conn->query($sql );
    if( $stmt === false) {
        die($statementFailure);
	}
	echo "Successfully deleted rows in the table ".$tableName." where ".$condition;
}

function dropTable($conn, $tableName) {
	global $connectionFailure, $statementFailure;
	if (!$conn) {
		die($connectionFailure);
	}
	if (!tableExists($conn, $tableName)) {
		return;
	}

	$sql = 'DROP TABLE '.$tableName;
    $stmt = $conn->query($sql);
    if( $stmt === false) {
        die($statementFailure.$conn->error);
    }
}

function getRandom($conn, $table, $column) {
	global $connectionFailure, $statementFailure;
	if( !$conn ) {
		die($connectionFailure);
	}

	$sql = 'SELECT '.$column." FROM ".$table." ORDER BY RAND() LIMIT 1";
	$stmt = $conn->query($sql);
	//echo " | Random for ".$table." : ".$column;
    if( $stmt === false) {
        die("GetRandom: ".$statementFailure.$conn->error);
	}
	
	return $stmt->fetch_array()[0];
}

function executeSQL($conn, $sql) {
	global $connectionFailure, $statementFailure;
	if( !$conn ) {
		die($connectionFailure);
	}
    $stmt = $conn->query($sql );
    if( $stmt === false) {
        die($statementFailure.$conn->error);
	}
}

?>
