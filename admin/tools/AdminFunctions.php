<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/tools/DBConnect.php';
function loginAdmin ($_username, $_password) {
	$query = "SELECT * FROM ADMIN WHERE username = ? AND password = ?;";
	$result = preparedQuery ($query, [$_username, $_password]);
	return (!$result) ? NULL : $result[0];
}
function preparedQuery ($_query, $_arguments) {
	try {
		$session = GETPDO();
		if ($session == NULL) { return NULL; }
		$result = $session->prepare($_query);
		$result->execute($_arguments);
	}
	catch (Exception $ex) {
		return NULL;
	}
	if (!$result) { return NULL; }
	return $result->fetchAll();
}
?>
