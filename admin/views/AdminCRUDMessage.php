<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminHeader.php';
$message = NULL;
if (isset($_SESSION['delete_query_result'])) {
	if ($_SESSION['delete_query_result']) {
		$message = "<p class = 'successText'>Entry was successfully deleted.</p>";
	}
	else {
		$message = "<p class = 'failedText'>Entry was not deleted.</p>";
	}
	unset($_SESSION['delete_query_result']);
}
if (isset($_SESSION['create_query_result'])) {
	if ($_SESSION['create_query_result']) {
		$message = "<p class = 'successText'>Entry was successfully created.</p>";
	}
	else {
		$message = "<p class = 'failedText'>Entry was not created.</p>";
	}
	unset($_SESSION['create_query_result']);
}
if ($message) { echo $message; }
include $_SERVER['DOCUMENT_ROOT'] . '/671Project/admin/templates/AdminFooter.php';
?>
