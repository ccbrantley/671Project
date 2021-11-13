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
function regularQuery ($_query) {
	include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
	try {
		$session = GETPDO();
		if ($session == NULL) { return $session; }
		$result = $session->query($_query);
	}
	catch (Exception $ex) {
		echo $_query;
		echo $ex->getMessage();
		return NULL;
	}
	if (!$result) { return NULL; }
	return $result->fetchAll();
}
?>
