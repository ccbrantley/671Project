<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/AdminFunctions.php';
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/DatabaseMap.php';
if (isset($_POST['adminDelete'])) {
	$keys = $tables[$_POST['tableSelection']]['keys'];
	$tableName = $tables[$_POST['tableSelection']]['tableName'];
	$query = "DELETE FROM $tableName WHERE ";
	$args = [];
	for ($i = 0; $i < sizeof($keys); $i++) {
		if (($i + 1) == sizeof($keys)) {
			$query .= "$keys[$i] = ?;";
		}
		else {
			$query .= "{$keys[$i]} = ? AND ";
		}
		$args[] = $_POST[$keys[$i]];
	}
	if (preparedQuery($query, $args, True)) {
		$_SESSION['delete_query_result'] = True;
	}
	else {
		$_SESSION['delete_query_result'] = False;
	}
	header("Location: /671Project/admin/views/AdminCRUDMessage.php");
}
echo <<<EOD
<div>
	<form action = "/671Project/admin/views/AdminDelete.php" method = "post">
		<label for = "tableSelection">Table:</label>
		<select name = "tableSelection" id = "tableSelection">
			<optgroup label = "User Options">
				<option value = "customer">Customers</option>
				<option value = "wishList">Wish Lists</option>
				<option value = "purchase">Purchases</option>
			</optgroup>
			<optgroup label = "Product Options">
				<option value = "baseSystem">Base System</option>
				<option value = "storage">Storage</option>
				<option value = "os">Operating System</option>
				<option value = "memory">Memory</option>
				<option value = "processor">Processor</option>
			</optgroup>
			<optgroup label = "Compatibility Options">
				<option value = "processorStorage">Processor-Storage</option>
				<option value = "processorOs">Processor-Os</option>
				<option value = "processorMemory">Processor-Memory</option>	
		</select>
		<input type="submit" name = "tableInput" value="Select">
	</form>
</div>
EOD;
if (isset($_POST['tableInput'])) {
	echo <<<EOD
	<div class = "loginDiv">
	<div class = "loginBorder">
	<h1>{$tables[$_POST['tableSelection']]['displayName']}</h1>
	<form method = "post" action = "/671Project/admin/views/AdminDelete.php">
		<div>
	EOD;
	$table = $tables[$_POST['tableSelection']];
	foreach ($table['keys'] as $key) {
		echo <<<EOD
			<p>
				<label for "$key">{$table['attributes'][$key]}:</label>
				<input type = "text" id = "$key" name = "$key" required>
			</p>
		EOD;
	}
	echo <<<EOD
		</div>
		<input type = "hidden" id = "tableSelection" name="tableSelection" value="{$_POST['tableSelection']}">
		<div>
			<input type = "submit" name = "adminDelete" value = "Delete">
		</div>
	</form>
	</div>
	</div>
	EOD;
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
