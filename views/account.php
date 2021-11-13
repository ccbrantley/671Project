<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBFunctions.php';
if (isset($_POST['wishListPurchase'])) {
	$item = preparedQuery("SELECT * FROM WISHLIST WHERE wishlist_id = ?;", array($_POST['wishlist_id']));
	$item = $item->fetchAll()[0];
	$result = preparedQuery("DELETE FROM WISHLIST WHERE wishlist_id = ?;", array($item['wishlist_id']));
	$result = productToPurchase(array($_SESSION['user_id'], $item['base_id'], $item['memory_id'],
							$item['storage_id'], $item['os_name']));
	if (!$result) {
		$_SESSION['purchaseStatus'] = False;
	}
	else {
		$_SESSION['purchaseStatus'] = True;
	}
	header("Location: /671Project/views/purchase.php");
}
function displayPurchases () {
	$purchases = getPurchases($_SESSION['user_id']);
	if (!$purchases) {
		return;
	}
	$purchases = $purchases->fetchAll();
	foreach ($purchases as $purchase) {
		$base_system = preparedQuery("SELECT * FROM BASE_SYSTEM WHERE base_id = ?;", array($purchase['base_id']));
		$base_system = $base_system->fetchAll()[0];
		$processor = preparedQuery("SELECT * FROM PROCESSOR WHERE processor_id = ?;", array($base_system['processor_id']));
		$processor = $processor->fetchAll()[0];
		$memory = preparedQuery("SELECT * FROM MEMORY WHERE memory_id = ?;", array($purchase['memory_id']));
		$memory = $memory->fetchAll()[0];
		$storage = preparedQuery("SELECT * FROM STORAGE WHERE storage_id = ?;", array($purchase['storage_id']));
		$storage = $storage->fetchAll()[0];
		$os = preparedQuery("SELECT * FROM O_SYSTEM WHERE name = ?;", array($purchase['os_name']));
		$os = $os->fetchAll()[0];
		$base_system['weight'] = intval($base_system['weight']);
		echo <<<EOD
			<div class = 'divTableRow'>
				<div class = 'divTableCell'>{$processor['name']}</div>
				<div class = 'divTableCell'>{$memory['size']} gb</div>
				<div class = 'divTableCell'>{$storage['size']} gb {$storage['type']}</div>
				<div class = 'divTableCell'>{$os['name']}</div>
				<div class = 'divTableCell'>
					<ul>
						<li>{$base_system['weight']} grams</li>
						<li>{$base_system['size']} in</li>
						<li>{$base_system['type']}</li>
					</ul>
				</div>
				<div class = 'divTableCell'>{$purchase['price']}</div>
				<div class = 'divTableCell'>{$purchase['date']}</div>
				<div class = 'divTableCell'>{$purchase['status']}</div>
			</div>
		EOD;
	}
}
function displayWishlist () {
	$wishList = preparedQuery("SELECT * FROM WISHLIST WHERE user_id = ?;", array($_SESSION['user_id']));
	$table = "";
	foreach($wishList->fetchAll() as $item) {
		$base_system = preparedQuery("SELECT * FROM BASE_SYSTEM WHERE base_id = ?;", array($item['base_id']));
		$base_system = $base_system->fetchAll()[0];
		$proc = preparedQuery("SELECT * FROM PROCESSOR WHERE processor_id = ?;", array($base_system['processor_id']));
		$proc = $proc->fetchAll()[0];
		$mem = preparedQuery("SELECT * FROM MEMORY WHERE memory_id = ?;", array($item['memory_id']));
		$mem = $mem->fetchAll()[0];
		$stor = preparedQuery("SELECT * FROM STORAGE WHERE storage_id = ?;", array($item['storage_id']));
		$stor = $stor->fetchall()[0];
		$os = preparedQuery("SELECT * FROM O_SYSTEM WHERE name = ?;", array($item['os_name']));
		$os = $os->fetchAll()[0];
		$base_system['weight'] = intval($base_system['weight']);
		$table .="
			<div class = 'divTableRow'>
				<div class = 'divTableCell'>{$proc['name']}</div>
				<div class = 'divTableCell'>{$mem['size']} gb</div>
				<div class = 'divTableCell'>{$stor['size']} gb {$stor['type']}</div>
				<div class = 'divTableCell'>{$os['name']}</div>
				<div class = 'divTableCell'>
					<ul>
						<li>{$base_system['weight']} grams</li>
						<li>{$base_system['size']} in</li>
						<li>{$base_system['type']}</li>
					</ul>
				</div>
				<div class = 'divTableCell'>
					<input type = 'radio' name = 'wishlist_id' value = '{$item['wishlist_id']}'>
				</div>
			</div>
		";
	}
	return $table;
}
echo <<<EOD
<h1 class = "headerPadding">Purchases</h1>
<div class = "divTableHeight">
	<div class = 'divTable'>
		<div class = 'divTableHeader'>
			<div class = 'divTableCell'>Processor</div>
			<div class = 'divTableCell'>Memory</div>
			<div class = 'divTableCell'>Storage</div>
			<div class = 'divTableCell'>OS</div>
			<div class = 'divTableCell'>Specifications</div>
			<div class = 'divTableCell'>Price</div>
			<div class = 'divTableCell'>Date</div>
			<div class = 'divTableCell'>Status</div>
		</div>
EOD;
displayPurchases();
echo <<<EOD
	</div>
</div>
<h1 class = "headerPadding">Wishlist</h1>
<div class = "divTableHeight">
	<form class = 'formTable' action = '' method = 'post'>
		<div class = 'divTableHeader'>
			<div class = 'divTableCell'>Processor</div>
			<div class = 'divTableCell'>Memory</div>
			<div class = 'divTableCell'>Storage</div>
			<div class = 'divTableCell'>OS</div>
			<div class = 'divTableCell'>Specifications</div>
			<div class = 'divTableCell'>

EOD;
$table = displayWishList();
if ($table != NULL) {
	echo <<<EOD
				<input type = "submit" name = 'wishListPurchase' value = "Purchase">
			</div>
		</div>
		$table
	EOD;
}
else {
	echo <<<EOD
			</div>
	</div>
	EOD;
}
echo <<<EOD
	</form>
</div>
EOD;
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
