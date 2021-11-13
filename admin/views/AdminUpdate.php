<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/AdminFunctions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/DatabaseMap.php';
if (isset($_POST['adminUpdate'])) {
	$tableName = $tables[$_POST['tableSelection']]['tableName'];
	$keys = $tables[$_POST['tableSelection']]['keys'];
	$whereValue = [];
	$where = "";
	for ($i = 0; $i < sizeof($keys); $i++) {
		$where .= "$keys[$i] = ?";
		$whereValue[] = $_POST["id_{$keys[$i]}"];
		if (($i + 1) < sizeof($keys)) {
			$where .= " AND ";
		}
	}
	$attributes = $tables[$_POST['tableSelection']]['attributes'];
	$setValue = [];
	$set = "";
	foreach ($attributes as $attribute => $display) {
		if (!empty($_POST[$attribute])) {
			$setValue[] = $_POST[$attribute];
			$set .= "$attribute = ?, ";
		}
	}
	if ($set) {
		
		$set = substr($set, 0, -2);
		$query = "UPDATE $tableName SET $set WHERE  $where;";
		$queryArgs = array_merge($setValue, $whereValue);
		if (preparedQuery($query, $queryArgs, True)) {
			$_SESSION['update_query_result'] = True;
		}
		else {
			$_SESSION['update_query_result'] = False;
		}
		header("Location: /671Project/admin/views/AdminCRUDMessage.php");
	}
}
echo <<<EOD
<div>
	<form action = "/671Project/admin/views/AdminUpdate.php" method = "post">
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
	
	<form method = "post" action = "/671Project/admin/views/AdminUpdate.php">
		<h3>Identifiers</h3>
		<div>
	EOD;
	$table = $tables[$_POST['tableSelection']];
	foreach ($table['keys'] as $key) {
		echo <<<EOD
			<p>
				<label for "id_$key">{$table['attributes'][$key]}:</label>
				<input type = "text" id = "id_$key" name = "id_$key" required>
			</p>
		EOD;
	}
	echo "</div><h3>Updates</h3><div>";
	foreach ($table['attributes'] as $attribute => $display) {
		echo <<<EOD
			<p>
				<label for "$attribute">{$display}:</label>
				<input type = "text" id = "$attribute" name = "$attribute">
			</p>
		EOD;
	}
	echo <<<EOD
		</div>
		<input type = "hidden" id = "tableSelection" name="tableSelection" value="{$_POST['tableSelection']}">
		<div>
			<input type = "submit" name = "adminUpdate" value = "Update">
		</div>
	</form>
	</div>
	</div>
	EOD;
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
