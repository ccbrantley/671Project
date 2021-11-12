<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
if (empty($_SESSION['user_id'])) { header("Location: /671Project/views/login.php"); }
include_once $_SERVER['DOCUMENT_ROOT'] . "/671Project/tools/DBFunctions.php";
if (isset($_POST['purchase'])) {
	if (productToPurchase(array($_SESSION['user_id'], $_POST['base_id'], 
								$_POST['memory_id'], $_POST['storage_id'],
								$_POST['os_name'])))
	{
		$_SESSION['purchase_status'] = True;
	}
	else {
		$_SESSION['purchase_status'] = False;
	}
	header("Location: /671Project/views/customizeMessage.php");
}
else if (isset($_POST['wishList'])) {
	if (productToWishList(array($_SESSION['user_id'], $_POST['base_id'],
								$_POST['memory_id'], $_POST['storage_id'],
								$_POST['os_name']))) 
	{
		$_SESSION['wishlist_status'] = True;
		
	}
	else {
		$_SESSION['wishlist_status'] = False;
	}
	header("Location: /671Project/views/customizeMessage.php");
}
$baseSpecs = getbaseProductSpecs($_POST['base_id'])[0];
echo <<<EOD
	<h1>Customize</h1>
	<form class = 'formTable' action = '/671Project/views/customize.php' method = 'post'>
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
			<div class = "divCell">{$baseSpecs['memory_size']} gb</div>
			<div class = "divCell">(base)</div>
			<div class = "divCell"><input type = 'radio' name = 'memory_id' value = '{$baseSpecs['memory_id']}' checked></div>
			<div class = "divCell">{$baseSpecs['storage_size']} gb</div>
			<div class = "divCell">{$baseSpecs['storage_type']}</div>
			<div class = "divCell">(base)</div>
			<div class = "divCell"><input type = 'radio' name = 'storage_id' value = '{$baseSpecs['storage_id']}' checked></div>
			<div class = "divCell">{$baseSpecs['os_name']}</div>
			<div class = "divCell">(base)</div>
			<div class = "divCell"><input type = 'radio' name = 'os_name' value = '{$baseSpecs['os_name']}' checked></div>
		</div>
EOD;
$processorId = preparedQuery("SELECT processor_id from BASE_SYSTEM WHERE base_id = ?;", array($_POST['base_id']))->fetchAll()[0]['processor_id'];
$availableMemory = processorToAvailableMemory($processorId);
$availableStorage = processorToAvailableStorage($processorId);
$availableOs = processorToAvailableOS($processorId);
foreach(array_map(NULL, $availableMemory, $availableStorage, $availableOs) as $row) {
	$mem = $row[0];
	$stor = $row[1];
	$os = $row[2];
	$memPrice = number_format($mem['price'] - $baseSpecs['memory_price'], 2);
	$storPrice = number_format($stor['price'] - $baseSpecs['storage_price'], 2);
	$osPrice = number_format($os['price'] - $baseSpecs['os_price'], 2);
	echo <<<EOD
		<div class = 'divRow'>
			<div class = 'divCell'>{$mem['size']} gb</div>
			<div class = 'divCell'>$memPrice</div>
			<div class = 'divCell'><input type = 'radio' name = 'memory_id' value = '{$mem['memory_id']}'></div>
			<div class = 'divCell'>{$stor['size']} gb</div>
			<div class = 'divCell'>{$stor['type']}</div>
			<div class = 'divCell'>$storPrice</div>
			<div class = 'divCell'><input type = 'radio' name = 'storage_id' value = '{$stor['storage_id']}'></div>
			<div class = 'divCell'>{$os['name']}</div>
			<div class = 'divCell'>$osPrice</div>
			<div class = 'divCell'><input type = 'radio' name = 'os_name' value = '{$os['name']}'></div>
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
