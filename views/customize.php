<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
echo "<h1>Customize</h1>";
include_once $_SERVER['DOCUMENT_ROOT'] . "/671Project/tools/DBFunctions.php";
$baseProduct = getBaseProduct($_POST['base_id'])[0];
$baseSpecs = getbaseProductSpecs($_POST['base_id'])[0];
echo <<<EOD
	<form class = 'formTable' action = '$actionPage' method = 'post'>
		<div class = "divHeader">
			<div class = "divCell">Memory</div>
			<div class = "divCell">Price</div>
			<div class = "divCell"></div>
			<div class = "divCell">Storage</div>
			<div class = "divCell">Type</div>
			<div class = "divCell">Price</div>
			<div class = "divCell"></div>
			<div class = "divCell">OS</div>
			<div class = "divCell">Price</div>
			<div class = "divCell"></div>
		</div>
		<div class = "divRow">
			<div class = "divCell">
				{$baseSpecs['memory_size']} gb
			</div>
			<div class = "divCell">
				(base)
			</div>
			<div class = "divCell">
				<input type = 'radio' name = 'memory_id' value = '{$baseSpecs['memory_id']}' checked>
			</div>
			<div class = "divCell">
				{$baseSpecs['storage_size']} gb
			</div>
			<div class = "divCell">
				{$baseSpecs['storage_type']}
			</div>
			<div class = "divCell">
				(base)
			</div>
			<div class = "divCell">
				<input type = 'radio' name = 'storage_id' value = '{$baseSpecs['storage_id']}' checked>
			</div>
			<div class = "divCell">
				{$baseSpecs['os_name']}
			</div>
			<div class = "divCell">
				(base)
			</div>
			<div class = "divCell">
				<input type = 'radio' name = 'os_name' value = '{$baseSpecs['os_name']}' checked>
			</div>
		</div>
EOD;
$processorId = $baseProduct['processor_id'];
$availableMemory = processorToAvailableMemory($processorId);
$availableStorage = processorToAvailableStorage($processorId);
$availableOs = processorToAvailableOS($processorId);
$itemRows = array_map(NULL, $availableMemory, $availableStorage, $availableOs);
foreach($itemRows as $row) {
	$mem = $row[0];
	$stor = $row[1];
	$os = $row[2];
	$memPrice = number_format($mem['price'] - $baseSpecs['memory_price'], 2);
	$storPrice = number_format($stor['price'] - $baseSpecs['storage_price'], 2);
	$osPrice = number_format($os['price'] - $baseSpecs['os_price'], 2);
	echo <<<EOD
		<div class = 'divRow'>
			<div class = 'divCell'>
				{$mem['size']} gb
			</div>
			<div class = 'divCell'>
				$memPrice
			</div>
			<div class = 'divCell'>
				<input type = 'radio' name = 'memory_id' value = '{$mem['memory_id']}'>
			</div>
			<div class = 'divCell'>
				{$stor['size']} gb
			</div>
			<div class = 'divCell'>
				{$stor['type']}
			</div>
			<div class = 'divCell'>
				$storPrice
			</div>
			<div class = 'divCell'>
				<input type = 'radio' name = 'storage_id' value = '{$stor['storage_id']}'>
			</div>
			<div class = 'divCell'>
				{$os['name']}
			</div>
			<div class = 'divCell'>
				$osPrice
			</div>
			<div class = 'divCell'>
				<input type = 'radio' name = 'os_name' value = '{$os['os_name']}'>
			</div>
		</div>
	EOD;
}
echo <<<EOD
		<div class = "divRow">
			<input type = "submit" name = "purchase" value = "Purchase">
			<input type = "submit" name = "wishList" value = "Add to Wishlist">
		</div>
		<input type = "hidden" name = "base_id" value = "{$_POST['base_id']}">
	</form>
EOD;
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';                                                                                                                    
?>
