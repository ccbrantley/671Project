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
?>
