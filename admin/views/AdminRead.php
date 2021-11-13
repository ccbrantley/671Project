<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/AdminFunctions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/DatabaseMap.php';
echo <<<EOD
<div>
	<form action = "/671Project/admin/views/AdminRead.php" method = "post">
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
	<h1>{$tables[$_POST['tableSelection']]['displayName']}</h1>
	<div class = "divTable">
		<div class = "divHeader">
	EOD;
	$attributes = $tables[$_POST['tableSelection']]["attributes"];
	foreach ($attributes as $attribute => $display) {
		echo "<div class = 'divCell'>$display</div>";
	}
	echo "</div>";
	foreach (regularQuery("SELECT * FROM {$tables[$_POST['tableSelection']]['tableName']};") as $row) {
		echo "<div class = 'divRow'>";
		foreach ($attributes as $attribute => $display) {
			echo "<div class = 'divCell'>{$row[$attribute]}</div>";
		}
		echo "</div>";
	}
	echo "</div>";
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
