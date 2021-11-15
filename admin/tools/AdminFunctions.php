<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
function loginAdmin ($_username, $_password) {
	$query = "SELECT * FROM ADMIN WHERE username = ? AND password = ?;";
	$result = preparedQuery ($query, [$_username, $_password]);
	return (!$result) ? NULL : $result[0];
}
function preparedQuery ($_query, $_arguments, $rowCount = False) {
	try {
		$session = GETPDO();
		if ($session == NULL) { return NULL; }
		$result = $session->prepare($_query);
		$result->execute($_arguments);
	}
	catch (Exception $ex) {
		echo $ex->getMessage();
		return NULL;
	}
	if (!$result) { return NULL; }
	if ($rowCount) { return $result->rowCount(); }
	return $result->fetchAll();
}
function regularQuery ($_query, $_rowCount = False) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
	try {
		$session = GETPDO();
		if ($session == NULL) { return $session; }
		$result = $session->query($_query);
	}
	catch (Exception $ex) {
		echo $ex->getMessage();
		return NULL;
	}
	if (!$result) { return NULL; }
	if ($_rowCount) { return $result->rowCount(); }
	return $result->fetchAll();
}
function processPurchase ($_purchaseId, $_processorId, $_memoryId, $_storageId) {
	try {
		$session = GETPDO();
		if ($session == NULL) { return $session; }
		$session->beginTransaction();
		$result = regularQuery("SELECT qty FROM PROCESSOR WHERE processor_id = $_processorId;");
		$processorQty = $result[0]['qty'] - 1;
		if ($processorQty < 0) { throw new Exception('Product not available.'); }
		$result = regularQuery("UPDATE PROCESSOR set qty = $processorQty WHERE processor_id = $_processorId;", True);
		if (!$result) { throw new Exception('Product not available.'); }
		$result = regularQuery("SELECT qty FROM MEMORY WHERE memory_id = $_memoryId;");
		$memoryQty = $result[0]['qty'] - 1;
		if ($memoryQty < 0) { throw new Exception('Product not available.'); }
		$result = regularQuery("UPDATE MEMORY set qty = $memoryQty WHERE memory_id = $_memoryId;", True);
		if (!$result) { throw new Exception('Product not available.'); }
		$result = regularQuery("SELECT qty FROM STORAGE WHERE storage_id = $_storageId;");
		$storageQty = $result[0]['qty'] - 1;
		if ($storageQty < 0 ) { throw new Exception('Product not available.'); }
		$result = regularQuery("UPDATE STORAGE set qty = $storageQty WHERE storage_id = $_storageId;");
		if (!regularQuery("UPDATE PURCHASE set status = 'processed' WHERE purchase_id = $_purchaseId;", True)) {
			throw new Exception('Product not available.');
		}
		$session->commit();
	}
	catch (Exception $ex) {
		$session->rollback();
		return NULL;
	}
	return True;
}
?>
