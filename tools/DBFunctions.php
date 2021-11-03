<?php
function uniqueUserName ($_userName) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
	try {
		$session = GETPDO();
		if ($session == NULL) {
			return $session;
		}
		$result = $session->prepare("
			SELECT *
			FROM CUSTOMER
			WHERE username = ?
			;
		");
		$result->execute([$_userName]);
	}
	catch (Exception $ex) {
		return NULL;
	}
	if ($result->fetchAll()) {
		return False;
	}
	return True;
}
function registerUser ($_userInfo) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
	try {
		$session = GETPDO();
		if ($session == NULL) {
			return $session;
		}
		$result = $session->prepare("
			INSERT INTO CUSTOMER 
			(username, password, f_name, l_name,
			 street, city, zip, state,
			 country, credit_card)
			VALUES
			(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
			;
		");
		$result->execute($_userInfo);
	}
	catch (Exception $ex) {
		return NULL;
	}
	return $result;
}
function loginUser ($_userInfo) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
	try {
		$session = GETPDO();
		if ($session == NULL) {
			return $session;
		}
		$result = $session->prepare("
			SELECT *
			FROM CUSTOMER
			WHERE username = ? AND
			password = ?
			;
		");
		$result->execute($_userInfo);
	}
	catch (Exception $ex) {
		return NULL;
	}
	$rows = $result->fetch();
	if (!$rows) {
		return NULL;
	}
	return $rows;
}

function getBaseProducts () {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
	try {
		$session = GETPDO();
		if ($session == NULL) {
			return $session;
		}
		$result = $session->query("
			SELECT PROCESSOR.name AS 'processor_name', STORAGE.size AS 'storage_size',
			STORAGE.type AS 'storage_type', O_SYSTEM.name AS 'operating_system',
			MEMORY.size AS 'memory_size', BASE_SYSTEM.*
			FROM BASE_SYSTEM, PROCESSOR, MEMORY, STORAGE, O_SYSTEM
			WHERE BASE_SYSTEM.processor_id = PROCESSOR.processor_id AND
			BASE_SYSTEM.memory_id = MEMORY.memory_id AND
			BASE_SYSTEM.storage_id = STORAGE.storage_id AND
			BASE_SYSTEM.os_name = O_SYSTEM.name
			;
		");
	}
	catch (Exception $ex) {
		return NULL;
	}
	return $result->fetchAll();
}
?>
