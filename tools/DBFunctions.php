<?php
function preparedQuery ($_query, $_arrayOfValues) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
	try {
		$session = GETPDO();
		if ($session == NULL) {
			return $session;
		}
		$result = $session->prepare($_query);
		$result->execute($_arrayOfValues);
	}
	catch (Exception $ex) {
		return NULL;
	}
	return $result;
}
function regularQuery ($_query) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
	try {
		$session = GETPDO();
		if ($session == NULL) {
			return $session;
		}
		$result = $session->query($_query);
	}
	catch (Exception $ex) {
		return NULL;
	}
	return $result;
}
function uniqueUserName ($_userName) {
	$query = "
			SELECT *
			FROM CUSTOMER
			WHERE username = ?
			;
	";
	$result = preparedQuery($query, array($_userName));
	if ($result->fetchAll()) {
		return False;
	}
	return True;
}
function registerUser ($_userInfo) {
	$query ="
		INSERT INTO CUSTOMER 
		(username, password, f_name, l_name,
		 street, city, zip, state,
		 country, credit_card)
		VALUES
		(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		;
	";
	return preparedQuery($query, $_userInfo);
}
function loginUser ($_userInfo) {
	$query = "
		SELECT *
		FROM CUSTOMER
		WHERE username = ? AND
		password = ?
		;
	";
	$rows = preparedQuery($query, $_userInfo)->fetch();
	return (!$rows) ? NULL : $rows;
}
function getBaseProducts () {
	$query = "
		SELECT PROCESSOR.name AS 'processor_name', STORAGE.size AS 'storage_size',
		STORAGE.type AS 'storage_type', O_SYSTEM.name AS 'operating_system',
		MEMORY.size AS 'memory_size', BASE_SYSTEM.*
		FROM BASE_SYSTEM, PROCESSOR, MEMORY, STORAGE, O_SYSTEM
		WHERE BASE_SYSTEM.processor_id = PROCESSOR.processor_id AND
		BASE_SYSTEM.memory_id = MEMORY.memory_id AND
		BASE_SYSTEM.storage_id = STORAGE.storage_id AND
		BASE_SYSTEM.os_name = O_SYSTEM.name
		;
	";
	return regularQuery($query)->fetchAll();
}
function getBaseProduct ($_baseId) {
	$query = "
		SELECT *
		FROM BASE_SYSTEM
		WHERE base_id = ?
		;
	";
	return preparedQuery($query, array($_baseId))->fetchAll();
}
function getbaseProductSpecs ($_baseId) {
	$query = "
		SELECT
		BASE_SYSTEM.price AS base_price,
		MEMORY.memory_id,
		MEMORY.size AS memory_size,
		MEMORY.price AS memory_price,
		STORAGE.storage_id,
		STORAGE.size AS storage_size,
		STORAGE.type AS storage_type,
		STORAGE.price AS storage_price,
		O_SYSTEM.name AS os_name,
		O_SYSTEM.price AS os_price
		FROM BASE_SYSTEM, PROCESSOR, MEMORY, STORAGE, O_SYSTEM
		WHERE BASE_SYSTEM.processor_id = PROCESSOR.processor_id AND
		BASE_SYSTEM.memory_id = MEMORY.memory_id AND
		BASE_SYSTEM.storage_id = STORAGE.storage_id AND
		BASE_SYSTEM.os_name = O_SYSTEM.name AND
		BASE_SYSTEM.base_id = ?
		;
	";
	return preparedQuery($query, array($_baseId))->fetchAll();
}
function searchBaseProducts () {
	$query = <<<EOD
		SELECT PROCESSOR.name AS 'processor_name', STORAGE.size AS 'storage_size',
		STORAGE.type AS 'storage_type', O_SYSTEM.name AS 'operating_system',
		MEMORY.size AS 'memory_size', BASE_SYSTEM.*
		FROM BASE_SYSTEM, PROCESSOR, MEMORY, STORAGE, O_SYSTEM
		WHERE BASE_SYSTEM.processor_id = PROCESSOR.processor_id AND
		BASE_SYSTEM.memory_id = MEMORY.memory_id AND
		BASE_SYSTEM.storage_id = STORAGE.storage_id AND
		BASE_SYSTEM.os_name = O_SYSTEM.name
	EOD;
	$argumentArray = array();
	if (!empty($_GET['maxPrice'])) {
		$argumentArray[] = $_GET['maxPrice'];
		$query .= "\nAND BASE_SYSTEM.price <= ?";
	}
	if (!empty($_GET['maxWeight'])) {
		$argumentArray[] = $_GET['maxWeight'];
		$query .= "\nAND BASE_SYSTEM.weight <= ?";
	}
	if (!empty($_GET['size'])) {
		$argumentArray[] = $_GET['size'];
		$query .= "\nAND BASE_SYSTEM.size = ?";
	}
	$typeCount = 0;
	if (!empty($_GET['laptops'])) {
		$argumentArray[] = 'laptop';
		$typeCount += 1;
	}
	if (!empty($_GET['tablets'])) {
		$argumentArray[] = 'tablet';
		$typeCount += 1;
	}
	if (!empty($_GET['hybrid'] !== NULL)) {
		$argumentArray[] = 'hybrid';
		$typeCount += 1;
	}
	if ($typeCount > 0) {
		$query .= "\nAND BASE_SYSTEM.type IN (";
		for ($i = 0; $i < $typeCount; $i++) {
			if ($i + 1 == $typeCount) {
				$query .= "?)";
			}
			else {
				$query .= "?, ";
			}
		}
	}
	$query .= "\n;";
	return preparedQuery($query, $argumentArray)->fetchAll();
}
function baseIdToProcessorId ($_baseId) {
	$query = "
		SELECT processor_id
		FROM BASE_SYSTEM
		WHERE base_id = ?
		;
	";
	return preparedQuery($query, array($_baseId))->fetchAll();
}
function appendQueryClauseIn ($_baseQuery, $_array) {
	if (sizeof($_array) == 0) {
		$_baseQuery .= "NULL);";
		return $_baseQuery;
	}
	for ($i = 0; $i < sizeof($_array); $i++) {
		if (($i + 1) == sizeof($_array)) {
			$_baseQuery .= "?)";
		}
		else {
			$_baseQuery .= "?, ";
		}
	}
	return $_baseQuery;
}
function processorToAvailableMemory ($_processorId) {
	$query = "
		SELECT memory_id
		FROM PROCESSOR_MEMORY
		WHERE processor_id = ?
		;
	";
	$results = preparedQuery($query, array($_processorId))->fetchAll();
	$memoryIds = array();
	foreach ($results as $row) {
		$memoryIds[] = $row['memory_id'];
	}
	$query = "
		SELECT *
		FROM MEMORY
		WHERE memory_id in (
	";
	$query = appendQueryClauseIn($query, $memoryIds) . ";";
	$result = preparedQuery($query, $memoryIds);
	if (!$result) {
		return NULL;
	}
	return $result->fetchAll();
}
function processorToAvailableStorage ($_processorId) {
	$query = "
		SELECT storage_id
		FROM PROCESSOR_STORAGE
		WHERE processor_id = ?
		;
	";
	$results = preparedQuery($query, array($_processorId))->fetchAll();
	$storageIds = array();
	foreach ($results as $row) {
		$storageIds[] = $row['storage_id'];
	}
	$query = "
		SELECT *
		FROM STORAGE
		WHERE storage_id in (
	";
	$query = appendQueryClauseIn($query, $storageIds) . ";";
	$result = preparedQuery($query, $storageIds);
	if (!$result) {
		return NULL;
	}
	return $result->fetchAll();
}
function processorToAvailableOS ($_processorId) {
	$query = "
		SELECT *
		FROM PROCESSOR_O_SYSTEM
		WHERE processor_id = ?
		;
	";
	$result = preparedQuery($query, array($_processorId))->fetchAll();
	$rowIds = array();
	foreach ($result as $row) {
		$rowIds[] = $row['os_name'];
	}
	$query = "
		SELECT *
		FROM O_SYSTEM
		WHERE name in (
	";
	$query = appendQueryClauseIn($query, $rowIds) . ";";
	$result = preparedQuery($query, $rowIds);
	if (!$result) {
		return NULL;
	}
	return $result->fetchAll();
}
function calculateCustomizationPrice ($_base_id, $_memory_id, $_storage_id, $_os_name) {
	$result = getbaseProductSpecs($_base_id);
	if (!$result) {
		return False;
	}
	$baseSpecs = $result[0];
	$query = "SELECT * FROM MEMORY WHERE memory_id = ?;";
	$result = preparedQuery($query, array($_memory_id));
	if (!$result) {
		return False;
	}
	$memoryPrice = $result->fetchAll()[0]['price'] - $baseSpecs['memory_price'];
	$query = "SELECT * FROM STORAGE WHERE storage_id = ?;";
	$result = preparedQuery($query, array($_storage_id));
	if (!$result) {
		return False;
	}
	$storagePrice = $result->fetchAll()[0]['price'] - $baseSpecs['storage_price'];
	$query = "SELECT * FROM O_SYSTEM WHERE name = ?;";
	$result = preparedQuery($query, array($_os_name));
	if (!$result) {
		return False;
	}
	$osPrice = $result->fetchAll()[0]['price'] - $baseSpecs['os_price'];
	$totalChange = abs($memoryPrice) + abs($storagePrice) + abs($osPrice);
	return number_format($baseSpecs['base_price'] - $totalChange, 2);
}
function productToPurchase ($_args) {
	array_push($_args, calculateCustomizationPrice($_args[1], $_args[2], $_args[3], $_args[4]));
	array_push($_args, 'unprocessed');
	array_push($_args, date("Y-m-d"));  
	$query = "
		INSERT INTO PURCHASE (user_id, base_id, memory_id,
		storage_id, os_name, price, status, date
		) VALUES
		(?, ?, ?, ?, ?, ?, ?, ?)
		;
	";
	$result = preparedQuery($query, $_args);
	if (!$result) {
		return False;
	}
	return True;
}
function productToWishList ($_arguments) {
	$query = "
		INSERT INTO WISHLIST (user_id, base_id, memory_id, storage_id, os_name) VALUES
		(?, ?, ?, ?, ?)
		;
	";
	$result = preparedQuery($query, $_arguments);
	if (!$result) {
		return False;
	}
	return True;
}
function getPurchases ($_userId) {
	$query = "
		SELECT * FROM PURCHASE WHERE user_id = ?;
	";
	$result = preparedQuery($query, array($_userId));
	return $result;
}
?>
