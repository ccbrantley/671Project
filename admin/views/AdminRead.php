<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/AdminFunctions.php';
$tables = [
"customer" =>
	[
	"displayName" => "Customers",
	"tableName" => "CUSTOMER",
	"attributes" =>
		[
		'user_id',
		'username',
		'password',
		'f_name',
		'l_name',
		'street',
		'city',
		'zip',
		'state',
		'country',
		'credit_card',
		],
	],
"wishList" =>
	[
	"displayName" => "Wish Lists",
	"tableName" => "WISHLIST",
	"attributes" => 
		[
		'wishlist_id',
		'user_id',
		'base_id',
		'memory_id',
		'storage_id',
		'os_name',
		],
	],
"purchase" =>
	[
	"displayName" => "Purchases",
	"tableName" => "PURCHASE",
	"attributes" =>
		[
		'purchase_id',
		'user_id',
		'base_id',
		'memory_id',
		'storage_id',
		'os_name',
		'price',
		'status',
		'date',
		],
	],
"baseSystem" =>
	[
	"displayName" => "Base Systems",
	"tableName" => "BASE_SYSTEM",
	"attributes" =>
		[
		'base_id',
		'processor_id',
		'memory_id',
		'storage_id',
		'os_name',
		'weight',
		'size',
		'price',
		'type',
		],
	],
"storage" =>
	[
	"displayName" => "Storage",
	"tableName" => "STORAGE",
	"attributes" =>
		[
		'storage_id',
		'size',
		'qty',
		'price',
		'type',
		],
	],
"os" =>
	[
	"displayName" => "Operating Systems",
	"tableName" => "O_SYSTEM",
	"attributes" =>
		[
		'name',
		'price',
		],
	],
"memory" =>
	[
	"displayName" => "Memory",
	"tableName" => "MEMORY",
	"attributes" =>
		[
		'memory_id',
		'size',
		'qty',
		'price',
		],
	],
"processor" =>
	[
	"displayName" => "Processors",
	"tableName" => "PROCESSOR",
	"attributes" =>
		[
		'processor_id',
		'name',
		'qty',
		'price',
		],
	],
"processorStorage" =>
	[
	"displayName" => "Processor-Storage",
	"tableName" => "PROCESSOR_STORAGE",
	"attributes" =>
		[
		'processor_id',
		'storage_id',
		],
	],
"processorOs" =>
	[
	"displayName" => "Processor-OS",
	"tableName" => "PROCESSOR_O_SYSTEM",
	"attributes" =>
		[
		'processor_id',
		'os_name',
		],
	],
"processorMemory" =>
	[
	"displayName" => "Processor-Memory",
	"tableName" => "PROCESSOR_MEMORY",
	"attributes" =>
		[
		'processor_id',
		'memory_id',
		],
	],
];
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
	$tableName = $tables[$_POST['tableSelection']]["tableName"];
	
	echo <<<EOD
	<div class = "divTable">
		<div class = "divHeader">
	EOD;
	$attributes = $tables[$_POST['tableSelection']]["attributes"];
	foreach ($attributes as $attribute) {
		echo "<div class = 'divCell'>$attribute</div>";
	}
	echo "</div>";
	foreach (regularQuery("SELECT * FROM {$tableName};") as $row) {
		echo "<div class = 'divRow'>";
		foreach ($attributes as $attribute) {
			echo "<div class = 'divCell'>{$row[$attribute]}</div>";
		}
		echo "</div>";
	}
	echo "</div>";
}
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
