<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/AdminFunctions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/tools/DatabaseMap.php';
$resultMessage = NULL;
if (isset($_POST['purchaseSubmit'])) {
	if (!empty($_POST['purchaseId'])) {
		$result = preparedQuery("SELECT * FROM PURCHASE WHERE purchase_id = ?;", array($_POST['purchaseId']))[0];
		if ($result) {
			if ($result['status'] == 'processed') {
				$resultMessage = "<p class = 'failedText'>This purchase has already been processed.</p>";
			}
			else {		
				$processorId = regularQuery("SELECT processor_id FROM BASE_SYSTEM WHERE base_id = {$result['base_id']};")[0]['processor_id'];
				if (processPurchase($result['purchase_id'], $processorId, $result['memory_id'], $result['storage_id'])) {
					$_SESSION['process_purchase_result'] = True;
					echo "here";
				}
				else {
					$_SESSION['process_purchase_result'] = False;
				}
				header("Location: /671Project/admin/views/AdminCRUDMessage.php");
			}
		}
		else {
			$resultMessage = "<p class = 'failedText'>Invalid purchase id.</p>";
		}
	}
	 else {
	 	$resultMessage = "<p class = 'failedText'>Please enter a purchase id.</p>";
	 }
}

echo <<<EOD
<h1>Purchases</h1>
<div class = "divTable">
	<div class = "divHeader">	
EOD;
foreach ($tables['purchase']['attributes'] as $key => $value) {
	echo "<div class = 'divCell'>$value</div>";
}
echo "</div>";
$result = regularQuery("SELECT * FROM PURCHASE WHERE status = 'unprocessed';");
foreach ($result as $row) {
	echo "<div class = 'divRow'>";
	foreach ($tables['purchase']['attributes'] as $key => $value) {
		echo "<div class = 'divCell'>{$row[$key]}</div>";
	}
	echo "</div>";
}
echo "</div>";
echo <<<EOD
<div class = "loginDiv">
	<div class = "loginBorder">
		<h3>Process Purchase</h3>
		<form method = "post" action = "/671Project/admin/views/AdminProcessPurchase.php">
			<div>
				<label for = "purchaseId">Purchase ID:</label>
				<input type = "text" id = "purchaseId" name = "purchaseId">
			</div>
			<div>
				<input type = "submit" name = "purchaseSubmit" value = "Process">
			</div>
		</form>
	</div>
</div>
EOD;
if ($resultMessage) { echo $resultMessage; }
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
