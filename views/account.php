<?php
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/header.php';
function displayPurchases () {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBFunctions.php';
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
EOD;
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/templates/footer.php';
?>
